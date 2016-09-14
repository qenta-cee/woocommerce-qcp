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
 * @name WirecardCEE_Stdlib_Return_Success_SepaDD
 * @category WirecardCEE
 * @package WirecardCEE_QMore
 * @subpackage Return_Success
 */
abstract class WirecardCEE_Stdlib_Return_Success_SepaDD extends WirecardCEE_Stdlib_Return_Success
{

    /**
     * getter for the return parameter creditorId
     *
     * @return string
     */
    public function getCreditorId()
    {
        return $this->creditorId;
    }

    /**
     * getter for the return parameter dueDate
     *
     * @return string
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * getter for the return parameter mandateId
     *
     * @return string
     */
    public function getMandateId()
    {
        return $this->mandateId;
    }

    /**
     * getter for the return parameter mandateSignatureDate
     *
     * @return string
     */
    public function getMandateSignatureDate()
    {
        return $this->mandateSignatureDate;
    }

}