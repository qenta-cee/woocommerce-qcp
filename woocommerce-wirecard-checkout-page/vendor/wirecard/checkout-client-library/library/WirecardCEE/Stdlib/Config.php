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
 *
 * @name WirecardCEE_Stdlib_Config
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 */
class WirecardCEE_Stdlib_Config implements Countable, Iterator
{
    /**
     * Iteration index
     *
     * @var integer
     */
    protected $_index;

    /**
     * Number of elements in configuration data
     *
     * @var integer
     */
    protected $_count;

    /**
     * Contains array of configuration data
     *
     * @var array
     */
    protected $_data;

    /**
     * Used when unsetting values during iteration to ensure we do not skip
     * the next element
     *
     * @var boolean
     */
    protected $_skipNextIteration;

    /**
     * WirecardCEE_Stdlib_Config provides a property based interface to
     * an array.
     * The data are read-only unless $allowModifications
     * is set to true on construction.
     *
     * WirecardCEE_Stdlib_Config also implements Countable and Iterator to
     * facilitate easy access to the data.
     *
     * @param array $array
     *
     * @return void
     */
    public function __construct(array $array)
    {
        $this->_index = 0;
        $this->_data  = array();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $this->_data[$key] = new self($value);
            } else {
                $this->_data[$key] = $value;
            }
        }
        $this->_count = count($this->_data);
    }

    /**
     * Support isset() overloading on PHP 5.1
     *
     * @param string $name
     *
     * @return boolean
     */
    public function __isset($name)
    {
        return (bool) isset( $this->_data[$name] );
    }

    /**
     * Support unset() overloading on PHP 5.1
     *
     * @param string $name
     *
     * @return void
     */
    public function __unset($name)
    {
        unset( $this->_data[$name] );
        $this->_count             = count($this->_data);
        $this->_skipNextIteration = true;
    }

    /**
     * Magic function so that $obj->value will work.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * Retrieve a value and return $default if there is no element set.
     *
     * @param string $name
     * @param mixed $default
     *
     * @return mixed
     */
    public function get($name, $default = null)
    {
        $result = $default;
        if (array_key_exists($name, $this->_data)) {
            $result = $this->_data[$name];
        }

        return $result;
    }

    /**
     * Defined by Countable interface
     *
     * @return int
     */
    public function count()
    {
        return $this->_count;
    }

    /**
     * Defined by Iterator interface
     *
     * @return mixed
     */
    public function current()
    {
        $this->_skipNextIteration = false;

        return current($this->_data);
    }

    /**
     * Defined by Iterator interface
     *
     * @return mixed
     */
    public function key()
    {
        return key($this->_data);
    }

    /**
     * Defined by Iterator interface
     */
    public function next()
    {
        if ($this->_skipNextIteration) {
            $this->_skipNextIteration = false;

            return;
        }
        next($this->_data);
        $this->_index ++;
    }

    /**
     * Defined by Iterator interface
     */
    public function rewind()
    {
        $this->_skipNextIteration = false;
        reset($this->_data);
        $this->_index = 0;
    }

    /**
     * Defined by Iterator interface
     *
     * @return boolean
     */
    public function valid()
    {
        return $this->_index < $this->_count;
    }

    /**
     * Return an associative array of the stored data.
     *
     * @return array
     */
    public function toArray()
    {
        $array = array();
        $data  = $this->_data;
        foreach ($data as $key => $value) {
            if ($value instanceof WirecardCEE_Stdlib_Config) {
                $array[$key] = $value->toArray();
            } else {
                $array[$key] = $value;
            }
        }

        return $array;
    }
}