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
 * @name WirecardCEE_QPay_Response_Toolkit_Order_OrderIterator
 * @category WirecardCEE
 * @package WirecardCEE_QPay
 * @subpackage Response_Toolkit_Order
 * @abstract
 * @see Iterator
 */
abstract class WirecardCEE_QPay_Response_Toolkit_Order_OrderIterator implements Iterator
{

    /**
     * Current position
     *
     * @var int
     */
    protected $_position;

    /**
     * Objects to iterate through
     *
     * @var Array
     */
    protected $_objectArray;

    /**
     *
     * @param array $objectArray objects to iterate through
     */
    public function __construct(array $objectArray)
    {
        $this->_position    = 0;
        $this->_objectArray = $objectArray;
    }

    /**
     * resets the current position to 0(first entry)
     */
    public function rewind()
    {
        $this->_position = 0;
    }

    /**
     * the current Object
     *
     * @return Object
     */
    public function current()
    {
        return $this->_objectArray[$this->_position];
    }

    /**
     * the current position
     *
     * @return int
     */
    public function key()
    {
        return $this->_position;
    }

    /**
     * go to the next position
     */
    public function next()
    {
        ++ $this->_position;
    }

    /**
     * checks if position is valid
     *
     * @see Iterator::valid()
     */
    public function valid()
    {
        return (bool) isset( $this->_objectArray[$this->_position] );
    }
}