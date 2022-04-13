<?php
/**
 * @package Qenta Checkout Page
 */
/*
Plugin Name: Qenta Checkout Page
Plugin URI: http://www.qenta.com/integration/plugins/
Description: Qenta is a popular payment service provider (PSP) and has connections with over 20 national and international currencies.
Version: 2.0.3
Author: Qenta
Author URI: http://www.qenta-cee.at/
License: Proprietary
*/

/*
 * Shop System Plugins - Terms of use
 *
 * This terms of use regulates warranty and liability between Qenta Payment CEE GmbH (subsequently referred to as QCEE) and it's
 * contractual partners (subsequently referred to as customer or customers) which are related to the use of plugins provided by QCEE.
 *
 * The Plugin is provided by QCEE free of charge for it's customers and must be used for the purpose of QCEE's payment platform
 * integration only. It explicitly is not part of the general contract between QCEE and it's customer. The plugin has successfully been tested
 * under specific circumstances which are defined as the shopsystem's standard configuration (vendor's delivery state). The Customer is
 * responsible for testing the plugin's functionality before putting it into production enviroment.
 * The customer uses the plugin at own risk. QCEE does not guarantee it's full functionality neither does QCEE assume liability for any
 * disadvantage related to the use of this plugin. By installing the plugin into the shopsystem the customer agrees to the terms of use.
 * Please do not use this plugin if you do not agree to the terms of use!
 */

// coding standards: https://codex.wordpress.org/WordPress_Coding_Standards

// po File erzeugen: xgettext -k__ -L php class-woocommerce-qcp-gateway.php -o languages/woocommerce-qcp-en_US.po
// im po File charset=UTF-8 setzen
// mo File erzeugen msgfmt woocommerce-qcp-en_US.po -o woocommerce-qcp-en_US.mo
// en_US muss nicht übersetzt werden

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'WOOCOMMERCE_GATEWAY_QCP_BASEDIR', plugin_dir_path( __FILE__ ) );
define( 'WOOCOMMERCE_GATEWAY_QCP_URL', plugin_dir_url( __FILE__ ) );


require_once 'vendor/autoload.php';

load_plugin_textdomain( 'woocommerce-qcp', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

register_activation_hook( __FILE__, 'woocommerce_install_qenta_checkout_page' );

register_uninstall_hook( __FILE__, 'woocommerce_uninstall_qenta_checkout_page' );

add_action( 'plugins_loaded', 'woocommerce_init_qenta_checkout_page' );

function woocommerce_install_qenta_checkout_page()
{
    // no custom table is needed, we use update_post_meta()
}


function woocommerce_uninstall_qenta_checkout_page()
{
}

function woocommerce_init_qenta_checkout_page()
{
    if ( ! class_exists( 'WC_Payment_Gateway' ) )
        return;

    require_once( WOOCOMMERCE_GATEWAY_QCP_BASEDIR . 'class-woocommerce-qcp-gateway.php' );

    add_filter( 'woocommerce_payment_gateways', 'woocommerce_add_qenta_checkout_page' );
    add_filter( 'default_checkout_billing_country', 'qcp_change_default_checkout_country' );
    add_filter( 'default_checkout_shipping_country', 'qcp_change_default_checkout_country' );
}

/**
 * Return default billing country
 **/
function qcp_change_default_checkout_country() {
  return getenv('DEFAULT_COUNTRY_CODE') ?: 'AT';
}

/**
 * Add the gateway to woocommerce
 */
function woocommerce_add_qenta_checkout_page( $methods ) {
    $methods[] = 'WC_Gateway_QCP';
    return $methods;
}

