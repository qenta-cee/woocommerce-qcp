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
 * @name WirecardCEE_QPay_Response_Toolkit_Deposit
 * @category WirecardCEE
 * @package WirecardCEE_QPay
 * @subpackage Response_Toolkit
 * @version 3.0.0
 */
class WirecardCEE_QPay_Response_Toolkit_Deposit extends WirecardCEE_QPay_Response_Toolkit_ResponseAbstract {
	/**
	 * Payment number
	 * @staticvar string
	 */
	private static $PAYMENT_NUMBER = 'paymentNumber';

	/**
	 * getter for the returned paymentNumber
	 *
	 * @return string
	 */
	public function getPaymentNumber() {
		return $this->_getField(self::$PAYMENT_NUMBER);
	}
}