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
 * @name WirecardCEE_QPay_Response_Toolkit_Refund
 * @category WirecardCEE
 * @package WirecardCEE_QPay
 * @subpackage Response_Toolkit
 * @version 3.0.0
 */
class WirecardCEE_QPay_Response_Toolkit_Refund extends WirecardCEE_QPay_Response_Toolkit_ResponseAbstract {
	/**
	 * Credit number
	 * @staticvar string
	 * @internal
	 */
	private static $CREDIT_NUMBER = 'creditNumber';

	/**
	 * getter for the returned credit number
	 *
	 * @return string
	 */
	public function getCreditNumber() {
		return $this->_getField(self::$CREDIT_NUMBER);
	}
}
