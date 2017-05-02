<?php
/*
 * Shop System Plugins - Terms of use This terms of use regulates warranty and liability between Wirecard Central Eastern Europe (subsequently referred to as WDCEE) and it's contractual partners (subsequently referred to as customer or customers) which are related to the use of plugins provided by WDCEE. The Plugin is provided by WDCEE free of charge for it's customers and must be used for the purpose of WDCEE's payment platform integration only. It explicitly is not part of the general contract between WDCEE and it's customer. The plugin has successfully been tested under specific circumstances which are defined as the shopsystem's standard configuration (vendor's delivery state). The Customer is responsible for testing the plugin's functionality before putting it into production enviroment. The customer uses the plugin at own risk. WDCEE does not guarantee it's full functionality neither does WDCEE assume liability for any disadvantage related to the use of this plugin. By installing the plugin into the shopsystem the customer agrees to the terms of use. Please do not use this plugin if you do not agree to the terms of use!
 *
 *  - Support for WooCommerce 2.3 (not backward compatible)
 *  - Removed margin-right of payment type radio button
 *  - Wrapped payment type in div
 *
 */
define( 'WOOCOMMERCE_GATEWAY_WCP_NAME', 'Woocommerce2_WirecardCheckoutPage' );
define( 'WOOCOMMERCE_GATEWAY_WCP_VERSION', '1.2.2' );
define( 'WOOCOMMERCE_GATEWAY_WCP_WINDOWNAME', 'WirecardCheckoutPageFrame' );
define( 'WOOCOMMERCE_GATEWAY_WCP_TABLE_NAME', 'woocommerce_wcp_transaction' );
define( 'WOOCOMMERCE_GATEWAY_WCP_INVOICE_INSTALLMENT_MIN_AGE', 18 );

class WC_Gateway_WCP extends WC_Payment_Gateway {

	/**
	 * @var $log WC_Logger
	 */
	protected $log;

	/**
	 * @var $customer_birthday DateTime
	 */
	protected $customer_birthday;

	function __construct() {
		$this->id                 = 'wirecard_checkout_page';
		$this->icon               = WOOCOMMERCE_GATEWAY_WCP_URL . 'assets/images/wirecard.png';
		$this->has_fields         = false;
		$this->method_title       = __( 'Wirecard Checkout Page', 'woocommerce-wcp' );
		$this->method_description = __(
			"Wirecard CEE is a popular payment service provider (PSP) and has connections with over 20 national and international currencies. ",
			'woocommerce-wcp'
		);

		// Load the form fields
		$this->init_form_fields();

		// Load the settings.
		$this->init_settings();

		$this->title       = $this->settings['title']; // frontend title
		$this->description = $this->settings['description']; // frontend description
		$this->debug       = $this->settings['debug'] == 'yes';
		$this->use_iframe  = $this->get_option( 'use_iframe' ) == 'yes';

		// Hooks
		add_action(
			'woocommerce_update_options_payment_gateways_' . $this->id,
			array(
				$this,
				'process_admin_options'
			)
		); // inherit method
		add_action(
			'woocommerce_thankyou_' . $this->id,
			array(
				$this,
				'thankyou_page_text'
			)
		);

		// iframe only
		if ( $this->use_iframe ) {
			add_action(
				'woocommerce_receipt_' . $this->id,
				array(
					$this,
					'payment_page'
				)
			);
		}

		// Payment listener/API hook
		add_action(
			'woocommerce_api_wc_gateway_wcp',
			array(
				$this,
				'dispatch_callback'
			)
		);

		// custom birthday field
		add_filter(
			'woocommerce_billing_fields',
			array(
				$this,
				'custom_fields'
			)
		);
	}

