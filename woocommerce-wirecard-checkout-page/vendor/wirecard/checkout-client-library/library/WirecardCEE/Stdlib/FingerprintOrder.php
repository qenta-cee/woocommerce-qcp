<?php
/**
 * Shop System Plugins - Terms of Use
 *
 * The plugins offered are provided free of charge by Wirecard Central Eastern Europe GmbH
 * (abbreviated to Wirecard CEE) and are explicitly not part of the Wirecard CEE range of
 * products and services.
 *
 * They have been tested and approved for full functionality in the standard configuration
 * (status on delivery) of the corresponding shop system. They are under General Public
 * License Version 2 (GPLv2) and can be used, developed and passed on to third parties under
 * the same terms.
 *
 * However, Wirecard CEE does not provide any guarantee or accept any liability for any errors
 * occurring when used in an enhanced, customized shop system configuration.
 *
 * Operation in an enhanced, customized configuration is at your own risk and requires a
 * comprehensive test phase by the user of the plugin.
 *
 * Customers use the plugins at their own risk. Wirecard CEE does not guarantee their full
 * functionality neither does Wirecard CEE assume liability for any disadvantages related to
 * the use of the plugins. Additionally, Wirecard CEE does not guarantee the full functionality
 * for customized shop systems or installed plugins of other vendors of plugins within the same
 * shop system.
 *
 * Customers are responsible for testing the plugin's functionality before starting productive
 * operation.
 *
 * By installing the plugin into the shop system the customer agrees to these terms of use.
 * Please do not use the plugin if you do not agree to these terms of use!
 */

/**
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
 */

class WirecardCEE_Stdlib_FingerprintOrder implements ArrayAccess, IteratorAggregate, Countable
{
    /**
     *
     * Internal data holder
     *
     * @var Array
     */
    protected $_fingeprintOrder;

    /**
     * Constructor which accepts array(key=>pair) or string ("first, second, thrid, fourth" format)
     *
     * @param string|array $mItems
     *
     * @throws WirecardCEE_Stdlib_Exception_InvalidArgumentException
     */
    public function __construct($mItems = null)
    {
        $this->_fingeprintOrder = Array();

        if (!is_null($mItems) && !$this->setOrder($mItems)) {
            throw new WirecardCEE_Stdlib_Exception_InvalidArgumentException(sprintf("Unknown fingerprint format in %s on line %s",
                __METHOD__, __LINE__));
        }
    }

    /**
     * Sets the fingerprint order from string ("first, second, third, fourth" format)
     * or from an existing array (normal "key=>pair" format).
     *
     * @param string|array $mItems
     *
     * @return boolean
     */
    public function setOrder($mItems)
    {
        if (is_array($mItems) && count($mItems)) {
            $this->_fingeprintOrder = Array();
            foreach ($mItems as $sItem) {
                $this->_fingeprintOrder[] = trim($sItem);
            }

            return true;
        } elseif (is_string($mItems)) {
            return $this->setOrder(explode(",", $mItems));
        } else {
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
    public function __toArray()
    {
        return (array) $this->_fingeprintOrder;
    }

    /**
     * Returns the fingerprint order as string (csv)
     *
     * @return string
     */
    public function __toString()
    {
        return (string) implode(",", $this->_fingeprintOrder);
    }

    /**
     * @see ArrayAccess::offsetSet($mOffset, $mValue)
     *
     * @param int|string $mOffset
     * @param int|string $mValue
     */
    public function offsetSet($mOffset, $mValue)
    {
        if (!$mOffset) {
            $this->_fingeprintOrder[] = trim($mValue);
        } else {
            $this->_fingeprintOrder[$mOffset] = trim($mValue);
        }
    }

    /**
     * @see ArrayAccess::offsetGet($mOffset)
     *
     * @param int|string $mOffset
     *
     * @return Mixed <NULL, int|string>
     */
    public function offsetGet($mOffset)
    {
        return isset( $this->_fingeprintOrder[$mOffset] ) ? $this->_fingeprintOrder[$mOffset] : null;
    }

    /**
     * @see ArrayAccess::offsetExists($mOffset)
     *
     * @param int|string $mOffset
     *
     * @return boolean
     */
    public function offsetExists($mOffset)
    {
        return (bool) isset( $this->_fingeprintOrder[$mOffset] );
    }

    /**
     * @see ArrayAccess::offsetUnset($mOffset)
     *
     * @param int|string $mOffset
     */
    public function offsetUnset($mOffset)
    {
        unset( $this->_fingeprintOrder[$mOffset] );
    }

    /**
     * IteratorAggregate abstract function implementation
     * Due to this we can iterate thru object just using the foreach
     *
     * @see IteratorAggregate::getIterator()
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->_fingeprintOrder);
    }

    /**
     * Impltemented count function from Countable interface
     *
     * @see Countable::count();
     * @return number
     */
    public function count()
    {
        return (int) count($this->_fingeprintOrder);
    }
}