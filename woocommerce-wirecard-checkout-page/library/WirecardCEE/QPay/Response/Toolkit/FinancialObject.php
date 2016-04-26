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
 * @name WirecardCEE_QPay_Response_Toolkit_FinancialObject
 * @category WirecardCEE
 * @package WirecardCEE_QPay
 * @subpackage Response_Toolkit
 * @version 3.0.0
 * @abstract
 */
abstract class WirecardCEE_QPay_Response_Toolkit_FinancialObject {
	/**
	 * Internal data holder
	 * @var Array
	 */
	protected $_data = Array();

	/**
	 * Date time format
	 * @staticvar string
	 */
	protected static $DATETIME_FORMAT = 'm.d.Y H:i:s';

	/**
	 * getter for given field
	 *
	 * @param string $name
	 * @return mixed <false, string>
	 */
	protected function _getField($name) {
		return (array_key_exists($name, $this->_data)) ? $this->_data[$name] : false;
	}
}