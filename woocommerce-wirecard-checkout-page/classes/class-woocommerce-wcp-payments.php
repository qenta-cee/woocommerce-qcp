<?php

/**
 * Shop System Plugins - Terms of Use
 *
 * The plugins offered are provided free of charge by Wirecard Central Eastern Europe GmbH
 * (abbreviated to Wirecard CEE) and are explicitly not part of the Wirecard CEE range of
 * products and services.
 *
 * They have been tested and approved for full functionality in the standard configuration
 * (status on delivery) of the corresponding shop system. They are under General Public
 * License Version 2 (GPLv2) and can be used, developed and passed on to third parties under
 * the same terms.
 *
 * However, Wirecard CEE does not provide any guarantee or accept any liability for any errors
 * occurring when used in an enhanced, customized shop system configuration.
 *
 * Operation in an enhanced, customized configuration is at your own risk and requires a
 * comprehensive test phase by the user of the plugin.
 *
 * Customers use the plugins at their own risk. Wirecard CEE does not guarantee their full
 * functionality neither does Wirecard CEE assume liability for any disadvantages related to
 * the use of the plugins. Additionally, Wirecard CEE does not guarantee the full functionality
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
 * @since 2.2.0
 */
class WC_Gateway_WCP_Payments {

	/**
	 * Payment gateway settings
	 *
	 * @since 2.2.0
	 * @access protected
	 * @var array
	 */
	protected $_settings;

	/**
	 * WC_Gateway_WCP_Payments constructor.
	 *
	 * @since 2.2.0
	 *
	 * @param $gateway_settings
	 */
	public function __construct( $gateway_settings ) {
		$this->_settings = $gateway_settings;
	}

	/**
	 * Returns url to payment method logo
	 *
	 * @since 2.2.0
	 *
	 * @param $payment_code
	 *
	 * @return string
	 */
	public function get_payment_icon( $payment_code ) {
		return WOOCOMMERCE_GATEWAY_WCP_URL . "assets/images/" . $payment_code . ".png";
	}

	/**
	 * returns true because the payment method has input fields
	 *
	 * @since 1.0.0
	 *
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

	public function get_payment_fields( $payment_code ) {
		switch ($payment_code) {
			case 'invoice':
			case 'installment':
			$html = "<fieldset class='wc-invoice-installment-form wc-payment-form'>";
			$html .= '';

			// account owner field
			$html .= "<p class='form-row'>";
			$html .= "<label>" . __( 'Date of Birth:',
					'woocommerce-wcp' ) . "</label>";
			$html .= "<select name='dob_day' class=''>";

			for ( $day = 31; $day > 0; $day -- ) {
				$html .= "<option value='$day'> $day </option>";
			}

			$html .= "</select>";

			$html .= "<select name='dob_month' class=''>";
			for ( $month = 12; $month > 0; $month -- ) {
				$html .= "<option value='$month'> $month </option>";
			}
			$html .= "</select>";

			$html .= "<select name='dob_year' class=''>";
			for ( $year = date( "Y" ); $year > 1920; $year -- ) {
				$html .= "<option value='$year'> $year </option>";
			}
			$html .= "</select>";
			$html .= "</p>";


			if ( ($this->_settings['payolution_terms'] && $this->_settings['invoice_provider'] == 'payolution') ||
			     ($this->_settings['payolution_terms'] && $this->_settings['installment_provider'] == 'payolution')) {

				$payolution_mid = urlencode( base64_encode( $this->_settings['payolution_mid'] ) );

				$consent_link = __( 'consent', 'woocommerce-wcp' );

				if ( strlen( $this->_settings['payolution_mid'] ) > 5 ) {
					$consent_link = sprintf( '<a href="https://payment.payolution.com/payolution-payment/infoport/dataprivacyconsent?mId=%s" target="_blank">%s</a>',
						$payolution_mid,
						__( 'consent', 'woocommerce-wcp' ) );
				}

				$html .= "<p class='form-row'>";

				$html .= "<label><input type='checkbox' name='consent'>"
				         . __( 'I agree that the data which are necessary for the liquidation of purchase on account and which are used to complete the identity and credit check are transmitted to payolution. My ', 'woocommerce-wcp' )
				         . $consent_link
				         . __(' can be revoked at any time with effect for the future.', 'woocommerce-wcp' ) . "</label>";

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
						'woocommerce-wcp' ) . " <span class='required'>*</span></label>";
				$html .= "<select name='wcp_eps_financialInstitution' autocomplete='off'>";
				$html .= "<option value=''>" . __( 'Choose your bank', 'woocommerce-wcp' ) . "</option>";
				foreach ( WirecardCEE_Stdlib_PaymentTypeAbstract::getFinancialInstitutions( WirecardCEE_Stdlib_PaymentTypeAbstract::EPS ) as $key => $value ) {
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
						'woocommerce-wcp' ) . " <span class='required'>*</span></label>";
				$html .= "<select name='wcp_idl_financialInstitution' autocomplete='off'>";
				$html .= "<option value=''>" . __( 'Choose your bank', 'woocommerce-wcp' ) . "</option>";
				foreach ( WirecardCEE_Stdlib_PaymentTypeAbstract::getFinancialInstitutions( WirecardCEE_Stdlib_PaymentTypeAbstract::IDL ) as $key => $value ) {
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
}
