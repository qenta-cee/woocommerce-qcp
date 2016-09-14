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
 * @name WirecardCEE_QPay_Response_Toolkit_Order_Credit
 * @category WirecardCEE
 * @package WirecardCEE_QPay
 * @subpackage Response_Toolkit_Order
 * @abstract
 */
class WirecardCEE_QPay_Response_Toolkit_Order_Credit extends WirecardCEE_QPay_Response_Toolkit_FinancialObject
{
    /**
     * Merchant number
     *
     * @staticvar string
     * @internal
     */
    private static $MERCHANT_NUMBER = 'merchantNumber';

    /**
     * Credit number
     *
     * @staticvar string
     * @internal
     */
    private static $CREDIT_NUMBER = 'creditNumber';

    /**
     * Order number
     *
     * @staticvar string
     * @internal
     */
    private static $ORDER_NUMBER = 'orderNumber';

    /**
     * Batch number
     *
     * @staticvar string
     * @internal
     */
    private static $BATCH_NUMBER = 'batchNumber';

    /**
     * Amount
     *
     * @staticvar string
     * @internal
     */
    private static $AMOUNT = 'amount';

    /**
     * Currency
     *
     * @staticvar string
     * @internal
     */
    private static $CURRENCY = 'currency';

    /**
     * Time created
     *
     * @staticvar string
     * @internal
     */
    private static $TIME_CREATED = 'timeCreated';

    /**
     * Time modified
     *
     * @staticvar string
     * @internal
     */
    private static $TIME_MODIFIED = 'timeModified';

    /**
     * State
     *
     * @staticvar string
     * @internal
     */
    private static $STATE = 'state';

    /**
     * Operations allowed
     *
     * @staticvar string
     * @internal
     */
    private static $OPERATIONS_ALLOWED = 'operationsAllowed';

    /**
     * Gateway reference number
     *
     * @staticvar string
     * @internal
     */
    private static $GATEWAY_REFERENCE_NUMBER = 'gatewayReferenceNumber';

    /**
     * creates an instance of an {@link
     * WirecardCEE_QPay_Response_Toolkit_Order_Credit} object
     *
     * @param string[] $creditData
     */
    public function __construct($creditData)
    {
        $this->_data = $creditData;
    }

    /**
     * getter for credits merchant number
     *
     * @return string
     */
    public function getMerchantNumber()
    {
        return (string) $this->_getField(self::$MERCHANT_NUMBER);
    }

    /**
     * getter for credit number
     *
     * @return string
     */
    public function getCreditNumber()
    {
        return (string) $this->_getField(self::$CREDIT_NUMBER);
    }

    /**
     * getter for the corresponding order number
     *
     * @return string
     */
    public function getOrderNumber()
    {
        return $this->_getField(self::$ORDER_NUMBER);
    }

    /**
     * getter for the corresponding batch number
     *
     * @return string
     */
    public function getBatchNumber()
    {
        return $this->_getField(self::$BATCH_NUMBER);
    }

    /**
     * getter for the credit amount
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->_getField(self::$AMOUNT);
    }

    /**
     * getter for the credit currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return (string) $this->_getField(self::$CURRENCY);
    }

    /**
     * getter for the creation time
     *
     * @return DateTime
     */
    public function getTimeCreated()
    {
        return DateTime::createFromFormat(self::$DATETIME_FORMAT, $this->_getField(self::$TIME_CREATED));
    }

    /**
     * getter for the last time this credit has been updated
     *
     * @return DateTime
     */
    public function getTimeModified()
    {
        return DateTime::createFromFormat(self::$DATETIME_FORMAT, $this->_getField(self::$TIME_MODIFIED));
    }

    /**
     * getter for the currenc credit state
     *
     * @return string
     */
    public function getState()
    {
        return $this->_getField(self::$STATE);
    }

    /**
     * getter for the allowed follow-up operations
     *
     * @return array
     */
    public function getOperationsAllowed()
    {
        return explode(',', $this->_getField(self::$OPERATIONS_ALLOWED));
    }

    /**
     * getter for the gateway reference number
     *
     * @return string
     */
    public function getGatewayReferenceNumber()
    {
        return $this->_getField(self::$GATEWAY_REFERENCE_NUMBER);
    }
}