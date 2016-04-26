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
 * @name WirecardCEE_QPay_Response_Toolkit_Order_Payment_Sofortueberweisung
 * @category WirecardCEE
 * @package WirecardCEE_QPay
 * @subpackage Response_Toolkit_Order_Payment
 * @version 3.0.0
 */
class WirecardCEE_QPay_Response_Toolkit_Order_Payment_Sofortueberweisung extends WirecardCEE_QPay_Response_Toolkit_Order_Payment {
	/**
	 * Sender - account owner
	 * @staticvar string
	 * @internal
	 */
	private static $SENDER_ACCOUNT_OWNER 	= 'senderAccountOwner';

	/**
	 * Sender - account number
	 * @staticvar string
	 * @internal
	 */
	private static $SENDER_ACCOUNT_NUMBER 	= 'senderAccountNumber';

	/**
	 * Sender - bank number
	 * @staticvar string
	 * @internal
	 */
	private static $SENDER_BANK_NUMBER 		= 'senderBankNumber';

	/**
	 * Sender - bank name
	 * @staticvar string
	 * @internal
	 */
	private static $SENDER_BANK_NAME 		= 'senderBankName';

	/**
	 * Sender - BIC
	 * @staticvar string
	 * @internal
	 */
	private static $SENDER_BIC 				= 'senderBIC';

	/**
	 * Sender - IBAN
	 * @staticvar string
	 * @internal
	 */
	private static $SENDER_IBAN 			= 'senderIBAN';

	/**
	 * Sender - Country
	 * @staticvar string
	 * @internal
	 */
	private static $SENDER_COUNTRY 			= 'senderCountry';

	/**
	 * Security criteria
	 * @staticvar string
	 * @internal
	 */
	private static $SECURITY_CRITERIA 		= 'securityCriteria';

	/**
	 * getter for sofortueberweisung.de sender account owner
	 *
	 * @return string
	 */
	public function getSenderAccountOwner() {
		return $this->_getField(self::$SENDER_ACCOUNT_OWNER);
	}

	/**
	 * getter for sofortueberweisung.de sender account number
	 *
	 * @return string
	 */
	public function getSenderAccountNumber() {
		return $this->_getField(self::$SENDER_ACCOUNT_NUMBER);
	}

	/**
	 * getter for sofortueberweisung.de sender bank number
	 *
	 * @return string
	 */
	public function getSenderBankNumber() {
		return $this->_getField(self::$SENDER_BANK_NUMBER);
	}

	/**
	 * getter for sofortueberweisung.de sender bank name
	 *
	 * @return string
	 */
	public function getSenderBankName() {
		return $this->_getField(self::$SENDER_BANK_NAME);
	}

	/**
	 * getter for sofortueberweisung.de sender BIC
	 *
	 * @return string
	 */
	public function getSenderBic() {
		return $this->_getField(self::$SENDER_BIC);
	}

	/**
	 * getter for sofortueberweisung.de sender IBAN
	 *
	 * @return string
	 */
	public function getSenderIban() {
		return $this->_getField(self::$SENDER_IBAN);
	}

	/**
	 * getter for sofortueberweisung.de sender country
	 *
	 * @return string
	 */
	public function getSenderCountry() {
		return $this->_getField(self::$SENDER_COUNTRY);
	}

	/**
	 * getter for sofortueberweisung.de Security criteria
	 *
	 * @return string
	 */
	public function getSecurityCriteria() {
		return $this->_getField(self::$SECURITY_CRITERIA);
	}
}