	/**
	 * Initialise Gateway Settings Form Fields
	 *
	 * @access public
	 * @return void
	 */
	function init_form_fields() {
		$this->form_fields = array(
			'enabled'                  => array(
				'title'   => __( 'Enable/Disable', 'woocommerce-wcp' ),
				'type'    => 'checkbox',
				'label'   => __( 'Enable Wirecard Checkout Page', 'woocommerce-wcp' ),
				'default' => 'yes'
			),
			'title'                    => array(
				'title'       => __( 'Title', 'woocommerce-wcp' ),
				'type'        => 'text',
				'description' => __( 'This controls the title which the user sees during checkout.',
				                     'woocommerce-wcp' ),
				'default'     => __( 'Wirecard', 'woocommerce-wcp' ),
				'desc_tip'    => true
			),
			'description'              => array(
				'title'       => __( 'Description', 'woocommerce-wcp' ),
				'type'        => 'textarea',
				'description' => __(
					'This controls the description which the user sees during checkout.',
					'woocommerce-wcp'
				),
				'default'     => __( 'Pay via Wirecard Checkout Page', 'woocommerce-wcp' ),
				'desc_tip'    => true
			),
			'debug'                    => array(
				'type'        => 'checkbox',
				'default'     => 'no',
				'label'       => __( 'Debug Log', 'woocommerce-wcp' ),
				'description' => __( 'Log Wirecard Checkout Page events.', 'woocommerce-wcp' ),
				'desc_tip'    => true
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
			'display_text'             => array(
				'title'       => __( 'Display text', 'woocommerce-wcp' ),
				'type'        => 'text',
				'description' => __( 'Display Text on the Wirecard Checkout Page.', 'woocommerce-wcp' ),
				'desc_tip'    => true
			),
			// payment types
			'pt_select'                => array(
				'type'        => 'checkbox',
				'label'       => $this->get_paymenttype_name( 'select' ),
				'default'     => 'yes',
				'description' => __( 'Payment is choosen on the Wirecard Checkout Page.', 'woocommerce-wcp' ),
				'desc_tip'    => true
			),
			'pt_ccard'                 => array(
				'type'        => 'checkbox',
				'label'       => $this->get_paymenttype_name( 'ccard' ),
				'default'     => 'no',
				'description' => __( 'Credit Card.', 'woocommerce-wcp' ),
				'desc_tip'    => true
			),
			'pt_ccard-moto'            => array(
				'type'        => 'checkbox',
				'label'       => $this->get_paymenttype_name( 'ccard-moto' ),
				'default'     => 'no',
				'description' => __( 'Credit Card mobile-, tele-order.', 'woocommerce-wcp' ),
				'desc_tip'    => true
			),
			'pt_maestro'               => array(
				'type'        => 'checkbox',
				'label'       => $this->get_paymenttype_name( 'maestro' ),
				'default'     => 'no',
				'description' => __( 'Maestro SecureCode.', 'woocommerce-wcp' ),
				'desc_tip'    => true
			),
			'pt_eps'                   => array(
				'type'        => 'checkbox',
				'label'       => $this->get_paymenttype_name( 'eps' ),
				'default'     => 'no',
				'description' => __( 'eps Online Bank Transfer.', 'woocommerce-wcp' ),
				'desc_tip'    => true
			),
			'pt_idl'                   => array(
				'type'        => 'checkbox',
				'label'       => $this->get_paymenttype_name( 'idl' ),
				'default'     => 'no',
				'description' => __( 'iDEAL.', 'woocommerce-wcp' ),
				'desc_tip'    => true
			),
			'pt_giropay'               => array(
				'type'        => 'checkbox',
				'label'       => $this->get_paymenttype_name( 'giropay' ),
				'default'     => 'no',
				'description' => __( 'giropay.', 'woocommerce-wcp' ),
				'desc_tip'    => true
			),
			'pt_sofortueberweisung'    => array(
				'type'        => 'checkbox',
				'label'       => __( 'SOFORT banking (PIN/TAN)', 'woocommerce-wcp' ),
				'default'     => 'no',
				'description' => __( 'SOFORT banking (PIN/TAN).', 'woocommerce-wcp' ),
				'desc_tip'    => true
			),
			'pt_pbx'                   => array(
				'type'        => 'checkbox',
				'label'       => $this->get_paymenttype_name( 'pbx' ),
				'default'     => 'no',
				'description' => __( 'Mobile Phone Invoicing.', 'woocommerce-wcp' ),
				'desc_tip'    => true
			),
			'pt_psc'                   => array(
				'type'        => 'checkbox',
				'label'       => $this->get_paymenttype_name( 'psc' ),
				'default'     => 'no',
				'description' => __( 'paysafecard.', 'woocommerce-wcp' ),
				'desc_tip'    => true
			),
			'pt_quick'                 => array(
				'type'        => 'checkbox',
				'label'       => $this->get_paymenttype_name( 'quick' ),
				'default'     => 'no',
				'description' => __( '@QUICK.', 'woocommerce-wcp' ),
				'desc_tip'    => true
			),
			'pt_paypal'                => array(
				'type'        => 'checkbox',
				'label'       => $this->get_paymenttype_name( 'paypal' ),
				'default'     => 'no',
				'description' => __( 'PayPal.', 'woocommerce-wcp' ),
				'desc_tip'    => true
			),
			'pt_elv'                   => array(
				'type'        => 'checkbox',
				'label'       => $this->get_paymenttype_name( 'elv' ),
				'default'     => 'no',
				'description' => __( 'SEPA Direct Debit.', 'woocommerce-wcp' ),
				'desc_tip'    => true
			),
			'pt_c2p'                   => array(
				'type'        => 'checkbox',
				'label'       => $this->get_paymenttype_name( 'c2p' ),
				'default'     => 'no',
				'description' => __( 'CLICK2PAY.', 'woocommerce-wcp' ),
				'desc_tip'    => true
			),
			'pt_invoice'               => array(
				'type'        => 'checkbox',
				'label'       => $this->get_paymenttype_name( 'invoice' ),
				'default'     => 'no',
				'description' => __( 'Invoice.', 'woocommerce-wcp' ),
				'desc_tip'    => true
			),
			'pt_installment'           => array(
				'type'        => 'checkbox',
				'label'       => __( 'Installment', 'woocommerce-wcp' ),
				'default'     => 'no',
				'description' => __( 'Installment.', 'woocommerce-wcp' ),
				'desc_tip'    => true
			),
			'pt_bancontact_mistercash' => array(
				'type'        => 'checkbox',
				'label'       => $this->get_paymenttype_name( 'bancontact_mistercash' ),
				'default'     => 'no',
				'description' => __( 'Bancontact/Mister Cash.', 'woocommerce-wcp' ),
				'desc_tip'    => true
			),
			'pt_przelewy24'            => array(
				'type'        => 'checkbox',
				'label'       => $this->get_paymenttype_name( 'przelewy24' ),
				'default'     => 'no',
				'description' => __( 'Przelewy24.', 'woocommerce-wcp' ),
				'desc_tip'    => true
			),
			'pt_moneta'                => array(
				'type'        => 'checkbox',
				'label'       => $this->get_paymenttype_name( 'moneta' ),
				'default'     => 'no',
				'description' => __( 'moneta.ru.', 'woocommerce-wcp' ),
				'desc_tip'    => true
			),
			'pt_poli'                  => array(
				'type'        => 'checkbox',
				'label'       => $this->get_paymenttype_name( 'poli' ),
				'default'     => 'no',
				'description' => __( 'POLi.', 'woocommerce-wcp' ),
				'desc_tip'    => true
			),
			'pt_ekonto'                => array(
				'type'        => 'checkbox',
				'label'       => $this->get_paymenttype_name( 'ekonto' ),
				'default'     => 'no',
				'description' => __( 'eKonto.', 'woocommerce-wcp' ),
				'desc_tip'    => true
			),
			'pt_instantbank'           => array(
				'type'        => 'checkbox',
				'label'       => $this->get_paymenttype_name( 'instantbank' ),
				'default'     => 'no',
				'description' => __( 'Trustly.', 'woocommerce-wcp' ),
				'desc_tip'    => true
			),
			'pt_mpass'                 => array(
				'type'        => 'checkbox',
				'label'       => $this->get_paymenttype_name( 'mpass' ),
				'default'     => 'no',
				'description' => __( 'mpass.', 'woocommerce-wcp' ),
				'desc_tip'    => true
			),
			'pt_skrilldirect'          => array(
				'type'        => 'checkbox',
				'label'       => $this->get_paymenttype_name( 'skrilldirect' ),
				'default'     => 'no',
				'description' => __( 'Skrill Direct.', 'woocommerce-wcp' ),
				'desc_tip'    => true
			),
			'pt_skrillwallet'          => array(
				'type'        => 'checkbox',
				'label'       => $this->get_paymenttype_name( 'skrillwallet' ),
				'default'     => 'no',
				'description' => __( 'Skrill Digital Wallet.', 'woocommerce-wcp' ),
				'desc_tip'    => true
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
	}

	/**
	 * Admin Panel Options
	 *
	 * @access public
	 * @return void
	 */
	function admin_options() {
		?>
		<h3><?php _e( 'Wirecard Checkout Page', 'woocommerce-wcp' ); ?></h3>
		<p><?php _e( 'Payment via Wirecard Checkout Page', 'woocommerce-wcp' ); ?></p>
		<table class="form-table">
			<?php
			// Generate the HTML For the settings form.
			$this->generate_settings_html();
			?>
		</table>
		<?php
	}

	/**
	 * Process the payment and return the result
	 *
	 * @access public
	 *
	 * @param int $order_id
	 *
	 * @return array
	 */
	function process_payment( $order_id ) {
		/**
		 * @global $woocommerce Woocommerce
		 */
		global $woocommerce;

		$order = new WC_Order( $order_id );

		if ( ! isset( $_REQUEST['payment_method_wirecard_checkout_page_type'] ) ) {
			wc_add_notice( __( 'Please select a payment type.', 'woocommerce-wcp' ), 'error' );

			return false;
		}

		$paymenttype = $_REQUEST['payment_method_wirecard_checkout_page_type'];
		if ( ! $this->is_paymenttype_enabled( $paymenttype ) ) {
			wc_add_notice( __( 'Payment type is not available, please select another payment type.',
			                   'woocommerce-wcp' ), 'error' );

			return false;
		}

		// check customers age for invoice and installment
		// make it here, because we have no birthday in earlier checkout steps
		if ( $paymenttype == 'invoice' || $paymenttype == 'installment' ) {
			if ( ! isset( $_POST['billing_birthday'] ) || ! strlen( $_POST['billing_birthday'] ) ) {
				wc_add_notice( __( 'Please fill out the birthday field.', 'woocommerce-wcp' ), 'error' );

				return false;
			}

			try {
				// remember this, needed later
				$this->customer_birthday = new \DateTime( $_POST['billing_birthday'] );
			} catch ( Exception $e ) {
				wc_add_notice( __( 'Birthday field is invalid.', 'woocommerce-wcp' ), 'error' );

				return false;
			}

			$diff        = $this->customer_birthday->diff( new DateTime() );
			$customerAge = $diff->format( '%y' );
			if ( $customerAge < WOOCOMMERCE_GATEWAY_WCP_INVOICE_INSTALLMENT_MIN_AGE ) {
				wc_add_notice( __( 'You are not allowed to use this payment type.', 'woocommerce-wcp' ), 'error' );

				return false;
			}
		}

		if ( $this->use_iframe ) {
			WC()->session->wirecard_checkout_page_type = $paymenttype;

			$page_url = version_compare( WC()->version, '2.1.0', '<' )
				? get_permalink( wc_get_page_id( 'pay' ) )
				: $order->get_checkout_payment_url( true );

			$page_url = add_query_arg( 'key', $order->get_order_key(), $page_url );
			$page_url = add_query_arg( 'order-pay', $order_id, $page_url );

			return array(
				'result'   => 'success',
				'redirect' => $page_url
			);
		} else {
			$redirectUrl = $this->initiate_payment( $order, $paymenttype );
			if ( ! $redirectUrl ) {
				return;
			}

			return array(
				'result'   => 'success',
				'redirect' => $redirectUrl
			);
		}
	}

	/**
	 * Payment iframe
	 *
	 * @param
	 *            $order_id
	 */
	function payment_page( $order_id ) {
		$order = new WC_Order( $order_id );

		$iframeUrl = $this->initiate_payment( $order, WC()->session->wirecard_checkout_page_type );
		?>
		<iframe src="<?php echo $iframeUrl ?>"
		        name="<?php echo WOOCOMMERCE_GATEWAY_WCP_WINDOWNAME ?>" width="100%"
		        height="700px" border="0" frameborder="0">
			<p>Your browser does not support iframes.</p>
		</iframe>
		<?php
	}

	/**
	 * Dispatch callback, invoked twice, first server-to-server, second browser redirect
	 * Do iframe breakout, if needed
	 */
	function dispatch_callback() {
		// if session data is available assume browser redirect, otherwise server-to-server request
		if ( isset( WC()->session->chosen_payment_method ) ) {

			// do iframe breakout, if needed and not already done
			if ( $this->use_iframe && ! array_key_exists( 'redirected', $_REQUEST ) ) {
				$url = add_query_arg( 'wc-api', 'WC_Gateway_WCP', home_url( '/', is_ssl() ? 'https' : 'http' ) );
				wc_get_template(
					'templates/iframebreakout.php',
					array(
						'url' => $url
					),
					WOOCOMMERCE_GATEWAY_WCP_BASEDIR,
					WOOCOMMERCE_GATEWAY_WCP_BASEDIR
				);
				die();
			}

			$redirectUrl = $this->return_request();
			header( 'Location: ' . $redirectUrl );
		} else {
			print $this->confirm_request();
		}

		die();
	}

	/**
	 * handle browser return
	 *
	 * @return string
	 */
	function return_request() {
		$this->log( 'return_request:' . print_r( $_REQUEST, true ), 'notice' );

		$redirectUrl = $this->get_return_url();
		if ( ! isset( $_REQUEST['wooOrderId'] ) || ! strlen( $_REQUEST['wooOrderId'] ) ) {
			wc_add_notice( __( 'Panic: Order-Id missing', 'woocommerce-wcp' ), 'error' );

			return $redirectUrl;
		}
		$order_id = $_REQUEST['wooOrderId'];
		$order    = new WC_Order( $order_id );
		if ( ! $order->get_id() ) {
			wc_add_notice( __( 'Panic: Order-Id missing', 'woocommerce-wcp' ), 'error' );

			return $redirectUrl;
		}

		$paymentState = $_REQUEST['paymentState'];
		switch ( $paymentState ) {
			case WirecardCEE_QPay_ReturnFactory::STATE_SUCCESS:
			case WirecardCEE_QPay_ReturnFactory::STATE_PENDING:
				return $this->get_return_url( $order );

			case WirecardCEE_QPay_ReturnFactory::STATE_CANCEL:
				wc_add_notice( __( 'Payment has been cancelled.', 'woocommerce-wcp' ), 'error' );
				unset( WC()->session->wirecard_checkout_page_redirect_url );

				return $order->get_cancel_endpoint();

			case WirecardCEE_QPay_ReturnFactory::STATE_FAILURE:
				if ( array_key_exists( 'consumerMessage', $_REQUEST ) ) {
					wc_add_notice( $_REQUEST['consumerMessage'], 'error' );
				} else {
					wc_add_notice( __( 'Payment has failed.', 'woocommerce-wcp' ), 'error' );
				}

				return $order->get_cancel_endpoint();

			default:
				break;
		}

		return $this->get_return_url( $order );
	}

	/**
	 * Server to server request
	 *
	 * @return string
	 */
	function confirm_request() {
		$this->log( 'confirm_request:' . print_r( $_REQUEST, true ), 'notice' );

		$message = null;
		if ( ! isset( $_REQUEST['wooOrderId'] ) || ! strlen( $_REQUEST['wooOrderId'] ) ) {
			$message = 'order-id missing';
			$this->log( $message, 'error' );

			return WirecardCEE_QPay_ReturnFactory::generateConfirmResponseString( $message );
		}
		$order_id = $_REQUEST['wooOrderId'];
		$order    = new WC_Order( $order_id );
		if ( ! $order->get_id() ) {
			$message = "order with id `$order->get_id()` not found";
			$this->log( $message, 'error' );

			return WirecardCEE_QPay_ReturnFactory::generateConfirmResponseString( $message );
		}

		if ( $order->get_status() == "processing" || $order->get_status() == "completed" ) {
			$message = "cannot change the order with id `$order->get_id()`";
			$this->log( $message, 'error' );

			return WirecardCEE_QPay_ReturnFactory::generateConfirmResponseString( $message );
		}

		$str = '';
		foreach ( $_POST as $k => $v ) {
			$str .= "$k:$v\n";
		}
		$str = trim( $str );

		update_post_meta( $order->get_id(), 'wcp_data', $str );

		$message = null;
		try {
			$return = WirecardCEE_QPay_ReturnFactory::getInstance( $_POST, $this->get_option( 'secret' ) );
			if ( ! $return->validate() ) {
				$message = __( 'Validation error: invalid response', 'woocommerce-wcp' );
				$order->update_status( 'failed', $message );

				return WirecardCEE_QPay_ReturnFactory::generateConfirmResponseString( $message );
			}

			/**
			 * @var $return WirecardCEE_Stdlib_Return_ReturnAbstract
			 */
			update_post_meta( $order->get_id(), 'wcp_payment_state', $return->getPaymentState() );

			switch ( $return->getPaymentState() ) {
				case WirecardCEE_QPay_ReturnFactory::STATE_SUCCESS:
					update_post_meta( $order->get_id(), 'wcp_gateway_reference_number',
					                  $return->getGatewayReferenceNumber() );
					update_post_meta( $order->get_id(), 'wcp_order_number', $return->getOrderNumber() );
					$order->payment_complete();
					break;

				case WirecardCEE_QPay_ReturnFactory::STATE_PENDING:
					/**
					 * @var $return WirecardCEE_QPay_Return_Pending
					 */
					$order->update_status(
						'on-hold',
						__( 'Awaiting payment notification from 3rd party.', 'woocommerce-wcp' )
					);
					break;

				case WirecardCEE_QPay_ReturnFactory::STATE_CANCEL:
					/**
					 * @var $return WirecardCEE_QPay_Return_Cancel
					 */
					$order->update_status( 'pending', __( 'Payment cancelled.', 'woocommerce-wcp' ) );
					break;

				case WirecardCEE_QPay_ReturnFactory::STATE_FAILURE:
					/**
					 * @var $return WirecardCEE_QPay_Return_Failure
					 */
					$str_errors = '';
					foreach ( $return->getErrors() as $error ) {
						$errors[] = $error->getConsumerMessage();
						wc_add_notice( __( "Request failed! Error: {$error->getConsumerMessage()}",
						                   'woocommerce-wcp' ),
						               'error' );
						$this->log( $error->getConsumerMessage(), 'error' );
						$str_errors += $error->getConsumerMessage();
					}
					$order->update_status( 'failed', $str_errors );
					break;

				default:
					break;
			}
		} catch ( Exception $e ) {
			$this->log( __FUNCTION__ . $e->getMessage(), 'error' );
			$order->update_status( 'failed', $e->getMessage() );
			$message = $e->getMessage();
		}

		return WirecardCEE_QPay_ReturnFactory::generateConfirmResponseString( $message );
	}

	/**
	 *
	 * @param $order_id WC_Order
	 */
	function thankyou_page_text( $order_id ) {
		$order = new WC_Order( $order_id );
		if ( $order->get_status() == 'on-hold' ) {
			printf(
				'<p>%s</p>',
				__(
					'Your order will be processed, as soon as we get the payment notification from your bank institute',
					'woocommerce-wcp'
				)
			);
		}
	}

	/**
	 * Display the list of enabled paymenttypes on the checkout page
	 *
	 * @access public
	 * @return void
	 */
	function payment_fields() {
		if ( $description = $this->get_description() ) {
			echo wpautop( wptexturize( $description ) );
		}

		foreach ( $this->get_enabled_paymenttypes() as $type ) {
			?>
			<div
				id="wcp-payment-method-<?php echo $type->code ?>-wrap"
				class="wcp-payment-method-wrap">
				<input
					id="payment_method_wirecard_checkout_page_<?php echo $type->code ?>"
					type="radio"
					onclick="jQuery.post('<?= WC()->ajax_url() ?>',{action:'saveWcpPaymentMethod',code:'<?= $type->code ?>'});"
					<?= WC()->session->selected_wcp_payment == $type->code ? 'checked="checked"' : '' ?>
					value="<?php echo $type->code ?>"
					name="payment_method_wirecard_checkout_page_type">
				<label
					for="payment_method_wirecard_checkout_page_<?php echo $type->code ?>"><?php echo $type->label ?></label>
			</div>
			<?php
		}
	}

	/**
	 * Filter hook, add custom field to the checkout, needed for invoice and installment
	 *
	 * @param
	 *            $address_fields
	 *
	 * @return mixed
	 */
	function custom_fields( $address_fields ) {
		$address_fields['billing_birthday'] = array(
			'label'       => __( 'Birthday', 'woocommerce-wcp' ),
			'placeholder' => 'DD.MM.YYYY',
			'required'    => 0,
			'class'       => array(
				'form-row-wide'
			),
			'validate'    => array(
				'date'
			),
			'clear'       => 1
		);

		return $address_fields;
	}

	/*
	 * Protected Methods
	 */

	/**
	 * List of enables paymenttypes
	 *
	 * @return array
	 */
	protected function get_enabled_paymenttypes() {
		$types = array();
		foreach ( $this->settings as $k => $v ) {
			if ( preg_match( '/^pt_(.+)$/', $k, $parts ) ) {
				if ( $v == 'yes' ) {
					$type        = new stdClass();
					$type->code  = $parts[1];
					$type->label = $this->get_paymenttype_name( $type->code );
					$method_name = 'check_paymenttype_' . $type->code;

					if ( method_exists( $this, $method_name ) ) {
						if ( ! call_user_func(
							array(
								$this,
								$method_name
							)
						)
						) {
							continue;
						}
					}
					$types[] = $type;
				}
			}
		}

		return $types;
	}

	/**
	 * Check whether the given payment type is enabled/available or not
	 *
	 * @param
	 *            $code
	 *
	 * @return bool
	 */
	protected function is_paymenttype_enabled( $code ) {
		foreach ( $this->get_enabled_paymenttypes() as $pt ) {
			if ( $pt->code == $code ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Check whether invoice is allowed or not
	 *
	 * @return bool
	 */
	function check_paymenttype_invoice() {
		global $woocommerce;
		$customer = $woocommerce->customer;

		$fields = array(
			'address',
			'address_2',
			'city',
			'country',
			'postcode',
			'state'
		);

		foreach ( $fields as $field ) {
			$billing  = "get_billing_$field";
			$shipping = "get_shipping_$field";

			$billing_value  = call_user_func( array( $customer, $billing ) );
			$shipping_value = call_user_func( array( $customer, $shipping ) );

			if ( $billing_value != $shipping_value ) {
				return false;
			}
		}

		if ( get_woocommerce_currency() != 'EUR' ) {
			return false;
		}

		$cart = new WC_Cart();
		$cart->get_cart_from_session();

		$total = $cart->total;
		if ( (int) $this->get_option( 'invoice_min_amount' ) && (int) $this->get_option( 'invoice_min_amount' ) > $total ) {
			return false;
		}

		if ( (int) $this->get_option( 'invoice_max_amount' ) && (int) $this->get_option( 'invoice_max_amount' ) < $total ) {
			return false;
		}

		return true;
	}


	/**
	 * Basic check if address is empty
	 *
	 * @since 1.2.2
	 *
	 * @param $address
	 *
	 * @return bool
	 */
	function address_empty( $address ) {

		foreach ( $address as $key => $value ) {
			if ( ! empty( $value ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Check whether installment is allowed or not
	 *
	 * @return bool
	 */
	function check_paymenttype_installment() {
		global $woocommerce;
		$customer = $woocommerce->customer;

		$fields = array(
			'address',
			'address_2',
			'city',
			'country',
			'postcode',
			'state'
		);

		foreach ( $fields as $field ) {
			$billing  = "get_billing_$field";
			$shipping = "get_shipping_$field";

			$billing_value  = call_user_func( array( $customer, $billing ) );
			$shipping_value = call_user_func( array( $customer, $shipping ) );

			if ( $billing_value != $shipping_value ) {
				return false;
			}
		}

		if ( get_woocommerce_currency() != 'EUR' ) {
			return false;
		}

		$cart = new WC_Cart();
		$cart->get_cart_from_session();

		$total = $cart->total;
		if ( (int) $this->get_option( 'installment_min_amount' ) && (int) $this->get_option( 'installment_min_amount' ) > $total ) {
			return false;
		}

		if ( (int) $this->get_option( 'installment_max_amount' ) && (int) $this->get_option( 'installment_max_amount' ) < $total ) {
			return false;
		}

		return true;
	}

	/**
	 * @param $order
	 * @param $paymenttype
	 *
	 * @return string
	 * @throws Exception
	 */
	protected function initiate_payment( $order, $paymenttype ) {
		if ( isset( WC()->session->wirecard_checkout_page_redirect_url ) && WC()->session->wirecard_checkout_page_redirect_url['id'] == $order->get_id() ) {
			return WC()->session->wirecard_checkout_page_redirect_url['url'];
		}

		$paymenttype = strtoupper( $paymenttype );
		try {

			$client = new WirecardCEE_QPay_FrontendClient( array(
				                                               'CUSTOMER_ID' => $this->get_option( 'customer_id' ),
				                                               'SHOP_ID'     => $this->get_option( 'shop_id' ),
				                                               'SECRET'      => $this->get_option( 'secret' ),
				                                               'LANGUAGE'    => $this->get_language_code()
			                                               ) );

			// consumer data (IP and User aget) are mandatory!
			$consumerData = new WirecardCEE_Stdlib_ConsumerData();
			$consumerData->setUserAgent( $_SERVER['HTTP_USER_AGENT'] )->setIpAddress( $_SERVER['REMOTE_ADDR'] );

			if ( $this->get_option( 'send_additional_data' ) == 'yes' || in_array(
					$paymenttype,
					Array(
						WirecardCEE_QPay_PaymentType::INVOICE,
						WirecardCEE_QPay_PaymentType::INSTALLMENT
					)
				)
			) {
				$this->set_consumer_information( $order, $consumerData );
			}

			$returnUrl = add_query_arg( 'wc-api', 'WC_Gateway_WCP', home_url( '/', is_ssl() ? 'https' : 'http' ) );

			$version = WirecardCEE_QPay_FrontendClient::generatePluginVersion(
				$this->get_vendor(),
				WC()->version,
				WOOCOMMERCE_GATEWAY_WCP_NAME,
				WOOCOMMERCE_GATEWAY_WCP_VERSION
			);

			$client->setAmount( $order->get_total() )
			       ->setCurrency( get_woocommerce_currency() )
			       ->setPaymentType( $paymenttype )
			       ->setOrderDescription( $this->get_order_description( $order ) )
			       ->setPluginVersion( $version )
			       ->setSuccessUrl( $returnUrl )
			       ->setPendingUrl( $returnUrl )
			       ->setCancelUrl( $returnUrl )
			       ->setFailureUrl( $returnUrl )
			       ->setConfirmUrl( $returnUrl )
			       ->setServiceUrl( $this->get_option( 'service_url' ) )
			       ->setImageUrl( $this->get_option( 'image_url' ) )
			       ->setConsumerData( $consumerData )
			       ->setDisplayText( $this->get_option( 'display_text' ) )
			       ->setCustomerStatement( $this->get_customer_statement( $order ) )
			       ->setDuplicateRequestCheck( false )
			       ->setMaxRetries( $this->get_option( 'max_retries' ) )
			       ->createConsumerMerchantCrmId( $order->get_billing_email() )
			       ->setWindowName( WOOCOMMERCE_GATEWAY_WCP_WINDOWNAME );

			if ( ( $this->get_option( 'auto_deposit' ) == 'yes' ) ) {
				$client->setAutoDeposit( (bool) ( $this->get_option( 'auto_deposit' ) == 'yes' ) );
			}

			$client->wooOrderId = $order->get_id();
			$response           = $client->initiate();

			if ( $response->hasFailed() ) {
				wc_add_notice(
					__( "Response failed! Error: {$response->getError()->getMessage()}", 'woocommerce-wcp' ),
					'error'
				);
				// throw new \Exception("Response failed! Error: {$response->getError()->getMessage()}", 500);
			}
		} catch ( Exception $e ) {
			throw ( $e );
		}

		WC()->session->wirecard_checkout_page_redirect_url = array(
			'id'  => $order->get_id(),
			'url' => $response->getRedirectUrl()
		);

		return $response->getRedirectUrl();
	}

	/**
	 * Fill additional consumer information
	 *
	 * @param WC_Order $order
	 * @param WirecardCEE_Stdlib_ConsumerData $consumerData
	 */
	protected function set_consumer_information( $order, WirecardCEE_Stdlib_ConsumerData $consumerData ) {
		if ( $this->customer_birthday !== null ) {
			$consumerData->setBirthDate( $this->customer_birthday );
		}

		$consumerData->setEmail( $order->get_billing_email() );

		$billingAddress = new WirecardCEE_Stdlib_ConsumerData_Address( WirecardCEE_Stdlib_ConsumerData_Address::TYPE_BILLING );

		$billingAddress->setFirstname( $order->get_billing_first_name() )
		               ->setLastname( $order->get_billing_last_name() )
		               ->setAddress1( $order->get_billing_address_1() )
		               ->setAddress2( $order->get_billing_address_2() )
		               ->setCity( $order->get_billing_city() )
		               ->setZipCode( $order->get_billing_postcode() )
		               ->setCountry( $order->get_billing_country() )
		               ->setPhone( $order->get_billing_phone() )
		               ->setState( $order->get_billing_state() );

		$cart = new WC_Cart();
		$cart->get_cart_from_session();

		//check if shipping address is different
		if ( $cart->needs_shipping_address() ) {
			$shippingAddress = new WirecardCEE_Stdlib_ConsumerData_Address( WirecardCEE_Stdlib_ConsumerData_Address::TYPE_SHIPPING );

			$shippingAddress->setFirstname( $order->get_shipping_first_name() )
			                ->setLastname( $order->get_shipping_last_name() )
			                ->setAddress1( $order->get_shipping_address_1() )
			                ->setAddress2( $order->get_shipping_address_2() )
			                ->setCity( $order->get_shipping_city() )
			                ->setZipCode( $order->get_shipping_postcode() )
			                ->setCountry( $order->get_shipping_country() )
			                ->setState( $order->get_shipping_state() );
		} else {
			$shippingAddress = $billingAddress;
		}

		$consumerData->addAddressInformation( $billingAddress )->addAddressInformation( $shippingAddress );
	}

	/**
	 * Return the translated name of the paymenttype
	 *
	 * @param
	 *            $code
	 *
	 * @return string void
	 */
	protected function get_paymenttype_name( $code ) {
		switch ( $code ) {
			case 'select':
				return __( 'Select', 'woocommerce-wcp' );

			case 'ccard':
				return __( 'Credit Card', 'woocommerce-wcp' );

			case 'ccard-moto':
				return __( 'Credit Card MoTo', 'woocommerce-wcp' );

			case 'maestro':
				return __( 'Maestro', 'woocommerce-wcp' );

			case 'eps':
				return __( 'eps Online Bank Transfer', 'woocommerce-wcp' );
			case 'idl':
				return __( 'iDEAL', 'woocommerce-wcp' );

			case 'giropay':
				return __( 'giropay', 'woocommerce-wcp' );

			case 'sofortueberweisung':
				return __( 'sofortueberweisung', 'woocommerce-wcp' );

			case 'pbx':
				return __( 'Mobile Phone Invoicing', 'woocommerce-wcp' );

			case 'psc':
				return __( 'paysafecard', 'woocommerce-wcp' );

			case 'quick':
				return __( '@QUICK', 'woocommerce-wcp' );

			case 'paypal':
				return __( 'PayPal', 'woocommerce-wcp' );

			case 'elv':
				return __( 'SEPA Direct Debit', 'woocommerce-wcp' );

			case 'c2p':
				return __( 'CLICK2PAY', 'woocommerce-wcp' );

			case 'invoice':
				return __( 'Invoice', 'woocommerce-wcp' );

			case 'installment':
				return __( 'Installment', 'woocommerce-wcp' );

			case 'bancontact_mistercash':
				return __( 'Bancontact/Mister Cash', 'woocommerce-wcp' );

			case 'przelewy24':
				return __( 'Przelewy24', 'woocommerce-wcp' );

			case 'moneta':
				return __( 'moneta.ru', 'woocommerce-wcp' );

			case 'poli':
				return __( 'POLi', 'woocommerce-wcp' );

			case 'ekonto':
				return __( 'eKonto', 'woocommerce-wcp' );

			case 'instantbank':
				return __( 'Trustly', 'woocommerce-wcp' );

			case 'mpass':
				return __( 'mpass', 'woocommerce-wcp' );

			case 'skrilldirect':
				return __( 'Skrill Direct', 'woocommerce-wcp' );

			case 'skrillwallet':
				return __( 'Skrill Digital Wallet', 'woocommerce-wcp' );

			default:
				return $code;
		}
	}

	/**
	 * Extract the language code from the locale settings
	 *
	 * @return mixed
	 */
	protected function get_language_code() {
		$locale = get_locale();
		$parts  = explode( '_', $locale );

		return $parts[0];
	}

	/**
	 *
	 * @param $order WC_Order
	 *
	 * @return string
	 */
	protected function get_order_description( $order ) {
		return sprintf( 'user_id:%s order_id:%s', $order->get_user_id(), $order->get_id() );
	}

	/**
	 *
	 * @param $order WC_Order
	 *
	 * @return string
	 */
	protected function get_customer_statement( $order ) {
		return sprintf( '%s #%06s', $this->get_vendor(), $order->get_order_number() );
	}

	/**
	 * Get vendor info, i.e.
	 * shopname
	 *
	 * @return mixed void
	 */
	protected function get_vendor() {
		return get_option( 'blogname' );
	}

	/**
	 * Log to file, if enabled
	 *
	 * @param
	 *            $str
	 */
	protected function log( $str, $level = 'notice' ) {
		if ( $this->debug ) {
			if ( empty( $this->log ) ) {
				$this->log = new WC_Logger();
			}
			$this->log->log( $level, 'WirecardCheckoutPage: ' . $str );
		}
	}
}
