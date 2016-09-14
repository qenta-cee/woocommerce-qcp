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
 * @name WirecardCEE_Stdlib_Return_Success_PayPal
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 * @subpackage Return_Success
 * @abstract
 */
abstract class WirecardCEE_Stdlib_Return_Success_PayPal extends WirecardCEE_Stdlib_Return_Success
{

    /**
     * getter for the return parameter paypalPayerID
     *
     * @return string
     */
    public function getPayerId()
    {
        return $this->paypalPayerID;
    }

    /**
     * getter for the return parameter paypalPayerEmail
     *
     * @return string
     */
    public function getPayerEmail()
    {
        return $this->paypalPayerEmail;
    }

    /**
     * getter for the return parameter paypalPayerLastName
     *
     * @return string
     */
    public function getPayerLastName()
    {
        return $this->paypalPayerLastName;
    }

    /**
     * getter for the return parameter paypalPayerFirstName
     *
     * @return string
     */
    public function getPayerFirstName()
    {
        return $this->paypalPayerFirstName;
    }

    /**
     * getter for the return parameter paypalPayerAddressName
     *
     * @return string
     */
    public function getPayerAddressName()
    {
        return $this->paypalPayerAddressName;
    }

    /**
     * getter for the return parameter paypalPayerAddressCountry
     *
     * @return string
     */
    public function getPayerAddressCountry()
    {
        return $this->paypalPayerAddressCountry;
    }

    /**
     * getter for the return parameter paypalPayerAddressCity
     *
     * @return string
     */
    public function getPayerAddressCity()
    {
        return $this->paypalPayerAddressCity;
    }

    /**
     * getter for the return parameter paypalPayerAddressState
     *
     * @return string
     */
    public function getPayerAddressState()
    {
        return $this->paypalPayerAddressState;
    }

    /**
     * getter for the return parameter paypalPayerAddressStreet1
     *
     * @return string
     */
    public function getPayerAddressStreet1()
    {
        return $this->paypalPayerAddressStreet1;
    }

    /**
     * getter for the return parameter paypalPayerAddressStreet2
     *
     * @return string
     */
    public function getPayerAddressStreet2()
    {
        return $this->paypalPayerAddressStreet2;
    }

    /**
     * getter for the return parameter paypalPayerAddressZIP
     *
     * @return string
     */
    public function getPayerAddressZip()
    {
        return $this->paypalPayerAddressZIP;
    }
}