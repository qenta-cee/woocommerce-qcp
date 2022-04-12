<?php

/**
 * Shop System Plugins - Terms of Use
 *
 * The plugins offered are provided free of charge by Qenta Payment CEE GmbH
 * (abbreviated to Qenta CEE) and are explicitly not part of the Qenta CEE range of
 * products and services.
 *
 * They have been tested and approved for full functionality in the standard configuration
 * (status on delivery) of the corresponding shop system. They are under General Public
 * License Version 2 (GPLv2) and can be used, developed and passed on to third parties under
 * the same terms.
 *
 * However, Qenta CEE does not provide any guarantee or accept any liability for any errors
 * occurring when used in an enhanced, customized shop system configuration.
 *
 * Operation in an enhanced, customized configuration is at your own risk and requires a
 * comprehensive test phase by the user of the plugin.
 *
 * Customers use the plugins at their own risk. Qenta CEE does not guarantee their full
 * functionality neither does Qenta CEE assume liability for any disadvantages related to
 * the use of the plugins. Additionally, Qenta CEE does not guarantee the full functionality
 * for customized shop systems or installed plugins of other vendors of plugins within the same
 * shop system.
 *
 * Customers are responsible for testing the plugin's functionality before starting productive
 * operation.
 *
 * By installing the plugin into the shop system the customer agrees to these terms of use.
 * Please do not use the plugin if you do not agree to these terms of use!
 */

/**
 * Config class
 *
 * Handles payment fields and pre-checks for special paymentmethods
 *
 * @since 1.3.0
 */
class WC_Gateway_QCP_Payments {

	/**
	 * Payment gateway settings
	 *
	 * @since 1.3.0
	 * @access protected
	 * @var array
	 */
	protected $_settings;

	/**
	 * WC_Gateway_QCP_Payments constructor.
	 *
	 * @since 1.3.0
	 *
	 * @param $gateway_settings
	 */
	public function __construct( $gateway_settings ) {
		$this->_settings = $gateway_settings;
	}

	/**
	 * Returns url to payment method logo
	 *
	 * @since 1.3.0
	 *
	 * @param $payment_code
	 *
	 * @return string
	 */
	public function get_payment_icon( $payment_code ) {
		return WOOCOMMERCE_GATEWAY_QCP_URL . "assets/images/" . $payment_code . ".png";
	}

	/**
	 * Returns true if the payment method needs form fields
	 *
	 * @since 1.3.0
	 *
     * @param $payment_code
	 * @return bool
	 */
	public function has_payment_fields( $payment_code ) {
		switch ($payment_code) {
			case 'invoice':
			case 'installment':
			case 'eps':
			case 'idl':
				return true;
			default:
				return false;
		}
	}

