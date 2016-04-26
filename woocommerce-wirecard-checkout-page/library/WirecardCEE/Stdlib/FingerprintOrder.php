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

/*
 * Due to the ArrayAccess, IteratorAggregate and Countable interfaces implementation we are able to use this object
 * also as:
 *
 * 1. array
 *
 * ie.
 *
 * $obj = new WirecardCEE_Stdlib_FingerprintOrder();
 * $obj->add('index') is same as $obj[] = 'index';
 *
 * 2. we can iterate it via foreach ie.
 * foreach($obj as $key => $value) {}
 *
 * 3. and we can use count() on the whole object ie count($obj)
 * which will return the number of items in fingeprintOrder array
 *
 * @name WirecardCEE_Stdlib_FingerprintOrder
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 * @version 3.0.0
 */
class WirecardCEE_Stdlib_FingerprintOrder implements ArrayAccess, IteratorAggregate, Countable {
    /**
     *
     * Internal data holder
     * @var Array
     */
    protected $_fingeprintOrder;

    /**
     * Constructor which accepts array(key=>pair) or string ("first, second, thrid, fourth" format)
     *
     * @param string|array $mItems
     * @throws WirecardCEE_Stdlib_Exception_InvalidArgumentException
     */
    public function __construct($mItems = null) {
        $this->_fingeprintOrder = Array();

        if(!is_null($mItems) && !$this->setOrder($mItems)) {
            throw new WirecardCEE_Stdlib_Exception_InvalidArgumentException(sprintf("Unknown fingerprint format in %s on line %s", __METHOD__, __LINE__));
        }
    }

    /**
     * Sets the fingerprint order from string ("first, second, third, fourth" format)
     * or from an existing array (normal "key=>pair" format).
     *
     * @param string|array $mItems
     * @return boolean
     */
    public function setOrder($mItems) {
        if(is_array($mItems) && count($mItems)) {
            $this->_fingeprintOrder = Array();
            foreach($mItems as $sItem) {
                $this->_fingeprintOrder[] = trim($sItem);
            }
            return true;
        }
        elseif(is_string($mItems)) {
            return $this->setOrder(explode(",", $mItems));
        }
        else {
            return false;
        }
    }

    /**
     * Internal __toArray implementation
     * At the time of writing this (07.03.2013) PHP doesn't support
     * array casting of objects by calling __toArray function (like string casting nad calling __toString())
     *
     * @return array
     */
    public function __toArray() {
        return (array) $this->_fingeprintOrder;
    }

    /**
     * Returns the fingerprint order as string (csv)
     *
     * @return string
     */
    public function __toString() {
        return (string) implode(",", $this->_fingeprintOrder);
    }

    /**
     * @see ArrayAccess::offsetSet($mOffset, $mValue)
     *
     * @param int|string $mOffset
     * @param int|string $mValue
     */
    public function offsetSet($mOffset, $mValue) {
        if(!$mOffset) {
            $this->_fingeprintOrder[] = trim($mValue);
        }
        else {
            $this->_fingeprintOrder[$mOffset] = trim($mValue);
        }
    }

    /**
     * @see ArrayAccess::offsetGet($mOffset)
     *
     * @param int|string $mOffset
     * @return Mixed <NULL, int|string>
     */
    public function offsetGet($mOffset) {
        return isset($this->_fingeprintOrder[$mOffset]) ? $this->_fingeprintOrder[$mOffset] : null;
    }

    /**
     * @see ArrayAccess::offsetExists($mOffset)
     *
     * @param int|string $mOffset
     * @return boolean
     */
    public function offsetExists($mOffset) {
        return (bool) isset($this->_fingeprintOrder[$mOffset]);
    }

    /**
     * @see ArrayAccess::offsetUnset($mOffset)
     *
     * @param int|string $mOffset
     */
    public function offsetUnset($mOffset) {
        unset($this->_fingeprintOrder[$mOffset]);
    }

    /**
     * IteratorAggregate abstract function implementation
     * Due to this we can iterate thru object just using the foreach
     *
     * @see IteratorAggregate::getIterator()
     * @return ArrayIterator
     */
    public function getIterator() {
        return new ArrayIterator($this->_fingeprintOrder);
    }

    /**
     * Impltemented count function from Countable interface
     *
     * @see Countable::count();
     * @return number
     */
    public function count() {
        return (int) count($this->_fingeprintOrder);
    }
}