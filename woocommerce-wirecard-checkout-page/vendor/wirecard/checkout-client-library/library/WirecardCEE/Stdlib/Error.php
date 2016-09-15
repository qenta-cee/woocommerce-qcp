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
 * @name WirecardCEE_Stdlib_Error
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 * @abstract
 */
abstract class WirecardCEE_Stdlib_Error
{

    /**
     * Error message
     *
     * @var string
     */
    protected $_message = null;

    /**
     * Consumer message
     *
     * @var string
     */
    protected $_consumerMessage = null;

    /**
     * Message getter
     *
     * @return string
     */
    public function getMessage()
    {
        return (string) $this->_message;
    }

    /**
     * Error Message setter
     *
     * @param string $message
     *
     * @return WirecardCEE_Stdlib_Error
     */
    public function setMessage($message)
    {
        $this->_message = (string) $message;

        return $this;
    }

    /**
     * Consumer message setter
     *
     * @param string $consumerMessage
     *
     * @return WirecardCEE_Stdlib_Error
     */
    public function setConsumerMessage($consumerMessage)
    {
        $this->_consumerMessage = (string) $consumerMessage;

        return $this;
    }

    /**
     * Consumer message getter
     *
     * @return string
     */
    public function getConsumerMessage()
    {
        return (string) $this->_consumerMessage;
    }
}