	/**
	 * Prints form fields for specific payment methods
	 *
	 * @since 1.3.0
	 *
	 * @param $payment_code
	 *
	 * @return string|void
	 */
	public function get_payment_fields( $payment_code ) {
		switch ( $payment_code ) {
			case 'invoice':
			case 'installment':
				$html  = "<fieldset class='wc-invoice-installment-form wc-payment-form'>";
				$html  .= '';

				// account owner field
				$html .= "<p class='form-row'>";
				$html .= "<label>" . __( 'Date of Birth:', 'woocommerce-qcp' ) . "</label>";
				$html .= "<select name='".$payment_code."_qcp_day' class=''>";

				for ( $day = 31; $day > 0; $day -- ) {
					$html .= "<option value='$day'> $day </option>";
				}

				$html .= "</select>";

				$html .= "<select name='".$payment_code."_qcp_month' class=''>";
				for ( $month = 12; $month > 0; $month -- ) {
					$html .= "<option value='$month'> $month </option>";
				}
				$html .= "</select>";

				$html .= "<select name='".$payment_code."_qcp_year' class=''>";
				for ( $year = date( "Y" ); $year > 1900; $year -- ) {
					$html .= "<option value='$year'> $year </option>";
				}
				$html .= "</select>";
				$html .= "</p>";

				if ( ( $this->_settings['payolution_terms'] == 'yes' && $this->_settings['invoice_provider'] == 'payolution' && $payment_code == 'invoice' ) ||
				     ( $this->_settings['payolution_terms'] == 'yes' && $this->_settings['installment_provider'] == 'payolution' && $payment_code == 'installment' )
				) {

					$payolution_mid = urlencode( base64_encode( $this->_settings['payolution_mid'] ) );

					$consent_link = __( 'consent', 'woocommerce-qcp' );

					if ( strlen( $this->_settings['payolution_mid'] ) > 5 ) {
						$consent_link = sprintf( '<a href="https://payment.payolution.com/payolution-payment/infoport/dataprivacyconsent?mId=%s" target="_blank">%s</a>',
							$payolution_mid,
							__( 'consent', 'woocommerce-qcp' ) );
					}

					$html .= "<p class='form-row'>";

					$html .= "<label><input type='checkbox' name='".$payment_code."_consent'>"
					         . __( 'I agree that the data which are necessary for the liquidation of purchase on account and which are used to complete the identity and credit check are transmitted to payolution. My ',
							'woocommerce-qcp' )
					         . $consent_link
					         . __( ' can be revoked at any time with effect for the future.',
							'woocommerce-qcp' ) . "</label>";

					$html .= "</p>";
				}

				$html .= "</fieldset>";

				return $html;
				break;
			case 'eps':
				$html = '<fieldset  class="wc-eps-form wc-payment-form">';

				// dropdown for financial institution
				$html .= "<p class='form-row'>";
				$html .= "<label>" . __( 'Financial institution:',
						'woocommerce-qcp' ) . " <span class='required'>*</span></label>";
				$html .= "<select name='qcp_eps_financialInstitution' autocomplete='off'>";
				$html .= "<option value=''>" . __( 'Choose your bank', 'woocommerce-qcp' ) . "</option>";
				foreach ( QentaCEE\Stdlib\PaymentTypeAbstract::getFinancialInstitutions( QentaCEE\Stdlib\PaymentTypeAbstract::EPS ) as $key => $value ) {
					$html .= "<option value='$key'>$value</option>";
				}

				$html .= "</select>";
				$html .= "</p>";

				$html .= '</fieldset>';

				return $html;
				break;
			case 'idl':
				$html = '<fieldset  class="wc-idl-form wc-payment-form">';

				// dropdown for financial institution
				$html .= "<p class='form-row'>";
				$html .= "<label>" . __( 'Financial institution:',
						'woocommerce-qcp' ) . " <span class='required'>*</span></label>";
				$html .= "<select name='qcp_idl_financialInstitution' autocomplete='off'>";
				$html .= "<option value=''>" . __( 'Choose your bank', 'woocommerce-qcp' ) . "</option>";
				foreach ( QentaCEE\Stdlib\PaymentTypeAbstract::getFinancialInstitutions( QentaCEE\Stdlib\PaymentTypeAbstract::IDL ) as $key => $value ) {
					$html .= "<option value='$key'>$value</option>";
				}

				$html .= "</select>";
				$html .= "</p>";

				$html .= '</fieldset>';

				return $html;
				break;
			default:
				return;
		}
	}

    /**
     * Validate payment methods with form fields
     *
     * @param $payment_code
     * @param $data
     *
     * @return bool|string
     * @throws Exception
     * @since 1.3.0
     *
     */
	public function validate_payment( $payment_code, $data ) {
		switch ( $payment_code ) {
			case 'invoice':
			case 'installment':
				$birthdate = new DateTime( $data[$payment_code.'_qcp_year'] . '-' . $data[$payment_code.'_qcp_month'] . '-' . $data[$payment_code.'_qcp_day'] );
				$age = $birthdate->diff( new DateTime );
				$age = $age->format( '%y' );

				$errors = [];

				$hasConsent = isset($data[$payment_code.'_consent']) && $data[$payment_code.'_consent'] == 'on';

				if ( $this->_settings['payolution_terms'] == 'yes' && !$hasConsent && $this->_settings[ $payment_code . '_provider' ] == 'payolution' ) {
					$errors[] = "&bull; " . __( 'Please accept the consent terms!', 'woocommerce-qcp' );
				}
				if ( $age < 18 ) {
					$errors[] = "&bull; " . __( 'You have to be 18 years or older to use this payment.',
							'woocommerce-qcp' );
				}

				return count( $errors ) == 0 ? true : join( "<br>", $errors );
			case 'eps':
				$errors = [];
				if ( $data['qcp_eps_financialInstitution'] == '' ) {
					$errors[] = "&bull; " . __( 'Financial institution must not be empty.', 'woocommerce-qcp' );
				}

				return count( $errors ) == 0 ? true : join( "<br>", $errors );
			case 'idl':
				if ( $data['qcp_idl_financialInstitution'] == '' ) {
					$errors[] = "&bull; " . __( 'Financial institution must not be empty.', 'woocommerce-qcp' );
				}

				return count( $errors ) == 0 ? true : join( "<br>", $errors );
			default:
				return true;
		}
	}

	/**
	 * Basic risk check for specific payment methods
	 *
	 * @since 1.3.0
	 *
     * @param $payment_code
	 * @return boolean
	 */
	public function get_risk( $payment_code ) {
		switch ( $payment_code ) {
			case 'invoice':
				return $this->is_available_invoice();
			default:
				return true;
		}
	}

