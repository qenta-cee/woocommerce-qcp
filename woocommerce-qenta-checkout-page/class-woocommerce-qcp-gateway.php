<?php
/*
 * Shop System Plugins - Terms of use This terms of use regulates warranty and liability between Qenta Payment CEE GmbH (subsequently referred to as QCEE) and it's contractual partners (subsequently referred to as customer or customers) which are related to the use of plugins provided by QCEE. The Plugin is provided by QCEE free of charge for it's customers and must be used for the purpose of QCEE's payment platform integration only. It explicitly is not part of the general contract between QCEE and it's customer. The plugin has successfully been tested under specific circumstances which are defined as the shopsystem's standard configuration (vendor's delivery state). The Customer is responsible for testing the plugin's functionality before putting it into production enviroment. The customer uses the plugin at own risk. QCEE does not guarantee it's full functionality neither does QCEE assume liability for any disadvantage related to the use of this plugin. By installing the plugin into the shopsystem the customer agrees to the terms of use. Please do not use this plugin if you do not agree to the terms of use!
 *
 *  - Support for WooCommerce 4.6 (not backward compatible)
 *  - Removed margin-right of payment type radio button
 *  - Wrapped payment type in div
 *
 */
require_once( WOOCOMMERCE_GATEWAY_QCP_BASEDIR . 'classes/class-woocommerce-qcp-config.php' );
require_once( WOOCOMMERCE_GATEWAY_QCP_BASEDIR . 'classes/class-woocommerce-qcp-payments.php' );

define( 'WOOCOMMERCE_GATEWAY_QCP_NAME', 'Woocommerce2_QentaCheckoutPage' );
define( 'WOOCOMMERCE_GATEWAY_QCP_VERSION', '2.1.0' );
define( 'WOOCOMMERCE_GATEWAY_QCP_WINDOWNAME', 'QentaCheckoutPageFrame' );
define( 'WOOCOMMERCE_GATEWAY_QCP_TABLE_NAME', 'woocommerce_qcp_transaction' );

class WC_Gateway_QCP extends WC_Payment_Gateway {

	/**
	 * @var $log WC_Logger
	 */
	protected $log;

	/**
	 * Config Class
	 *
	 * @since 1.3.0
	 * @access protected
	 * @var WC_Gateway_QCP_Config
	 */
	protected $_config;

	/**
	 * Payments Class
	 *
	 * @since 1.3.0
	 * @access protected
	 * @var WC_Gateway_QCP_Payments
	 */
	protected $_payments;

