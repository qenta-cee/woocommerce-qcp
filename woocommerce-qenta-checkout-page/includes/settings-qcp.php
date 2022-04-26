<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// set shop logo, if custom logo exists
$logo = wp_get_attachment_image_src(get_theme_mod( 'custom_logo' ), 'full' );
$logo_url = $logo[0];
$logo_width = $logo[1];
$logo_height = $logo[2];

/**
 * Settings for QentaCheckoutPage.
 */
return array(
	'basic_settings'           => array(
		'title'       => __( 'Access data', 'woocommerce-qcp' ),
		'type'        => 'title',
		'description' => __( 'Enter access data for using Qenta Checkout Page.', 'woocommerce-qcp' ),
	),
	'configuration'            => array(
		'title'       => __( 'Configuration', 'woocommerce-qcp' ),
		'type'        => 'select',
		'class'       => 'wc-enhanced-select',
		'description' => __( 'For integration, select predefined configuration settings or \'Production\' for live systems',
			'woocommerce-qcp' ),
		'default'     => 'demo',
		'desc_tip'    => false,
		'options'     => array(
			'demo'       => __( 'Demo', 'woocommerce-qcp' ),
			'test3d'     => __( 'Test', 'woocommerce-qcp' ),
			'production' => __( 'Production', 'woocommerce-qcp' )
		)
	),
	'customer_id'              => array(
		'title'       => __( 'Customer ID', 'woocommerce-qcp' ),
		'type'        => 'text',
		'default'     => 'D200001',
		'description' => sprintf( __( 'Customer number you received from Qenta (customerId, i.e. D2#####). <a href="%s">More information</a>',
			'woocommerce-qcp' ), 'https://guides.qenta.com/parameters/detailed-description/#customerId' ),
		'desc_tip'    => false
	),
	'shop_id'                  => array(
		'title'       => __( 'Shop ID', 'woocommerce-qcp' ),
		'type'        => 'text',
		'default'     => '',
		'description' => sprintf( __( 'Shop identifier in case of more than one shop. <a href="%s">More information</a>',
			'woocommerce-qcp' ), 'https://guides.qenta.com/parameters/detailed-description/#shopId' ),
		'desc_tip'    => false
	),
	'secret'                   => array(
		'title'       => __( 'Secret', 'woocommerce-qcp' ),
		'type'        => 'text',
		'default'     => 'B8AKTPWBRMNBV455FG6M2DANE99WU2',
		'description' => sprintf( __( 'String which you received from Qenta for signing and validating data to prove their authenticity. <a href="%s">More information</a>',
			'woocommerce-qcp' ), 'https://guides.qenta.com/products/securing-your-online-shop/#secret' ),
		'desc_tip'    => false
	),
	'service_url'              => array(
		'title'       => __( 'URL to contact page', 'woocommerce-qcp' ),
		'type'        => 'text',
		'default'     => get_permalink( wc_get_page_id( 'shop' ) ),
		'description' => __(
			'URL to web page containing your contact information (imprint).',
			'woocommerce-qcp'
		),
		'desc_tip'    => false
	),
	'basic_settings_end' => array(
		'title' => '<hr/>',
		'type' => 'title'
	),
	// payment types
	'payment_selection'        => array(
		'title'       => __( 'Payment methods', 'woocommerce-qcp' ),
		'type'        => 'title',
		'description' => __( 'Enable payment methods.', 'woocommerce-qcp' )
	),
	'pt_select'                => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'select' ),
		'default' => 'no',
	),
	'pt_ccard'                 => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'ccard' ),
		'default' => 'yes',
	),
	'pt_afterpay'                 => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'afterpay' ),
		'default' => 'no',
	),
  'pt_eps'                   => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'eps' ),
		'default' => 'yes',
	),
	'pt_crypto'    => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'crypto' ),
		'default' => 'no',
	),
	'pt_paypal'                => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'paypal' ),
		'default' => 'no',
	),
	'pt_psc'                   => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'psc' ),
		'default' => 'no',
	),
	'pt_przelewy24'            => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'przelewy24' ),
		'default' => 'no',
	),
  'pt_sofortueberweisung'    => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'sofort' ),
		'default' => 'yes',
	),
	'pt_sepa-dd'                  => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'sepa' ),
		'default' => 'yes',
	),
	'pt_invoice'               => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'invoice' ),
		'default' => 'yes',
	),
	'paymenttypes_end' => array(
		'title' => '<hr/>',
		'type' => 'title'
	),
	'additional_settings'      => array(
		'title' => __( 'Additional settings', 'woocommerce-qcp' ),
		'type'  => 'title',
	),
	'image_url'                => array(
		'title'       => __( 'URL to image on payment page', 'woocommerce-qcp' ),
		'type'        => 'text',
		'default'     => esc_url($logo_url),
		'description' => __(
			'Image Url for displaying an image on the Qenta Checkout Page (95x65 pixels preferred).',
			'woocommerce-qcp'
		),
		'desc_tip'    => false
	),
	'max_retries'              => array(
		'title'       => __( 'Max. retries', 'woocommerce-qcp' ),
		'type'        => 'text',
		'default'     => '-1',
		'description' => __( 'Maximal number of payment retries.', 'woocommerce-qcp' ),
		'desc_tip'    => false
	),
	'display_text'             => array(
		'title'       => __( 'Display text', 'woocommerce-qcp' ),
		'type'        => 'text',
		'description' => __( 'Display Text on the Qenta Checkout Page.', 'woocommerce-qcp' ),
		'desc_tip'    => false
	),
	'payolution_mid' => array(
		'title' => __('payolution mID', 'woocommerce-qcp'),
		'type' => 'text',
		'default' => '',
		'description' => __( 'Your payolution merchant ID, non-base64-encoded.', 'woocommerce-qcp' ),
		'desc_tip' => false
	),
	'payolution_terms' => array(
		'title' => __('payolution terms', 'woocommerce-qcp'),
		'type' => 'checkbox',
		'default' => 'no',
		'description' => sprintf( __( 'Consumer must accept payolution terms during the checkout process. <a href="%s">More information</a>', 'woocommerce-qcp'), 'https://guides.qenta.com/payment-methods/payolution/' ),
		'desc_tip' => false,
		'label' => __('Enable/Disable', 'woocommerce-qcp')
	),
	'debug'                    => array(
		'type'    => 'checkbox',
		'default' => 'no',
		'title'   => __( 'Debug Log', 'woocommerce-qcp' ),
		'description' => __( 'Log Qenta Checkout Page events.', 'woocommerce-qcp' ),
		'desc_tip' => false,
		'label'   => __( 'Enable/Disable', 'woocommerce-qcp' )
	),
	'send_consumer_shipping'   => array(
		'type'        => 'checkbox',
		'title'       => __( 'Forward consumer shipping data', 'woocommerce-qcp' ),
		'default'     => 'yes',
		'description' => __( 'Forwarding shipping data about your consumer to the respective financial service provider.',
			'woocommerce-qcp' ),
		'desc_tip'    => false,
		'label'       => __( 'Enable/Disable', 'woocommerce-qcp' )
	),
	'send_consumer_billing'    => array(
		'type'        => 'checkbox',
		'title'       => __( 'Forward consumer billing data', 'woocommerce-qcp' ),
		'default'     => 'yes',
		'description' => __( 'Forwarding billing data about your consumer to the respective financial service provider.',
			'woocommerce-qcp' ),
		'desc_tip'    => false,
		'label'       => __( 'Enable/Disable', 'woocommerce-qcp' )
	),
	'send_basket_data'         => array(
		'type'        => 'checkbox',
		'title'       => __( 'Forward basket data', 'woocommerce-qcp' ),
		'default'     => 'yes',
		'description' => __( 'Forwarding basket data to the respective financial service provider.',
			'woocommerce-qcp' ),
		'desc_tip'    => false,
		'label'       => __( 'Enable/Disable', 'woocommerce-qcp' )
	),
	'additional_settings_end' => array(
		'title' => '<hr/>',
		'type' => 'title'
	),
	'invoice_settings'      => array(
		'title' => __( 'Invoice settings', 'woocommerce-qcp' ),
		'type'  => 'title'
	),
	'invoice_provider'            => array(
		'title'       => __( 'Invoice Provider', 'woocommerce-qcp' ),
		'type'        => 'select',
		'class'       => 'wc-enhanced-select',
		'description' => __( 'Choose your invoice provider.', 'woocommerce-qcp' ),
		'default'     => 'payolution',
		'desc_tip'    => false,
		'options'     => array(
			'payolution'       => __( 'payolution', 'woocommerce-qcp' ),
			'qenta'     => __( 'Qenta', 'woocommerce-qcp' )
		)
	),
	'invoice_shipping' => array(
		'title' => __('Billing/shipping address must be identical', 'woocommerce-qcp'),
		'type' => 'checkbox',
		'default' => 'no',
		'description' => __('Only applicable for payolution', 'woocommerce-qcp'),
		'desc_tip' => false,
		'label' => __('Enable/Disable', 'woocommerce-qcp')
	),
	'invoice_billing_countries' => array(
		'title' => __('Allowed billing countries', 'woocommerce-qcp'),
		'type' => 'multiselect',
		'class' => 'wc-enhanced-select',
		'default' => array('AT','DE','CH'),
		'options' => $this->countries
	),
	'invoice_shipping_countries' => array(
		'title' => __('Allowed shipping countries', 'woocommerce-qcp'),
		'type' => 'multiselect',
		'class' => 'wc-enhanced-select',
		'default' => array('AT', 'DE', 'CH'),
		'options' => $this->countries
	),
	'invoice_currencies' => array(
		'title' => __('Accepted currencies', 'woocommerce-qcp'),
		'type' => 'multiselect',
		'class' => 'wc-enhanced-select',
		'default' => array('EUR'),
		'options' => $this->currency_code_options
	),
	'invoice_min_amount'       => array(
		'type'        => 'text',
		'title'       => __( 'Minimum amount', 'woocommerce-qcp' ),
		'default'     => '10'
	),
	'invoice_max_amount'       => array(
		'type'        => 'text',
		'title'       => __( 'Maximum amount', 'woocommerce-qcp' ),
		'default'     => '3500'
	),
	'invoice_settings_end' => array(
		'title' => '<hr/>',
		'type' => 'title'
	)
);