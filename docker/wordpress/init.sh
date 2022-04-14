#!/bin/bash

set -e

touch /tmp/shop.log

# If we are in Github plugin repo CI environment
CI_REPO_URL=${GITHUB_SERVER_URL}/${GITHUB_REPOSITORY}
if [[ ${CI_REPO_URL} == ${PLUGIN_URL//.git/} ]]; then
  PLUGIN_VERSION=${GITHUB_SHA}
  CI='true'
fi

if [[ -z ${WORDPRESS_URL} && ! -e wp-config.php ]]; then
  echo "WORDPRESS_URL not specified."
  if [[ -n ${NGROK_TOKEN} ]]; then 
    echo "Launching ngrok to get temporary URL"
    WORDPRESS_URL=$(ngrok.sh ${NGROK_TOKEN})
  else
    echo "No NGROK_TOKEN specified. Using localhost as URL"
    WORDPRESS_URL=localhost
  fi
fi

echo "Waiting for DB host ${WORDPRESS_DB_HOST}"

while ! mysqladmin ping -h"${WORDPRESS_DB_HOST}" --silent; do
  sleep 10
done

function create_db() {
  echo "Creating Database"

  wp config create \
    --dbhost=${WORDPRESS_DB_HOST} \
    --dbname=${WORDPRESS_DB_NAME} \
    --dbuser=${WORDPRESS_DB_USER} \
    --dbpass=${WORDPRESS_DB_PASS} \
    --locale=${WORDPRESS_LOCALE}
}

function install_core() {
  wp core install \
    --url=${WORDPRESS_URL} \
    --title=${WORDPRESS_TITLE} \
    --admin_user=${WORDPRESS_ADMIN_USER} \
    --admin_password=${WORDPRESS_ADMIN_PASS} \
    --admin_email=${WORDPRESS_ADMIN_EMAIL} \
    --skip-email
}

function install_woocommerce() {
  wp plugin install woocommerce --activate

  echo "Install Sample Data"
  wp plugin install wordpress-importer --activate
  wp import wp-content/plugins/woocommerce/sample-data/sample_products.xml --authors=create
}

function wp_set_array() {
  option_name=${1}
  option_key=${2}
  option_value=${3}
  #wp option get ${option_name} --format=json
  #wp option get ${option_name} --format=json | php -r '$option = json_decode( fgets(STDIN) ); $option->'${option_key}' = '${option_value}'; print json_encode($option);' | wp option set ${option_name} --format=json
}

function install_plugin() {
  STR_PLUGIN=$(get_plugin.sh ${PLUGIN_URL} ${PLUGIN_VERSION})
  PLUGIN_NAME=$(echo ${STR_PLUGIN} | cut -d'^' -f1)
  PATH_TO_ZIP=$(echo ${STR_PLUGIN} | cut -d'^' -f2)
  wp plugin install ${PATH_TO_ZIP} --activate
  wp wc --user=admin payment_gateway update qenta_checkout_page --enabled=true
}

function setup_store() {
  wp theme install twentytwenty --activate
  wp post delete 2 --force
  wp post delete 1 --force
  wp wc --user=admin tool run install_pages
  wp option set woocommerce_onboarding_opt_in "yes"
  wp option set woocommerce_store_address "Store Street 11"
  wp option set woocommerce_store_address_2 ""
  wp option set woocommerce_store_city "Graz"
  wp option set woocommerce_store_postcode "8020"
  wp option set woocommerce_default_country "AT"
  wp option set woocommerce_currency "EUR"
  wp_set_array woocommerce_onboarding_profile skipped 1
  wp option update page_on_front 5
  wp option update show_on_front page
  wp option update blogdescription "QENTA Plugin DEMO"
}

function change_api_uri() {
  PATH_CONF_QMORE='/var/www/html/wp-content/plugins/woocommerce-qenta-checkout-seamless/vendor/qenta/checkout-client-library/src/QentaCEE/QMore/Config/client.config.php'
  PATH_CONF_QPAY='/var/www/html/wp-content/plugins/woocommerce-qenta-checkout-seamless/vendor/qenta/checkout-client-library/src/QentaCEE/QPay/Config/client.config.php'

  DEFAULT_API_URI='https://api.qenta.com'

  new_api_uri_protocol=$(sed -n 's,^\(https\?\):.\+,\1,p' <<< ${1})
  new_api_uri_protocol=${new_api_uri_protocol:-https}
  new_api_uri_hostname=$(sed -n 's,^\(https\?://\)\?\([^:/]\+\).*,\2,p' <<< ${1})
  new_api_uri_port=$(sed -n 's,.\+:\([0-9]\+\).*,\1,p' <<< ${1})
  # unused: path. must be configured then for every single entpoint
  # new_api_uri_path=$(sed -n 's,\(https\?://\)\?[^/]\+\(.\+\),\2,p' <<< ${1})

  new_api_uri_string=${new_api_uri_protocol}://
  new_api_uri_string+=${new_api_uri_hostname}
  [[ -n ${new_api_uri_port} ]] && new_api_uri_string+=':'${new_api_uri_port}

  if [[ -z ${new_api_uri_hostname} ]]; then
    echo "NOTE: API hostname unchanged. Invalid specification: ${1}"
    return 1
  fi

  for config_file in ${PATH_CONF_QMORE} ${PATH_CONF_QPAY}; do
    sed -i 's,'${DEFAULT_API_URI}','${new_api_uri_string}',g' ${config_file}
  done
}

function print_info() {
  echo
  echo '####################################'
  echo
  echo "Shop: https://${WORDPRESS_URL}"
  echo "Admin Panel: https://${WORDPRESS_URL}/wp-admin/"
  echo "Plugin Config: https://${WORDPRESS_URL}/wp-admin/admin.php?page=wc-settings&tab=checkout"
  echo "User: ${WORDPRESS_ADMIN_USER}"
  echo "Password: ${WORDPRESS_ADMIN_PASS}"
  if [[ ${_api_uri_changed} ]]; then
    echo
    echo "API Override: ${OVERRIDE_api_uri}"
  fi
  echo
  echo '####################################'
  echo
}

function _log() {
  echo "${@}" >> /tmp/shop.log
}

if [[ -e wp-config.php ]]; then
  echo "Wordpress detected. Skipping installations"
  WORDPRESS_URL=$(wp option get siteurl | sed 's,^https\?://,,')
else
  cp -r /tmp/wp-data/* /var/www/html/
  create_db
  _log "db created"
  install_core
  _log "wp installed"
  install_woocommerce
  _log "db created"
  setup_store
  _log "store set up"
  if [[ -n ${PLUGIN_URL} ]]; then
    install_plugin
    _log "plugin installed"
  fi
  if [[ -n ${OVERRIDE_api_uri} ]]; then
    change_api_uri "${OVERRIDE_api_uri}" &&
    _log "changed API URL to ${OVERRIDE_api_uri}" &&
    _api_uri_changed=true
  fi
fi
if [[ ${CI} != 'true' ]]; then
  (sleep 1; print_info) &
fi

_log "url=https://${WORDPRESS_URL}"
_log "ready"

echo "ready" > /tmp/debug.log

apache2-foreground "$@"