	function __construct() {
		$this->id                 = 'qenta_checkout_page';
		$this->icon               = WOOCOMMERCE_GATEWAY_QCP_URL . 'assets/images/qenta.png';
		$this->has_fields         = true;
		$this->method_title       = __( 'Qenta Checkout Page', 'woocommerce-qcp' );
		$this->method_description = __(
			"Qenta is a popular payment service provider (PSP) and has connections with over 20 national and international currencies. ",
			'woocommerce-qcp'
		);

		// Load the form fields
		$this->init_form_fields();

		// Load the settings.
		$this->init_settings();
		$this->remove_old_payments();

		$this->_config = new WC_Gateway_QCP_Config($this->settings);
		$this->_payments = new WC_Gateway_QCP_Payments($this->settings);

		$this->title       = 'Qenta Checkout Page'; // frontend title
		$this->debug       = $this->settings['debug'] == 'yes';
		$this->use_iframe  = false;
		$this->enabled = count( $this->get_enabled_paymenttypes(false ) ) > 0 ? "yes" : "no";

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

		// Payment listener/API hook
		add_action(
			'woocommerce_api_wc_gateway_qcp',
			array(
				$this,
				'dispatch_callback'
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
		$countries = WC()->countries->countries;
		$this->countries = array();
		if ( ! empty( $countries ) ) {
			foreach ( $countries as $key => $val ) {
				$this->countries[$key] = $val;
			}
		}
		$this->currency_code_options = array();
		foreach ( get_woocommerce_currencies() as $code => $name ) {
			$this->currency_code_options[ $code ] = $name . ' (' . get_woocommerce_currency_symbol( $code ) . ')';
		}
		$this->form_fields = include('includes/settings-qcp.php');
	}

	/**
	 * Admin Panel Options
	 *
	 * @access public
	 * @return void
	 */
	function admin_options() {
		?>
        <h3><?php _e( 'Qenta Checkout Page', 'woocommerce-qcp' ); ?></h3>
        <div class="woo-wcs-settings-header-wrapper" style="min-width: 200px; max-width: 800px;">
            <img src="<?php echo plugins_url( 'woocommerce-qenta-checkout-page/assets/images/qenta-logo.png' ) ?>">
            <p style="text-transform: uppercase;"><?php echo __( 'Qenta - Your Full Service Payment Provider - Comprehensive solutions from one single source',
					'woocommerce-qcp' ); ?></p>

            <p><?php echo __( 'Qenta is one of the world´s leading providers of outsourcing and white label solutions for electronic payment transactions.',
					'woocommerce-qcp' ); ?></p>

            <p><?php echo __( 'As independent provider of payment solutions, we accompany our customers along the entire business development. Our payment solutions are perfectly tailored to suit e-Commerce requirements and have made	us Austria´s leading payment service provider. Customization, competence, and commitment.',
					'woocommerce-qcp' ); ?></p>
        </div>
        <hr/>
        <style>
        .form-table td {
            padding:0px;
        }
        .form-table th {
            padding:0px;
        }
        </style>
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
    $postdata = $this->get_post_data();
		$order = new WC_Order( $order_id );

		$paymenttype = $postdata['qcp_payment_method'];
		if ( ! $this->is_paymenttype_enabled( $paymenttype ) ) {
			wc_add_notice( __( 'Payment type is not available, please select another payment type.',
				'woocommerce-qcp' ), 'error' );

			return false;
		}
        update_post_meta( $order_id, '_payment_method_title', $this->get_paymenttype_name( $paymenttype ) );

		$birthday = null;
		if ( isset( $postdata['qcp_birthday'] ) ) {
			$birthday = $postdata['qcp_birthday'];
		}
		$financial_inst = null;
		if ( $paymenttype == 'eps' ) {
			$financial_inst = 'EPS-SO';
		}

    $redirectUrl = $this->initiate_payment( $order, $paymenttype, $birthday, $financial_inst );
    if ( ! $redirectUrl ) {
      return;
    }

    return array(
      'result'   => 'success',
      'redirect' => $redirectUrl
    );
	}

	/**
	 * Payment iframe
	 *
	 * @param
	 *            $order_id
	 */
	function payment_page( $order_id ) {
		$order = new WC_Order( $order_id );

		$birthday = null;
    $financial_inst = null;

    $postdata = $this->get_post_data();
    $paymenttype = $postdata['qcp_payment_method'];

		if ( isset( $postdata['qcp_birthday'] ) ) {
			$birthday = $postdata['qcp_birthday'];
		}
		if ( $paymenttype == 'eps' ) {
			// $financial_inst = $postdata['qcp_eps_financialInstitution'];
			$financial_inst = 'EPS-SO';
		}

		$iframeUrl = $this->initiate_payment( $order, WC()->session->qenta_checkout_page_type, $birthday,
			$financial_inst );
		?>
        <iframe src="<?php echo esc_url_raw($iframeUrl) ?>"
                name="<?php echo esc_attr(WOOCOMMERCE_GATEWAY_QCP_WINDOWNAME) ?>" width="100%"
                height="700px" border="0" frameborder="0">
            <p>Your browser does not support iframes.</p>
        </iframe>
		<?php
	}

	/**
	 * Dispatch callback, invoked twice, first server-to-server, second browser redirect
	 * Do iframe breakout, if needed
	 */
  function dispatch_callback()
  {
      $ua = $_SERVER['HTTP_USER_AGENT'];
      $aQpayUA = array('qpay','qenta');
      // if user agent contains QENTA or QPAY, it's S2S request from qpay
      if(str_replace($aQpayUA, '', strtolower($ua)) !== strtolower($ua)) {
        print $this->confirm_request();

        exit();
      }

      $redirectUrl = $this->return_request();
      header('Location: '.$redirectUrl);

      exit();
  }


	/**
	 * handle browser return
	 *
	 * @return string
	 */
	function return_request() {
    $params_request = array_map( 'sanitize_text_field', $_REQUEST );

    foreach ( $params_request as &$param ) {
        $param = stripslashes( $param );
    }
		$this->log( 'return_request:' . print_r( $params_request, true ), 'info' );

		$redirectUrl = $this->get_return_url();
		if ( ! isset( $params_request['wooOrderId'] ) || ! strlen( $params_request['wooOrderId'] ) ) {
			wc_add_notice( __( 'Panic: Order-Id missing', 'woocommerce-qcp' ), 'error' );

			return $redirectUrl;
		}
		$order_id = $params_request['wooOrderId'];
		$order    = new WC_Order( $order_id );
		if ( ! $order->get_id() ) {
			wc_add_notice( __( 'Panic: Order-Id missing', 'woocommerce-qcp' ), 'error' );

			return $redirectUrl;
		}

		$paymentState = $params_request['paymentState'];
		switch ( $paymentState ) {
			case QentaCEE\QPay\ReturnFactory::STATE_SUCCESS:
			case QentaCEE\QPay\ReturnFactory::STATE_PENDING:
				return $this->get_return_url( $order );

			case QentaCEE\QPay\ReturnFactory::STATE_CANCEL:
				wc_add_notice( __( 'Payment has been cancelled.', 'woocommerce-qcp' ), 'error' );
				unset( WC()->session->qenta_checkout_page_redirect_url );

				return $order->get_cancel_endpoint();

			case QentaCEE\QPay\ReturnFactory::STATE_FAILURE:
				if ( array_key_exists( 'consumerMessage', $params_request ) ) {
					wc_add_notice( $params_request['consumerMessage'], 'error' );
				} else {
					wc_add_notice( __( 'Payment has failed.', 'woocommerce-qcp' ), 'error' );
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
    $postdata = $this->get_post_data();
    $params_request = array_map( 'sanitize_text_field', $_REQUEST );
    foreach ( $params_request as &$param ) {
        $param = stripslashes( $param );
    }
    foreach ( $postdata as &$param ) {
        $param = stripslashes( $param );
    }

		$this->log( 'confirm_request:' . print_r( $params_request, true ), 'info' );

		$message = null;
		if ( ! isset( $params_request['wooOrderId'] ) || ! strlen( $params_request['wooOrderId'] ) ) {
			$message = 'order-id missing';
			$this->log( $message, 'error' );

			return QentaCEE\QPay\ReturnFactory::generateConfirmResponseString( $message );
		}
		$order_id = $params_request['wooOrderId'];
		$order    = new WC_Order( $order_id );
		if ( ! $order->get_id() ) {
			$message = "order with id `$order->get_id()` not found";
			$this->log( $message, 'error' );

			return QentaCEE\QPay\ReturnFactory::generateConfirmResponseString( $message );
		}

		if ( $order->get_status() == "processing" || $order->get_status() == "completed" ) {
			$message = "cannot change the order with id `$order->get_id()`";
			$this->log( $message, 'error' );

			return QentaCEE\QPay\ReturnFactory::generateConfirmResponseString( $message );
		}

		$str = '';

		foreach ( $postdata as $k => $v ) {
			$str .= "$k:$v\n";
		}
		$str = trim( $str );

		update_post_meta( $order->get_id(), 'qcp_data', $str );
		if ( isset( $params_request['paymentType'] ) ) {
			update_post_meta($order->get_id(), '_payment_method', $params_request['paymentType']);
		}

		$message = null;
		try {
			$return = QentaCEE\QPay\ReturnFactory::getInstance( $postdata, $this->_config->get_secret() );
			if ( ! $return->validate() ) {
				$message = __( 'Validation error: invalid response', 'woocommerce-qcp' );
				$order->update_status( 'failed', $message );

				return QentaCEE\QPay\ReturnFactory::generateConfirmResponseString( $message );
			}

			/**
			 * @var $return QentaCEE\Stdlib\Returns\ReturnAbstract
			 */
			update_post_meta( $order->get_id(), 'qcp_payment_state', $return->getPaymentState() );
      $array_errors = [];

			switch ( $return->getPaymentState() ) {
				case QentaCEE\QPay\ReturnFactory::STATE_SUCCESS:
					update_post_meta( $order->get_id(), 'qcp_gateway_reference_number',
						$return->getGatewayReferenceNumber() );
					update_post_meta( $order->get_id(), 'qcp_order_number', $return->getOrderNumber() );
					$order->payment_complete();
					break;

				case QentaCEE\QPay\ReturnFactory::STATE_PENDING:
					/**
					 * @var $return QentaCEE\QPay\Returns\Pending
					 */
					$order->update_status(
						'on-hold',
						__( 'Awaiting payment notification from 3rd party.', 'woocommerce-qcp' )
					);
					break;

				case QentaCEE\QPay\ReturnFactory::STATE_CANCEL:
					/**
					 * @var $return QentaCEE\QPay\Returns\Cancel
					 */
					$order->update_status( 'cancelled', __( 'Payment cancelled.', 'woocommerce-qcp' ) );
					break;

				case QentaCEE\QPay\ReturnFactory::STATE_FAILURE:
					/**
					 * @var $return QentaCEE\QPay\Returns\Failure
					 */
					foreach ( $return->getErrors() as $error ) {
						$errors[] = $error->getConsumerMessage();
						wc_add_notice( __( "Request failed! Error: {$error->getConsumerMessage()}",
							'woocommerce-qcp' ),
							'error' );
						$this->log( $error->getConsumerMessage(), 'error' );
						$array_errors[] = $error->getConsumerMessage();
					}
					$order->update_status( 'failed', join('<br>', $array_errors) );
					break;

				default:
					break;
			}
		} catch ( Exception $e ) {
			$this->log( __FUNCTION__ . $e->getMessage(), 'error' );
			$order->update_status( 'failed', $e->getMessage() );
			$message = $e->getMessage();
		}

		return QentaCEE\QPay\ReturnFactory::generateConfirmResponseString( $message );
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
					'woocommerce-qcp'
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
	public function payment_fields() {
		if ( WC()->session->get( 'qcpConsumerDeviceId' ) ) {
		    $consumer_device_id = WC()->session->get( 'qcpConsumerDeviceId' );
        } else {
		    $timestamp = microtime();
		    $customer_id = $this->_config->get_customer_id();
		    $consumer_device_id = md5( $customer_id . "_" . $timestamp );
		    WC()->session->set( 'qcpConsumerDeviceId', $consumer_device_id );
        }
		?>
        <script language='JavaScript'>
            var di = {t:'<?php echo esc_attr($consumer_device_id); ?>',v:'WDWL',l:'Checkout'};
        </script>
        <input id="payment_method_qcp" type="hidden" value="woocommerce_qenta_checkout_page"
               name="qcp_payment_method"/>
        <script type="text/javascript">
            function changeQCPPayment(code) {
                var changer = document.getElementById('payment_method_qcp');
                changer.value = code;
            }
        </script>
        <link rel="stylesheet" type="text/css" href="<?php echo esc_url_raw( WOOCOMMERCE_GATEWAY_QCP_URL ); ?>assets/styles/payment.css">
		<?php
		foreach ( $this->get_enabled_paymenttypes() as $type ) {
			?>
            </div></li>
        <li class="wc_payment_method payment_method_qenta_checkout_page_<?php echo esc_attr($type->code) ?>">
            <input
                    id="payment_method_qenta_checkout_page_<?php echo esc_attr($type->code) ?>"
                    type="radio"
                    class="input-radio"
                    value="qenta_checkout_page"
                    onclick="changeQCPPayment('<?php echo esc_attr($type->code); ?>');"
                    name="payment_method"
                    data-order_button_text>
            <label for="payment_method_qenta_checkout_page_<?php echo esc_attr($type->code); ?>">
				<?php
				echo esc_html($type->label);
				echo "<img src='" . esc_url_raw( $this->_payments->get_payment_icon($type->code) ) . "' alt='Qenta " . esc_html($type->label) . "'>";
				?>
            </label>
        <div class="payment_box payment_method_qenta_checkout_page_<?php echo ( $this->_payments->has_payment_fields($type->code) ) ? esc_attr($type->code) : "" ?>" style="display:none;">
			<?php
			echo esc_attr($this->_payments->get_payment_fields($type->code));
		}
	}

	/**
	 * Basic validation for payment methods
	 *
	 * @since 1.3.0
	 *
	 * @return bool|void
	 */
	public function validate_fields() {
		$args         = $this->get_post_data();
		$payment_type = $args['qcp_payment_method'];
		$validation   = $this->_payments->validate_payment( $payment_type, $args );
		if ( $validation === true ) {
			return true;
		} else {
			wc_add_notice( $validation, 'error' );

			return;
		}
	}

	/**
	 * List of enables paymenttypes
	 *
	 * @return array
	 */
	protected function get_enabled_paymenttypes($is_on_payment = true) {
		$types = array();
		foreach ( $this->settings as $k => $v ) {
			if ( preg_match( '/^pt_(.+)$/', $k, $parts ) ) {
				if ( $v == 'yes' ) {
					$type        = new stdClass();
					$type->code  = $parts[1];
					$type->label = $this->get_paymenttype_name( $type->code );

					if ( method_exists( $this->_payments, 'get_risk' ) && $is_on_payment ) {
						$riskvalue = $this->_payments->get_risk( $type->code );
						if ( ! $riskvalue ) {
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
	 * @param $order
	 * @param $paymenttype
	 *
	 * @return string
	 * @throws Exception
	 */
	protected function initiate_payment( $order, $paymenttype, $birthday, $financial_inst ) {
		if ( isset( WC()->session->qenta_checkout_page_redirect_url ) && WC()->session->qenta_checkout_page_redirect_url['id'] == $order->get_id() ) {
			return WC()->session->qenta_checkout_page_redirect_url['url'];
		}

		$paymenttype = strtoupper( $paymenttype );

		try {
			$config = $this->_config->get_client_config();

      // TEST MODE OVERRIDE
      $customerId = $config['CUSTOMER_ID'];
      $orderDescription = ($customerId === 'D200410' && strtolower($paymenttype) === 'ccard') ? 'Test:0000' : $this->get_order_description( $order );

			$client = new QentaCEE\QPay\FrontendClient( $config );

      // consumer data (IP and User aget) are mandatory!
			$consumerData = new QentaCEE\Stdlib\ConsumerData();
			$consumerData->setUserAgent( $_SERVER['HTTP_USER_AGENT'] )->setIpAddress( WC_Geolocation::get_ip_address() );

			if ( $birthday !== null ) {
				$date = DateTime::createFromFormat( 'Y-m-d', $birthday );
				$consumerData->setBirthDate( $date );
			}
			$consumerData->setEmail( $order->get_billing_email() );

			if ( $this->get_option( 'send_consumer_shipping' ) == 'yes' ||
			     in_array( $paymenttype,
				     Array( QentaCEE\QPay\PaymentType::INVOICE, QentaCEE\QPay\PaymentType::INSTALLMENT ) )
			) {
				$consumerData->addAddressInformation( $this->get_consumer_data( $order, 'shipping' ) );
			}
			if ( $this->get_option( 'send_consumer_billing' ) == 'yes' ||
			     in_array( $paymenttype,
				     Array( QentaCEE\QPay\PaymentType::INVOICE, QentaCEE\QPay\PaymentType::INSTALLMENT ) )
			) {
				$consumerData->addAddressInformation( $this->get_consumer_data( $order, 'billing' ) );
			}

			$returnUrl = add_query_arg( 'wc-api', 'WC_Gateway_QCP', home_url( '/', is_ssl() ? 'https' : 'http' ) );

			$version = QentaCEE\QPay\FrontendClient::generatePluginVersion(
				$this->get_vendor(),
				WC()->version,
				WOOCOMMERCE_GATEWAY_QCP_NAME,
				WOOCOMMERCE_GATEWAY_QCP_VERSION
			);

			$client->setAmount( $order->get_total() )
			       ->setCurrency( get_woocommerce_currency() )
			       ->setPaymentType( $paymenttype )
			       ->setOrderDescription( $orderDescription )
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
			       ->setOrderReference( $this->get_order_reference( $order ) )
			       ->setCustomerStatement( $this->get_customer_statement( $order, $paymenttype ) )
			       ->setDuplicateRequestCheck( false )
			       ->setMaxRetries( $this->get_option( 'max_retries' ) )
			       ->createConsumerMerchantCrmId( $order->get_billing_email() )
			       ->setWindowName( WOOCOMMERCE_GATEWAY_QCP_WINDOWNAME );

			if ( WC()->session->get( 'qcpConsumerDeviceId' ) ) {
			    $client->consumerDeviceId = WC()->session->get( 'qcpConsumerDeviceId' );
			    WC()->session->set( 'qcpConsumerDeviceId', false );
            }
			if ( $financial_inst !== null ) {
				$client->setFinancialInstitution( $financial_inst );
			}
			$client->setAutoDeposit( false );

			if ( $this->get_option( 'send_basket_data' ) == 'yes' ||
			     ( $paymenttype == QentaCEE\QPay\PaymentType::INVOICE && $this->get_option( 'invoice_provider' ) != 'payolution' ) ||
			     ( $paymenttype == QentaCEE\QPay\PaymentType::INSTALLMENT && $this->get_option( 'installment_provider' ) != 'payolution' )
			) {
				$client->setBasket( $this->get_shopping_basket() );
			}

			$client->wooOrderId = $order->get_id();
			$response           = $client->initiate();
			if ( $response->hasFailed() ) {
				wc_add_notice(
					__( "Response failed! Error: {$response->getError()->getMessage()}", 'woocommerce-qcp' ),
					'error'
				);
				// throw new \Exception("Response failed! Error: {$response->getError()->getMessage()}", 500);
			}
		} catch ( Exception $e ) {
			throw ( $e );
		}

		WC()->session->qenta_checkout_page_redirect_url = array(
			'id'  => $order->get_id(),
			'url' => $response->getRedirectUrl()
		);

		return $response->getRedirectUrl();
	}

	/**
	 * Get billing/shipping address
	 *
	 * @since 1.3.0
	 * @access protected
	 *
	 * @param $order
	 * @param string $address
	 *
	 * @return QentaCEE\Stdlib\ConsumerData\Address
	 */
	protected function get_consumer_data( $order, $address = 'billing' ) {
		$consumer_address = 'billing';
		$type             = QentaCEE\Stdlib\ConsumerData\Address::TYPE_BILLING;
		$cart             = new WC_Cart();
		$cart->get_cart_from_session();

		//check if shipping address is different
		if ( $cart->needs_shipping_address() && $address == 'shipping' ) {
			$consumer_address = 'shipping';
			$type             = QentaCEE\Stdlib\ConsumerData\Address::TYPE_SHIPPING;
		}
		switch ( $consumer_address ) {
			case 'shipping':
				$shippingAddress = new QentaCEE\Stdlib\ConsumerData\Address( $type );

				$shippingAddress->setFirstname( $this->rmv_chars( $order->get_shipping_first_name() ) )
				                ->setLastname( $this->rmv_chars( $order->get_shipping_last_name() ) )
				                ->setAddress1( $this->rmv_chars( $order->get_shipping_address_1() ) )
				                ->setAddress2( $this->rmv_chars( $order->get_shipping_address_2() ) )
				                ->setCity( $this->rmv_chars( $order->get_shipping_city() ) )
				                ->setZipCode( $order->get_shipping_postcode() )
				                ->setCountry( $this->rmv_chars( $order->get_shipping_country() ) )
				                ->setState( $this->rmv_chars( $order->get_shipping_state() ) );

				return $shippingAddress;
			case 'billing':
			default:
				$billing_address = new QentaCEE\Stdlib\ConsumerData\Address( $type );

				$billing_address->setFirstname( $this->rmv_chars( $order->get_billing_first_name() ) )
				                ->setLastname( $this->rmv_chars( $order->get_billing_last_name() ) )
				                ->setAddress1( $this->rmv_chars( $order->get_billing_address_1() ) )
				                ->setAddress2( $this->rmv_chars( $order->get_billing_address_2() ) )
				                ->setCity( $this->rmv_chars( $order->get_billing_city() ) )
				                ->setZipCode( $order->get_billing_postcode() )
				                ->setCountry( $this->rmv_chars( $order->get_billing_country() ) )
				                ->setPhone( $order->get_billing_phone() )
				                ->setState( $this->rmv_chars( $order->get_billing_state() ) );

				return $billing_address;
		}

	}

	/**
	 * Remove invalid chars and trim
	 *
     * @since 1.3.1
     *
	 * @param $string
	 *
	 * @return string
	 */
	protected function rmv_chars( $string ) {
		return trim( preg_replace( '/[\']/i', ' ', $string ) );
	}

	/**
	 * Generate shopping basket
	 *
	 * @since 1.3.0
	 * @access protected
	 * @return QentaCEE\Stdlib\Basket
	 */
	protected function get_shopping_basket() {
		global $woocommerce;

		$cart = $woocommerce->cart;
		$basket = new QentaCEE\Stdlib\Basket();

		foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {
			$article_nr = $cart_item['product_id'];
			if ( $cart_item['data']->get_sku() != '' ) {
				$article_nr = $cart_item['data']->get_sku();
			}

			$attachment_ids = $cart_item['data']->get_gallery_image_ids();
			foreach ( $attachment_ids as $attachment_id ) {
				$image_url = wp_get_attachment_image_url( $attachment_id );
			}

			$item            = new QentaCEE\Stdlib\Basket\Item( $article_nr );
			$item_net_amount = $cart_item['line_total'];
			$item_tax_amount = $cart_item['line_tax'];
			$item_quantity   = $cart_item['quantity'];

			// Calculate amounts per unit
			$item_unit_net_amount   = $item_net_amount / $item_quantity;
			$item_unit_tax_amount   = $item_tax_amount / $item_quantity;
			$item_unit_gross_amount = wc_format_decimal( $item_unit_net_amount + $item_unit_tax_amount,
				wc_get_price_decimals() );

			$item->setUnitGrossAmount( $item_unit_gross_amount )
			     ->setUnitNetAmount( wc_format_decimal( $item_unit_net_amount, wc_get_price_decimals() ) )
			     ->setUnitTaxAmount( wc_format_decimal( $item_unit_tax_amount, wc_get_price_decimals() ) )
			     ->setUnitTaxRate( number_format( ( $item_unit_tax_amount / $item_unit_net_amount ), 2, '.', '' ) * 100 )
			     ->setDescription( substr( strip_tags( $cart_item['data']->get_short_description() ), 0, 127 ) )
			     ->setName( substr( strip_tags( $cart_item['data']->get_name() ), 0, 127 ) )
			     ->setImageUrl( isset( $image_url ) ? $image_url : '' );

			$basket->addItem( $item, $item_quantity );
		}

		// Add shipping to the basket
		if ( isset( $cart->shipping_total ) && $cart->shipping_total > 0 ) {
			$item = new QentaCEE\Stdlib\Basket\Item( 'shipping' );
			$item->setUnitGrossAmount( wc_format_decimal( $cart->shipping_total + $cart->shipping_tax_total,
				wc_get_price_decimals() ) )
			     ->setUnitNetAmount( wc_format_decimal( $cart->shipping_total, wc_get_price_decimals() ) )
			     ->setUnitTaxAmount( wc_format_decimal( $cart->shipping_tax_total, wc_get_price_decimals() ) )
			     ->setUnitTaxRate( number_format( ( $cart->shipping_tax_total / $cart->shipping_total ), 2, '.', '' ) * 100 )
			     ->setName( 'Shipping' )
			     ->setDescription( 'Shipping' );
			$basket->addItem( $item );
		}

		return $basket;
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
		return __( $code, 'woocommerce-qcp' );
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
		return sprintf( '%s %s %s', $order->get_billing_email(), $order->get_billing_first_name(),
			$order->get_billing_last_name() );
	}

	/**
	 * Generate order reference
	 *
	 * @param $order WC_Order
	 *
	 * @since 1.3.0
	 * @return string
	 */
	protected function get_order_reference( $order ) {
		return sprintf( '%010s', substr( $order->get_id(), - 10 ) );
	}

	/**
	 * Generate customer statement
	 *
	 * @since 1.3.0
	 *
	 * @param $order
	 * @param $payment_type
	 *
	 * @return string
	 */
	protected function get_customer_statement( $order, $payment_type ) {
		$shop_name = get_bloginfo('name');
		$order_reference = strval( intval( $this->get_order_reference( $order ) ) );

		if ( $payment_type == QentaCEE\QPay\PaymentType::POLI ) {
			return sprintf( '%9s', substr( get_bloginfo( 'name' ), 0, 9 ) );
		}

		$length = strlen( $shop_name . " " . $order_reference );

		if ( $length > 20 ) {
			$shop_name = substr($shop_name, 0, 20 - strlen(" " . $order_reference));
		}

		else if ( $length < 20 ) {
			$order_reference = str_pad($order_reference, (20 - $length) + strlen($order_reference), '0', STR_PAD_LEFT);
		}

		return $shop_name . " " . $order_reference;
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
	protected function log( $str, $level = 'info' ) {
		if ( $this->get_option('debug') == 'yes' ) {
			if ( empty( $this->log ) ) {
				$this->log = new WC_Logger();
			}
			$this->log->$level( 'QentaCheckoutPage: ' . $str );
		}
	}

	/**
	 * Remove deprecated payment methods from database
	 *
	 * @since 1.3.0
	 * @access protected
	 */
	protected function remove_old_payments() {
		global $wpdb;

		$options      = $wpdb->get_var( "SELECT option_value FROM {$wpdb->prefix}options WHERE option_name='woocommerce_qenta_checkout_page_settings';" );
		$option_array = unserialize( $options );

		if ( ! empty( $option_array ) ) {
			foreach ( $option_array as $k => $v ) {
				switch ( $k ) {
					case 'pt_elv':
						unset( $option_array[ $k ] );
						break;
				}
			}
		}
		$options = serialize( $option_array );
		$wpdb->update( $wpdb->prefix . 'options', array( 'option_value' => $options ),
			array( 'option_name' => 'woocommerce_qenta_checkout_page_settings' ) );
	}
}
