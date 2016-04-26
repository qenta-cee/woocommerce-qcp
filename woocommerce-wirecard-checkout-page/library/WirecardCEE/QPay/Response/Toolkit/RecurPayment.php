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
 * @name WirecardCEE_QPay_Response_Toolkit_RecurPayment
 * @category WirecardCEE
 * @package WirecardCEE_QPay
 * @subpackage Response_Toolkit
 * @version 3.0.0
 */
class WirecardCEE_QPay_Response_Toolkit_RecurPayment extends WirecardCEE_QPay_Response_Toolkit_ResponseAbstract {
	/**
	 * Order number
	 * @staticvar string
	 * @internal
	 */
	private static $ORDER_NUMBER = 'orderNumber';

	/**
	 * getter for the returned order number
	 *
	 * @return string
	 */
	public function getOrderNumber() {
		return $this->_getField(self::$ORDER_NUMBER);
	}
}