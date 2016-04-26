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
 * @name WirecardCEE_QPay_Response_Toolkit_Order_Payment_Ideal
 * @category WirecardCEE
 * @package WirecardCEE_QPay
 * @subpackage Response_Toolkit_Order_Payment
 * @version 3.0.0
 */
class WirecardCEE_QPay_Response_Toolkit_Order_Payment_Ideal extends WirecardCEE_QPay_Response_Toolkit_Order_Payment {
	/**
	 * iDEAL consumer name
	 * @staticvar string
	 * @internal
	 */
	private static $CONSUMER_NAME 			= 'idealConsumerName';

	/**
	 * iDEAL consumer city
	 * @staticvar string
	 * @internal
	 */
	private static $CONSUMER_CITY			= 'idealConsumerCity';

	/**
	 *  iDEAL consumer city
	 * @staticvar string
	 * @internal
	 */
	private static $CONSUMER_ACCOUNT_NUMBER = 'idealConsumerAccountNumber';

	/**
	 * getter for iDEAL consumer Name
	 *
	 * @return string
	 */
	public function getConsumerName() {
		return $this->_getField(self::$CONSUMER_NAME);
	}

	/**
	 * getter for iDEAL consumer City
	 *
	 * @return string
	 */
	public function getConsumerCity() {
		return $this->_getField(self::$CONSUMER_CITY);
	}

	/**
	 * getter for iDEAL consumer account-number
	 *
	 * @return string
	 */
	public function getConsumerAccountNumber() {
		return $this->_getField(self::$CONSUMER_ACCOUNT_NUMBER);
	}
}