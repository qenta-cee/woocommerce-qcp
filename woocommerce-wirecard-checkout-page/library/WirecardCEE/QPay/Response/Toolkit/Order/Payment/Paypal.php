<?php
/*
* Die vorliegende Software ist Eigentum von Wirecard CEE und daher vertraulich
* zu behandeln. Jegliche Weitergabe an dritte, in welcher Form auch immer, ist
* unzulaessig.
*
* Software & Service Copyright (C) by
* Wirecard Central Eastern Europe GmbH,
* FB-Nr: FN 195599 x, http://www.wirecard.at
*/

/**
 * @name WirecardCEE_QPay_Response_Toolkit_Order_Payment_Paypal
 * @category WirecardCEE
 * @package WirecardCEE_QPay
 * @subpackage Response_Toolkit_Order_Payment
 * @version 3.0.0
 */
class WirecardCEE_QPay_Response_Toolkit_Order_Payment_Paypal extends WirecardCEE_QPay_Response_Toolkit_Order_Payment {
	/**
	 * PayPal - payer ID
	 * @staticvar string
	 * @internal
	 */
	private static $PAYER_ID 				= 'paypalPayerID';

	/**
	 * PayPal - payer email
	 * @staticvar string
	 * @internal
	 */
	private static $PAYER_EMAIL 			= 'paypalPayerEmail';

	/**
	 * PayPal - payer first name
	 * @staticvar string
	 * @internal
	 */
	private static $PAYER_FIRST_NAME 		= 'paypalPayerFirstName';

	/**
	 * PayPal - payer last name
	 * @staticvar string
	 * @internal
	 */
	private static $PAYER_LAST_NAME 		= 'paypalPayerLastName';

	/**
	 * PayPal - payer address - coountry
	 * @staticvar string
	 * @internal
	 */
	private static $PAYER_ADDRESS_COUNTRY 	= 'paypalPayerAddressCountry';

	/**
	 * PayPal - payer address - city
	 * @staticvar string
	 * @internal
	 */
	private static $PAYER_ADDRESS_CITY 		= 'paypalPayerAddressCity';

	/**
	 * PayPal - payer address - state
	 * @staticvar string
	 * @internal
	 */
	private static $PAYER_ADDRESS_STATE 	= 'paypalPayerAddressState';

	/**
	 * PayPal - payer address - name
	 * @staticvar string
	 * @internal
	 */
	private static $PAYER_ADDRESS_NAME 		= 'paypalPayerAddressName';

	/**
	 * PayPal - payer address - street 1
	 * @staticvar string
	 * @internal
	 */
	private static $PAYER_ADDRESS_STREET_1 	= 'paypalPayerAddressStreet1';

	/**
	 *PayPal - payer address - street 2
	 * @staticvar string
	 * @internal
	 */
	private static $PAYER_ADDRESS_STREET_2 	= 'paypalPayerAddressStreet2';

	/**
	 * PayPal - payer address - zip
	 * @staticvar string
	 * @internal
	 */
	private static $PAYER_ADDRESS_ZIP 		= 'paypalPayerAddressZIP';

	/**
	 * PayPal - payer address - status
	 * @staticvar string
	 * @internal
	 */
	private static $PAYER_ADDRESS_STATUS 	= 'paypalPayerAddressStatus';

	/**
	 * PayPal - payer eligibility
	 * @staticvar string
	 * @internal
	 */
	private static $PROTECTION_ELIGIBILITY 	= 'paypalProtectionEligibility';

	/**
	 * getter for PayPal payerID
	 *
	 * @return string
	 */
	public function getPayerId() {
		return $this->_getField(self::$PAYER_ID);
	}

	/**
	 * getter for PayPal payer email
	 *
	 * @return string
	 */
	public function getPayerEmail() {
		return $this->_getField(self::$PAYER_EMAIL);
	}

	/**
	 * getter for PayPal payer firstname
	 *
	 * @return string
	 */
	public function getPayerFirstName() {
		return $this->_getField(self::$PAYER_FIRST_NAME);
	}

	/**
	 * getter for PayPal payer lastname
	 *
	 * @return string
	 */
	public function getPayerLastName() {
		return $this->_getField(self::$PAYER_LAST_NAME);
	}

	/**
	 * getter for PayPal payer country address field
	 *
	 * @return string
	 */
	public function getPayerAddressCountry() {
		return $this->_getField(self::$PAYER_ADDRESS_COUNTRY);
	}

	/**
	 * getter for PayPal payer city address field
	 *
	 * @return string
	 */
	public function getPayerAddressCity() {
		return $this->_getField(self::$PAYER_ADDRESS_CITY);
	}

	/**
	 * getter for PayPal payer state address field
	 *
	 * @return string
	 */
	public function getPayerAddressState() {
		return $this->_getField(self::$PAYER_ADDRESS_STATE);
	}

	/**
	 * getter for PayPal payer name address field
	 *
	 * @return string
	 */
	public function getPayerAddressName() {
		return $this->_getField(self::$PAYER_ADDRESS_NAME);
	}

	/**
	 * getter for PayPal payer street 1 address field
	 *
	 * @return string
	 */
	public function getPayerAddressStreet1() {
		return $this->_getField(self::$PAYER_ADDRESS_STREET_1);
	}

	/**
	 * getter for PayPal payer street 2 address field
	 *
	 * @return string
	 */
	public function getPayerAddressStreet2() {
		return $this->_getField(self::$PAYER_ADDRESS_STREET_2);
	}

	/**
	 * getter for PayPal payer zipcode address field
	 *
	 * @return string
	 */
	public function getPayerAddressZip() {
		return $this->_getField(self::$PAYER_ADDRESS_ZIP);
	}

	/**
	 * getter for PayPal payer address status
	 *
	 * @return string
	 */
	public function getPayerAddressStatus() {
		return $this->_getField(self::$PAYER_ADDRESS_STATUS);
	}

	/**
	 * getter for PayPal protection eligibility
	 *
	 * @return string
	 */
	public function getProtectionEligibility() {
		return $this->_getField(self::$PROTECTION_ELIGIBILITY);
	}
}