	/**
	 * Risk management for invoice
	 *
	 * @since 1.3.0
	 * @access private
	 *
	 * @return bool
	 */
	private function is_available_invoice() {
		global $woocommerce;
		$customer = $woocommerce->customer;

		// if the currency isn't allowed
		if ( ! is_array( $this->_settings['invoice_currencies'] ) || ! in_array( get_woocommerce_currency(),
				$this->_settings['invoice_currencies'] )
		) {
			return false;
		}
		$cart = new WC_Cart();
		$cart->get_cart_from_session();
		// if cart total is smaller than set limit
		if ( $cart->total <= floatval( $this->_settings['invoice_min_amount'] ) ) {
			return false;
		}
		// if cart total is greater than set limit
		if ( floatval( $this->_settings['invoice_max_amount'] ) != 0 && $cart->total >= floatval( $this->_settings['invoice_max_amount'] ) ) {
			return false;
		}

		foreach ( $cart->get_cart() as $hash => $item ) {
			$product = new WC_Product( $item['product_id'] );
			// if the product is in the "digital goods" category, do not show invoice as payment method
			if ( $product->is_downloadable() || $product->is_virtual() ) {
				return false;
			}
		}

		// check if shipping country is allowed
		if ( ! in_array( $customer->get_shipping_country(),
				$this->_settings['invoice_shipping_countries'] ) && ! empty( $customer->get_shipping_country() )
		) {
			return false;
		}
		// check if billing country is allowed
		if ( ! in_array( $customer->get_billing_country(),
				$this->_settings['invoice_billing_countries'] ) && ! empty( $customer->get_billing_country() )
		) {
			return false;
		}

		if ( $this->_settings['invoice_provider'] == 'payolution' && $this->_settings['invoice_shipping'] == 'yes' ) {
			return $this->compare_billing_shipping_address();
		}

		return true;
	}

	/**
	 * Risk management for installment
	 *
	 * @since 1.3.0
	 * @access private
	 *
	 * @return bool
	 */
	private function is_available_installment() {
		global $woocommerce;
		$customer = $woocommerce->customer;

		// if the currency isn't allowed
		if ( ! is_array( $this->_settings['installment_currencies'] ) || ! in_array( get_woocommerce_currency(),
				$this->_settings['installment_currencies'] )
		) {
			return false;
		}
		$cart = new WC_Cart();
		$cart->get_cart_from_session();
		// if cart total is smaller than set limit
		if ( $cart->total <= floatval( $this->_settings['installment_min_amount'] ) ) {
			return false;
		}
		// if cart total is greater than set limit
		if ( floatval( $this->_settings['installment_max_amount'] ) != 0 && $cart->total >= floatval( $this->_settings['installment_max_amount'] ) ) {
			return false;
		}

		foreach ( $cart->get_cart() as $hash => $item ) {
			$product = new WC_Product( $item['product_id'] );
			// if the product is in the "digital goods" category, do not show invoice as payment method
			if ( $product->is_downloadable() || $product->is_virtual() ) {
				return false;
			}
		}

		// check if shipping country is allowed
		if ( ! in_array( $customer->get_shipping_country(),
				$this->_settings['installment_shipping_countries'] ) && ! empty( $customer->get_shipping_country() )
		) {
			return false;
		}
		// check if billing country is allowed
		if ( ! in_array( $customer->get_billing_country(),
				$this->_settings['installment_billing_countries'] ) && ! empty( $customer->get_billing_country() )
		) {
			return false;
		}

		if ( $this->_settings['installment_provider'] == 'payolution' && $this->_settings['installment_shipping'] == 'yes' ) {
			return $this->compare_billing_shipping_address();
		}

		return true;
	}

	/**
	 * Compares billing and shipping address returns false if they aren't identical
	 *
	 * @since 1.3.0
	 * @access private
	 *
	 * @return bool
	 */
	private function compare_billing_shipping_address() {
		global $woocommerce;
		$customer = $woocommerce->customer;
		$fields   = array(
			'first_name',
			'last_name',
			'address_1',
			'address_2',
			'city',
			'country',
			'postcode',
			'state'
		);
		foreach ( $fields as $f ) {
			$m1 = "get_billing_$f";
			$m2 = "get_shipping_$f";

			$f1 = call_user_func(
				array(
					$customer,
					$m1
				)
			);

			$f2 = call_user_func(
				array(
					$customer,
					$m2
				)
			);
			if ( $f1 != $f2 && ! empty( $f2 ) ) {
				return false;
			}
		}

		return true;
	}
}
