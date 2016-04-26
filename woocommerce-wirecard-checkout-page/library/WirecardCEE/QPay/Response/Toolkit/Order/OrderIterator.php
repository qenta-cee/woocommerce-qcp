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
 * @name WirecardCEE_QPay_Response_Toolkit_Order_OrderIterator
 * @category WirecardCEE
 * @package WirecardCEE_QPay
 * @subpackage Response_Toolkit_Order
 * @version 3.0.0
 * @abstract
 * @see Iterator
 */
abstract class WirecardCEE_QPay_Response_Toolkit_Order_OrderIterator implements Iterator {

	/**
	 * Current position
	 * @var int
	 */
	protected $_position;

	/**
	 * Objects to iterate through
	 * @var Array
	 */
	protected $_objectArray;

	/**
	 *
	 * @param array $objectArray objects to iterate through
	 */
	public function __construct(array $objectArray) {
		$this->_position = 0;
		$this->_objectArray = $objectArray;
	}

	/**
	 * resets the current position to 0(first entry)
	 */
	public function rewind() {
		$this->_position = 0;
	}

	/**
	 * the current Object
	 * @return Object
	 */
	public function current() {
		return $this->_objectArray[$this->_position];
	}

	/**
	 * the current position
	 * @return int
	 */
	public function key() {
		return $this->_position;
	}

	/**
	 * go to the next position
	 */
	public function next() {
		++$this->_position;
	}

	/**
	 * checks if position is valid
	 * @see Iterator::valid()
	 */
	public function valid() {
		return (bool) isset($this->_objectArray[$this->_position]);
	}
}