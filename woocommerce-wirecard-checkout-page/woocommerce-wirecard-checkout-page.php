<?php
/**
 * @package Wirecard Checkout Page
 */
/*
Plugin Name: Wirecard Checkout Page
Plugin URI: http://www.wirecard.at/integration/plugins/
Description: Wirecard is a popular payment service provider (PSP) and has connections with over 20 national and international currencies.
Version: 1.3.11
Author: Wirecard
Author URI: http://www.wirecard.at/
License: Proprietary
*/

/*
 * Shop System Plugins - Terms of use
 *
 * This terms of use regulates warranty and liability between Wirecard Central Eastern Europe (subsequently referred to as WDCEE) and it's
 * contractual partners (subsequently referred to as customer or customers) which are related to the use of plugins provided by WDCEE.
 *
 * The Plugin is provided by WDCEE free of charge for it's customers and must be used for the purpose of WDCEE's payment platform
 * integration only. It explicitly is not part of the general contract between WDCEE and it's customer. The plugin has successfully been tested
 * under specific circumstances which are defined as the shopsystem's standard configuration (vendor's delivery state). The Customer is
 * responsible for testing the plugin's functionality before putting it into production enviroment.
 * The customer uses the plugin at own risk. WDCEE does not guarantee it's full functionality neither does WDCEE assume liability for any
 * disadvantage related to the use of this plugin. By installing the plugin into the shopsystem the customer agrees to the terms of use.
 * Please do not use this plugin if you do not agree to the terms of use!
 */

// coding standards: https://codex.wordpress.org/WordPress_Coding_Standards

// po File erzeugen: xgettext -k__ -L php class-woocommerce-wcp-gateway.php -o languages/woocommerce-wcp-en_US.po
// im po File charset=UTF-8 setzen
// mo File erzeugen msgfmt woocommerce-wcp-en_US.po -o woocommerce-wcp-en_US.mo
// en_US muss nicht übersetzt werden

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'WOOCOMMERCE_GATEWAY_WCP_BASEDIR', plugin_dir_path( __FILE__ ) );
define( 'WOOCOMMERCE_GATEWAY_WCP_URL', plugin_dir_url( __FILE__ ) );


require_once 'vendor/autoload.php';

load_plugin_textdomain( 'woocommerce-wcp', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

register_activation_hook( __FILE__, 'woocommerce_install_wirecard_checkout_page' );

register_uninstall_hook( __FILE__, 'woocommerce_uninstall_wirecard_checkout_page' );

add_action( 'plugins_loaded', 'woocommerce_init_wirecard_checkout_page' );

function woocommerce_install_wirecard_checkout_page()
{
    // no custom table is needed, we use update_post_meta()
}


function woocommerce_uninstall_wirecard_checkout_page()
{
}

function woocommerce_init_wirecard_checkout_page()
{
    if ( ! class_exists( 'WC_Payment_Gateway' ) )
        return;

    require_once( WOOCOMMERCE_GATEWAY_WCP_BASEDIR . 'class-woocommerce-wcp-gateway.php' );

    add_filter( 'woocommerce_payment_gateways', 'woocommerce_add_wirecard_checkout_page' );
}


/**
 * Add the gateway to woocommerce
 */
function woocommerce_add_wirecard_checkout_page( $methods ) {
    $methods[] = 'WC_Gateway_WCP';
    return $methods;
}

