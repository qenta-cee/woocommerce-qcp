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
 * @name WirecardCEE_QPay_Response_Toolkit_ResponseAbstract
 * @category WirecardCEE
 * @package WirecardCEE_QPay
 * @subpackage Response_Toolkit
 * @version 3.0.0
 * @abstract
 */
abstract class WirecardCEE_QPay_Response_Toolkit_ResponseAbstract extends WirecardCEE_QPay_Response_ResponseAbstract {
	/**
	 * Status
	 * @staticvar string
	 * @internal
	 */
	private static $STATUS = 'status';

	/**
	 * Payment system message
	 * @staticvar string
	 * @internal
	 */
	private static $PAY_SYS_MESSAGE = 'paySysMessage';

	/**
	 * Error code
	 * @staticvar string
	 * @internal
	 */
	private static $ERROR_CODE = 'errorCode';

	/**
	 * getter for the toolkit operation status
	 *
	 * @return string
	 */
	public function getStatus() {
		return $this->_getField(self::$STATUS);
	}
}