<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Settings for WirecardCheckoutPage.
 */
return array(
	'basic_settings'           => array(
		'title'       => __('Basic settings', 'woocommerce-wcp'),
		'type'        => 'title',
		'description' => __('Enter basic settings for using Wirecard Checkout Page.', 'woocommerce-wcp'),
	),
	'customer_id'              => array(
		'title'       => __( 'Customer Id', 'woocommerce-wcp' ),
		'type'        => 'text',
		'default'     => 'D200001',
		'description' => __( 'Wirecard CEE Customer Id.', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'shop_id'                  => array(
		'title'       => __( 'Shop Id', 'woocommerce-wcp' ),
		'type'        => 'text',
		'default'     => '',
		'description' => __( 'Wirecard CEE Shop Id.', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'secret'                   => array(
		'title'       => __( 'Secret', 'woocommerce-wcp' ),
		'type'        => 'text',
		'default'     => '',
		'description' => __( 'Wirecard CEE Secret.', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'service_url'              => array(
		'title'       => __( 'Service Url', 'woocommerce-wcp' ),
		'type'        => 'text',
		'default'     => '',
		'description' => __(
			'Backlink on the Wirecard Checkout Page to your shop, usualy links to contact or imprint page.',
			'woocommerce-wcp'
		),
		'desc_tip'    => true
	),
	// payment types
	'payment_selection'        => array(
		'title'       => __('Payment methods', 'woocommerce-wcp'),
		'type'        => 'title',
		'description' => __('Activate your desired payment methods.', 'woocommerce-wcp')
	),
	'pt_select'                => array(
		'type'        => 'checkbox',
		'label'       => $this->get_paymenttype_name( 'select' ),
		'default'     => 'yes',
		'description' => __( 'Payment is chosen on the Wirecard Checkout Page', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'pt_ccard'                 => array(
		'type'        => 'checkbox',
		'label'       => $this->get_paymenttype_name( 'ccard' ),
		'default'     => 'no',
		'description' => __( 'Credit Card', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'pt_ccard-moto'            => array(
		'type'        => 'checkbox',
		'label'       => $this->get_paymenttype_name( 'ccard-moto' ),
		'default'     => 'no',
		'description' => __( 'Creditcard Mail Order / Telephone Order', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'pt_maestro'               => array(
		'type'        => 'checkbox',
		'label'       => $this->get_paymenttype_name( 'maestro' ),
		'default'     => 'no',
		'description' => __( 'Maestro SecureCode', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'pt_eps'                   => array(
		'type'        => 'checkbox',
		'label'       => $this->get_paymenttype_name( 'eps' ),
		'default'     => 'no',
		'description' => __( 'eps Online Bank Transfer', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'pt_idl'                   => array(
		'type'        => 'checkbox',
		'label'       => $this->get_paymenttype_name( 'idl' ),
		'default'     => 'no',
		'description' => __( 'iDEAL', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'pt_giropay'               => array(
		'type'        => 'checkbox',
		'label'       => $this->get_paymenttype_name( 'giropay' ),
		'default'     => 'no',
		'description' => __( 'giropay', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'pt_sofortueberweisung'    => array(
		'type'        => 'checkbox',
		'label'       => $this->get_paymenttype_name( 'sofort' ),
		'default'     => 'no',
		'description' => __( 'SOFORT banking', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'pt_pbx'                   => array(
		'type'        => 'checkbox',
		'label'       => $this->get_paymenttype_name( 'pbx' ),
		'default'     => 'no',
		'description' => __( 'paybox', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'pt_psc'                   => array(
		'type'        => 'checkbox',
		'label'       => $this->get_paymenttype_name( 'psc' ),
		'default'     => 'no',
		'description' => __( 'paysafecard', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'pt_quick'                 => array(
		'type'        => 'checkbox',
		'label'       => $this->get_paymenttype_name( 'quick' ),
		'default'     => 'no',
		'description' => __( '@QUICK', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'pt_paypal'                => array(
		'type'        => 'checkbox',
		'label'       => $this->get_paymenttype_name( 'paypal' ),
		'default'     => 'no',
		'description' => __( 'PayPal', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'pt_sepa'                  => array(
		'type'        => 'checkbox',
		'label'       => $this->get_paymenttype_name( 'sepa' ),
		'default'     => 'no',
		'description' => __( 'SEPA Direct Debit', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'pt_invoice'               => array(
		'type'        => 'checkbox',
		'label'       => $this->get_paymenttype_name( 'invoice' ),
		'default'     => 'no',
		'description' => __( 'Invoice', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'pt_installment'           => array(
		'type'        => 'checkbox',
		'label'       => __( 'Installment', 'woocommerce-wcp' ),
		'default'     => 'no',
		'description' => __( 'Installment', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'pt_bancontact_mistercash' => array(
		'type'        => 'checkbox',
		'label'       => $this->get_paymenttype_name( 'bancontact_mistercash' ),
		'default'     => 'no',
		'description' => __( 'Bancontact', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'pt_przelewy24'            => array(
		'type'        => 'checkbox',
		'label'       => $this->get_paymenttype_name( 'przelewy24' ),
		'default'     => 'no',
		'description' => __( 'Przelewy24', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'pt_moneta'                => array(
		'type'        => 'checkbox',
		'label'       => $this->get_paymenttype_name( 'moneta' ),
		'default'     => 'no',
		'description' => __( 'moneta.ru', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'pt_poli'                  => array(
		'type'        => 'checkbox',
		'label'       => $this->get_paymenttype_name( 'poli' ),
		'default'     => 'no',
		'description' => __( 'POLi', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'pt_ekonto'                => array(
		'type'        => 'checkbox',
		'label'       => $this->get_paymenttype_name( 'ekonto' ),
		'default'     => 'no',
		'description' => __( 'eKonto', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'pt_trustly'      => array(
		'type'        => 'checkbox',
		'label'       => $this->get_paymenttype_name( 'trustly' ),
		'default'     => 'no',
		'description' => __( 'Trustly', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'pt_mpass'                 => array(
		'type'        => 'checkbox',
		'label'       => $this->get_paymenttype_name( 'mpass' ),
		'default'     => 'no',
		'description' => __( 'mpass', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'pt_skrillwallet'          => array(
		'type'        => 'checkbox',
		'label'       => $this->get_paymenttype_name( 'skrillwallet' ),
		'default'     => 'no',
		'description' => __( 'Skrill Digital Wallet', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'additional_settings'      => array(
		'title'       => __('Additional settings', 'woocommerce-wcp'),
		'type'        => 'title',
	),
	'image_url'                => array(
		'title'       => __( 'Image Url', 'woocommerce-wcp' ),
		'type'        => 'text',
		'default'     => '',
		'description' => __(
			'Image Url for displaying an image on the Wirecard Checkout Page (95x65 pixels preferred).',
			'woocommerce-wcp'
		),
		'desc_tip'    => true
	),
	'max_retries'              => array(
		'title'       => __( 'Max. retries', 'woocommerce-wcp' ),
		'type'        => 'text',
		'default'     => '-1',
		'description' => __( 'Maximal number of payment retries.', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'display_text'             => array(
		'title'       => __( 'Display text', 'woocommerce-wcp' ),
		'type'        => 'text',
		'description' => __( 'Display Text on the Wirecard Checkout Page.', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'debug'                    => array(
		'type'        => 'checkbox',
		'default'     => 'no',
		'label'       => __( 'Debug Log', 'woocommerce-wcp' ),
		'description' => __( 'Log Wirecard Checkout Page events.', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'auto_deposit'             => array(
		'type'        => 'checkbox',
		'label'       => __( 'Enable auto deposit', 'woocommerce-wcp' ),
		'default'     => 'yes',
		'description' => __( 'Auto deposit.', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'send_additional_data'     => array(
		'type'        => 'checkbox',
		'label'       => __( 'Send additional data', 'woocommerce-wcp' ),
		'default'     => 'no',
		'description' => __( 'Send additional customer information.', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'use_iframe'               => array(
		'type'        => 'checkbox',
		'label'       => __( 'Use Iframe', 'woocommerce-wcp' ),
		'default'     => 'no',
		'description' => __( 'Use Iframe.', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'invoice_installment'      => array(
		'title'       => __('Invoice/Installment settings', 'woocommerce-wcp'),
		'type'        => 'title'
	),
	'invoice_min_amount'       => array(
		'type'        => 'text',
		'title'       => __( 'Invoice minimum amount', 'woocommerce-wcp' ),
		'default'     => '100',
		'description' => __( 'Invoice minimum amount.', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'invoice_max_amount'       => array(
		'type'        => 'text',
		'title'       => __( 'Invoice maximum amount', 'woocommerce-wcp' ),
		'default'     => '1000',
		'description' => __( 'Invoice maximum amount.', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'installment_min_amount'   => array(
		'type'        => 'text',
		'title'       => __( 'Installment minimum amount', 'woocommerce-wcp' ),
		'default'     => '100',
		'description' => __( 'Installment minimum amount.', 'woocommerce-wcp' ),
		'desc_tip'    => true
	),
	'installment_max_amount'   => array(
		'type'        => 'text',
		'title'       => __( 'Installment maximum amount', 'woocommerce-wcp' ),
		'default'     => '1000',
		'description' => __( 'Installment maximum amount.', 'woocommerce-wcp' ),
		'desc_tip'    => true
	)
);