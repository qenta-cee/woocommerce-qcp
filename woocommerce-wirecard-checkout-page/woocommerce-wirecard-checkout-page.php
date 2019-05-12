<?php
/**
 * Wirecard Checkout Page
 *
 * @package     WirecardCheckoutPage
 *
 * @wordpress-plugin
 * Plugin Name: Wirecard Checkout Page
 * Plugin URI:  http://www.wirecard.at/integration/plugins/
 * Description: Wirecard is a popular payment service provider (PSP) and has connections with over 20 national and international currencies.
 * Version:     1.3.10
 * Author:      Wirecard
 * Author URI:  http://www.wirecard.at/
 * License:     Proprietary
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'WOOCOMMERCE_GATEWAY_WCP_BASEDIR', plugin_dir_path( __FILE__ ) );
define( 'WOOCOMMERCE_GATEWAY_WCP_URL', plugin_dir_url( __FILE__ ) );

require_once dirname( __FILE__ ) . '/vendor/autoload.php';

/**
 * Add the gateway to WooCommerce.
 *
 * @param array $methods
 * @return array
 */
function woocommerce_add_wirecard_checkout_page( $methods ) {
    $methods[] = 'WC_Gateway_WCP';
    return $methods;
}

/**
 * Initialize plugin.
 */
function woocommerce_init_wirecard_checkout_page() {
    if ( ! class_exists( 'WC_Payment_Gateway' ) ) {
        return;
    }

    define( 'WOOCOMMERCE_GATEWAY_WCP_NAME', 'Woocommerce2_WirecardCheckoutPage' );
    define( 'WOOCOMMERCE_GATEWAY_WCP_VERSION', '1.3.10' );
    define( 'WOOCOMMERCE_GATEWAY_WCP_WINDOWNAME', 'WirecardCheckoutPageFrame' );
    define( 'WOOCOMMERCE_GATEWAY_WCP_TABLE_NAME', 'woocommerce_wcp_transaction' );

    require_once WOOCOMMERCE_GATEWAY_WCP_BASEDIR . 'classes/class-woocommerce-wcp-config.php';
    require_once WOOCOMMERCE_GATEWAY_WCP_BASEDIR . 'classes/class-woocommerce-wcp-payments.php';
    require_once WOOCOMMERCE_GATEWAY_WCP_BASEDIR . 'class-woocommerce-wcp-gateway.php';

    add_filter( 'woocommerce_payment_gateways', 'woocommerce_add_wirecard_checkout_page' );
}

// Load translations
load_plugin_textdomain( 'woocommerce-wcp', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

// Start!
add_action( 'plugins_loaded', 'woocommerce_init_wirecard_checkout_page' );
