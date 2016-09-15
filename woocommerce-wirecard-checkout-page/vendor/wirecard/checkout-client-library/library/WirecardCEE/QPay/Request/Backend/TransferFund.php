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
 * @name WirecardCEE_QMore_Request_Backend_TransferFund_Existing
 * @category WirecardCEE
 * @package WirecardCEE_QMore
 */
class WirecardCEE_QPay_Request_Backend_TransferFund extends WirecardCEE_QPay_ToolkitClient
{

    /**
     * fundTransferType.
     *
     * @var string
     */
    const FUNDTRANSFERTYPE = 'fundTransferType';


    public function __construct($config = null)
    {
        parent::__construct($config);
        $this->_requestData[self::COMMAND] = self::$COMMAND_TRANSFER_FUND;
    }

    /**
     * seter for fundTransferType field
     *
     * @param $fundTransferType
     */
    public function setType($fundTransferType)
    {
        $this->_requestData[self::FUNDTRANSFERTYPE] = $fundTransferType;
    }

    /**
     * seter for orderNumber field
     *
     * @param $orderNumber
     *
     * @return $this
     */
    public function setOrderNumber($orderNumber)
    {
        $this->_setField(self::ORDER_NUMBER, $orderNumber);

        return $this;
    }

    /**
     * seter for orderReference field
     *
     * @param $orderReference
     *
     * @return $this
     */
    public function setOrderReference($orderReference)
    {
        $this->_setField(self::ORDER_REFERENCE, $orderReference);

        return $this;
    }

    /**
     * seter for creditNumber field
     *
     * @param $creditNumber
     *
     * @return $this
     */
    public function setCreditNumber($creditNumber)
    {
        $this->_setField(self::CREDIT_NUMBER, $creditNumber);

        return $this;
    }

    /**
     * seter for customerStatement field
     *
     * @param $customerStatement
     *
     * @return $this
     */
    public function setCustomerStatement($customerStatement)
    {
        $this->_setField(self::CUSTOMER_STATEMENT, $customerStatement);

        return $this;
    }

}