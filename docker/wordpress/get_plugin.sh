#!/bin/bash

# Usage:
# get_plugin.sh https://ext.page/plugin-name.zip
# get_plugin.sh https://repo.url/repo.git
# get_plugin.sh https://repo.url/repo.git devel
# get_plugin.sh https://repo.url/repo.git 1.2
# get_plugin.sh https://repo.url/repo.git abc123cba

# output: name-of-plugin::path-to.zip
#    e.g. my-plugin::/tmp/my-plugin.zip

REPO_WS=$(mktemp -d)

# can be zip or repo url
PLUGIN_URL=${1}

# default plugin version if not specified
PLUGIN_VERSION=${2:-master}

function clone() {
  git clone --recursive ${PLUGIN_URL} ${REPO_WS}
  cd ${REPO_WS} && git checkout ${PLUGIN_VERSION}
} 

function create_package() {
  cd ${REPO_WS}
  # if no plugin name given via ENV, use first directory starting with woocommerce-
  [[ -z ${PLUGIN_NAME} ]] && PLUGIN_NAME=$(ls -d woocommerce-*/ | head -n 1 | sed 's,/$,,')
  >&2 composer install
  zip -9r ${REPO_WS}/${PLUGIN_NAME}.zip ${PLUGIN_NAME} &>/dev/null
  PATH_TO_ZIP=${REPO_WS}/${PLUGIN_NAME}.zip
}

cd ${REPO_WS}
if [[ ${PLUGIN_URL} == http*://*.zip ]]; then
  >&2 echo "Using plugin link: ${PLUGIN_URL}"
  ZIP_NAME=$(basename ${PLUGIN_URL})
  curl -s ${PLUGIN_URL} > ${REPO_WS}/${ZIP_NAME}
  PATH_TO_ZIP=${REPO_WS}/${ZIP_NAME}
  PLUGIN_NAME=$(unzip -l ${PATH_TO_ZIP} | sed -n 's/.*\ \(.*\)\/$/\1/p' | head -n 1)
elif [[ ${PLUGIN_URL} == 'local' ]]; then
  >&2 echo "Creating plugin zip of ${PLUGIN_VERSION} from ${PLUGIN_URL}"
  >&2 clone
  create_package
else
  >&2 echo "Creating plugin zip of ${PLUGIN_VERSION} from ${PLUGIN_URL}"
  >&2 clone
  create_package
fi

echo ${PLUGIN_NAME}^${PATH_TO_ZIP}
