<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Settings for QentaCheckoutPage.
 */
return array(
	'basic_settings'           => array(
		'title'       => __( 'Access data', 'woocommerce-wcp' ),
		'type'        => 'title',
		'description' => __( 'Enter access data for using Qenta Checkout Page.', 'woocommerce-wcp' ),
	),
	'configuration'            => array(
		'title'       => __( 'Configuration', 'woocommerce-wcp' ),
		'type'        => 'select',
		'class'       => 'wc-enhanced-select',
		'description' => __( 'For integration, select predefined configuration settings or \'Production\' for live systems',
			'woocommerce-wcp' ),
		'default'     => 'demo',
		'desc_tip'    => false,
		'options'     => array(
			'demo'       => __( 'Demo', 'woocommerce-wcp' ),
			'test'       => __( 'Test', 'woocommerce-wcp' ),
			'test3d'     => __( 'Test 3D', 'woocommerce-wcp' ),
			'production' => __( 'Production', 'woocommerce-wcp' )
		)
	),
	'customer_id'              => array(
		'title'       => __( 'Customer ID', 'woocommerce-wcp' ),
		'type'        => 'text',
		'default'     => 'D200001',
		'description' => sprintf( __( 'Customer number you received from Qenta (customerId, i.e. D2#####). <a href="%s">More information</a>',
			'woocommerce-wcp' ), 'https://guides.qenta.com/request_parameters#customerid' ),
		'desc_tip'    => false
	),
	'shop_id'                  => array(
		'title'       => __( 'Shop ID', 'woocommerce-wcp' ),
		'type'        => 'text',
		'default'     => '',
		'description' => sprintf( __( 'Shop identifier in case of more than one shop. <a href="%s">More information</a>',
			'woocommerce-wcp' ), 'https://guides.qenta.com/request_parameters#shopid' ),
		'desc_tip'    => false
	),
	'secret'                   => array(
		'title'       => __( 'Secret', 'woocommerce-wcp' ),
		'type'        => 'text',
		'default'     => '',
		'description' => sprintf( __( 'String which you received from Qenta for signing and validating data to prove their authenticity. <a href="%s">More information</a>',
			'woocommerce-wcp' ), 'https://guides.qenta.com/security:start#secret_and_fingerprint' ),
		'desc_tip'    => false
	),
	'service_url'              => array(
		'title'       => __( 'URL to contact page', 'woocommerce-wcp' ),
		'type'        => 'text',
		'default'     => '',
		'description' => __(
			'URL to web page containing your contact information (imprint).',
			'woocommerce-wcp'
		),
		'desc_tip'    => false
	),
	'basic_settings_end' => array(
		'title' => '<hr/>',
		'type' => 'title'
	),
	// payment types
	'payment_selection'        => array(
		'title'       => __( 'Payment methods', 'woocommerce-wcp' ),
		'type'        => 'title',
		'description' => __( 'Enable your desired payment methods.', 'woocommerce-wcp' )
	),
	'pt_select'                => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'select' ),
		'default' => 'no',
	),
	'pt_ccard'                 => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'ccard' ),
		'default' => 'no',
	),
	'pt_masterpass'            => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'masterpass' ),
		'default' => 'no',
	),
	'pt_ccard-moto'            => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'ccard-moto' ),
		'default' => 'no',
	),
	'pt_maestro'               => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'maestro' ),
		'default' => 'no',
	),
	'pt_eps'                   => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'eps' ),
		'default' => 'no',
	),
	'pt_idl'                   => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'idl' ),
		'default' => 'no',
	),
	'pt_giropay'               => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'giropay' ),
		'default' => 'no',
	),
	'pt_sofortueberweisung'    => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'sofort' ),
		'default' => 'no',
	),
	'pt_pbx'                   => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'pbx' ),
		'default' => 'no',
	),
	'pt_psc'                   => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'psc' ),
		'default' => 'no',
	),
	'pt_quick'                 => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'quick' ),
		'default' => 'no',
	),
	'pt_paypal'                => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'paypal' ),
		'default' => 'no',
	),
	'pt_sepa-dd'                  => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'sepa' ),
		'default' => 'no',
	),
	'pt_invoice'               => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'invoice' ),
		'default' => 'no',
	),
	'pt_installment'           => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'installment' ),
		'default' => 'no',
	),
	'pt_bancontact_mistercash' => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'bancontact_mistercash' ),
		'default' => 'no',
	),
	'pt_przelewy24'            => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'przelewy24' ),
		'default' => 'no',
	),
	'pt_moneta'                => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'moneta' ),
		'default' => 'no',
	),
	'pt_poli'                  => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'poli' ),
		'default' => 'no',
	),
	'pt_ekonto'                => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'ekonto' ),
		'default' => 'no',
	),
	'pt_trustly'               => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'trustly' ),
		'default' => 'no',
	),
	'pt_skrillwallet'          => array(
		'type'    => 'checkbox',
		'label'   => $this->get_paymenttype_name( 'skrillwallet' ),
		'default' => 'no',
	),
	'paymenttypes_end' => array(
		'title' => '<hr/>',
		'type' => 'title'
	),
	'additional_settings'      => array(
		'title' => __( 'Additional settings', 'woocommerce-wcp' ),
		'type'  => 'title',
	),
	'image_url'                => array(
		'title'       => __( 'URL to image on payment page', 'woocommerce-wcp' ),
		'type'        => 'text',
		'default'     => '',
		'description' => __(
			'Image Url for displaying an image on the Qenta Checkout Page (95x65 pixels preferred).',
			'woocommerce-wcp'
		),
		'desc_tip'    => false
	),
	'max_retries'              => array(
		'title'       => __( 'Max. retries', 'woocommerce-wcp' ),
		'type'        => 'text',
		'default'     => '-1',
		'description' => __( 'Maximal number of payment retries.', 'woocommerce-wcp' ),
		'desc_tip'    => false
	),
	'display_text'             => array(
		'title'       => __( 'Display text', 'woocommerce-wcp' ),
		'type'        => 'text',
		'description' => __( 'Display Text on the Qenta Checkout Page.', 'woocommerce-wcp' ),
		'desc_tip'    => false
	),
	'payolution_mid' => array(
		'title' => __('payolution mID', 'woocommerce-wcp'),
		'type' => 'text',
		'default' => '',
		'description' => __( 'Your payolution merchant ID, non-base64-encoded.', 'woocommerce-wcp' ),
		'desc_tip' => false
	),
	'payolution_terms' => array(
		'title' => __('payolution terms', 'woocommerce-wcp'),
		'type' => 'checkbox',
		'default' => 'no',
		'description' => sprintf( __( 'Consumer must accept payolution terms during the checkout process. <a href="%s">More information</a>', 'woocommerce-wcp'), 'https://guides.qenta.com/payment_methods:invoice:payolution' ),
		'desc_tip' => false,
		'label' => __('Enable/Disable', 'woocommerce-wcp')
	),
	'debug'                    => array(
		'type'    => 'checkbox',
		'default' => 'no',
		'title'   => __( 'Debug Log', 'woocommerce-wcp' ),
		'description' => __( 'Log Qenta Checkout Page events.', 'woocommerce-wcp' ),
		'desc_tip' => false,
		'label'   => __( 'Enable/Disable', 'woocommerce-wcp' )
	),
	'send_consumer_shipping'   => array(
		'type'        => 'checkbox',
		'title'       => __( 'Forward consumer shipping data', 'woocommerce-wcp' ),
		'default'     => 'no',
		'description' => __( 'Forwarding shipping data about your consumer to the respective financial service provider.',
			'woocommerce-wcp' ),
		'desc_tip'    => false,
		'label'       => __( 'Enable/Disable', 'woocommerce-wcp' )
	),
	'send_consumer_billing'    => array(
		'type'        => 'checkbox',
		'title'       => __( 'Forward consumer billing data', 'woocommerce-wcp' ),
		'default'     => 'no',
		'description' => __( 'Forwarding billing data about your consumer to the respective financial service provider.',
			'woocommerce-wcp' ),
		'desc_tip'    => false,
		'label'       => __( 'Enable/Disable', 'woocommerce-wcp' )
	),
	'send_basket_data'         => array(
		'type'        => 'checkbox',
		'title'       => __( 'Forward basket data', 'woocommerce-wcp' ),
		'default'     => 'no',
		'description' => __( 'Forwarding basket data to the respective financial service provider.',
			'woocommerce-wcp' ),
		'desc_tip'    => false,
		'label'       => __( 'Enable/Disable', 'woocommerce-wcp' )
	),
	'additional_settings_end' => array(
		'title' => '<hr/>',
		'type' => 'title'
	),
	'invoice_settings'      => array(
		'title' => __( 'Invoice settings', 'woocommerce-wcp' ),
		'type'  => 'title'
	),
	'invoice_provider'            => array(
		'title'       => __( 'Invoice Provider', 'woocommerce-wcp' ),
		'type'        => 'select',
		'class'       => 'wc-enhanced-select',
		'description' => __( 'Choose your invoice provider.', 'woocommerce-wcp' ),
		'default'     => 'payolution',
		'desc_tip'    => false,
		'options'     => array(
			'payolution'       => __( 'payolution', 'woocommerce-wcp' ),
			'ratepay'       => __( 'RatePay', 'woocommerce-wcp' ),
			'qenta'     => __( 'Qenta', 'woocommerce-wcp' )
		)
	),
	'invoice_shipping' => array(
		'title' => __('Billing/shipping address must be identical', 'woocommerce-wcp'),
		'type' => 'checkbox',
		'default' => 'no',
		'description' => __('Only applicable for payolution', 'woocommerce-wcp'),
		'desc_tip' => false,
		'label' => __('Enable/Disable', 'woocommerce-wcp')
	),
	'invoice_billing_countries' => array(
		'title' => __('Allowed billing countries', 'woocommerce-wcp'),
		'type' => 'multiselect',
		'class' => 'wc-enhanced-select',
		'default' => array('AT','DE','CH'),
		'options' => $this->countries
	),
	'invoice_shipping_countries' => array(
		'title' => __('Allowed shipping countries', 'woocommerce-wcp'),
		'type' => 'multiselect',
		'class' => 'wc-enhanced-select',
		'default' => array('AT', 'DE', 'CH'),
		'options' => $this->countries
	),
	'invoice_currencies' => array(
		'title' => __('Accepted currencies', 'woocommerce-wcp'),
		'type' => 'multiselect',
		'class' => 'wc-enhanced-select',
		'default' => array('EUR'),
		'options' => $this->currency_code_options
	),
	'invoice_min_amount'       => array(
		'type'        => 'text',
		'title'       => __( 'Minimum amount', 'woocommerce-wcp' ),
		'default'     => '10'
	),
	'invoice_max_amount'       => array(
		'type'        => 'text',
		'title'       => __( 'Maximum amount', 'woocommerce-wcp' ),
		'default'     => '3500'
	),
	'invoice_settings_end' => array(
		'title' => '<hr/>',
		'type' => 'title'
	),
	'installment_settings'      => array(
		'title' => __( 'Installment settings', 'woocommerce-wcp' ),
		'type'  => 'title'
	),
	'installment_provider'            => array(
		'title'       => __( 'Installment Provider', 'woocommerce-wcp' ),
		'type'        => 'select',
		'class'       => 'wc-enhanced-select',
		'description' => __( 'Choose your installment provider.', 'woocommerce-wcp' ),
		'default'     => 'payolution',
		'desc_tip'    => false,
		'options'     => array(
			'payolution'       => __( 'payolution', 'woocommerce-wcp' ),
			'ratepay'       => __( 'RatePay', 'woocommerce-wcp' )
		)
	),
	'installment_shipping' => array(
		'title' => __('Billing/shipping address must be identical', 'woocommerce-wcp'),
		'type' => 'checkbox',
		'default' => 'no',
		'description' => __('Only applicable for payolution', 'woocommerce-wcp'),
		'desc_tip' => false,
		'label' => __('Enable/Disable', 'woocommerce-wcp')
	),
	'installment_billing_countries' => array(
		'title' => __('Allowed billing countries', 'woocommerce-wcp'),
		'type' => 'multiselect',
		'class' => 'wc-enhanced-select',
		'default' => array('AT','DE','CH'),
		'options' => $this->countries
	),
	'installment_shipping_countries' => array(
		'title' => __('Allowed shipping countries', 'woocommerce-wcp'),
		'type' => 'multiselect',
		'class' => 'wc-enhanced-select',
		'default' => array('AT', 'DE', 'CH'),
		'options' => $this->countries
	),
	'installment_currencies' => array(
		'title' => __('Accepted currencies', 'woocommerce-wcp'),
		'type' => 'multiselect',
		'class' => 'wc-enhanced-select',
		'default' => array('EUR'),
		'options' => $this->currency_code_options
	),
	'installment_min_amount'   => array(
		'type'        => 'text',
		'title'       => __( 'Minimum amount', 'woocommerce-wcp' ),
		'default'     => '10'
	),
	'installment_max_amount'   => array(
		'type'        => 'text',
		'title'       => __( 'Maximum amount', 'woocommerce-wcp' ),
		'default'     => '3500'
	)
);