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
 * @name WirecardCEE_QPay_Response_Toolkit_Order_Payment
 * @category WirecardCEE
 * @package WirecardCEE_QPay
 * @subpackage Response_Toolkit_Order
 */
class WirecardCEE_QPay_Response_Toolkit_Order_Payment extends WirecardCEE_QPay_Response_Toolkit_FinancialObject
{
    /**
     * Merchant number
     *
     * @staticvar string
     * @internal
     */
    private static $MERCHANT_NUMBER = 'merchantNumber';

    /**
     * Payment number
     *
     * @staticvar string
     * @internal
     */
    private static $PAYMENT_NUMBER = 'paymentNumber';

    /**
     * Order number
     *
     * @staticvar string
     * @internal
     */
    private static $ORDER_NUMBER = 'orderNumber';

    /**
     * Approve amount
     *
     * @staticvar string
     * @internal
     */
    private static $APPROVE_AMOUNT = 'approveAmount';

    /**
     * Deposit amount
     *
     * @staticvar string
     * @internal
     */
    private static $DEPOSIT_AMOUNT = 'depositAmount';

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
     * Payment type
     *
     * @staticvar string
     * @internal
     */
    private static $PAYMENT_TYPE = 'paymentType';

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
     * AVS result code
     *
     * @staticvar string
     * @internal
     */
    private static $AVS_RESULT_CODE = 'avsResultCode';

    /**
     * AVS result message
     *
     * @staticvar string
     * @internal
     */
    private static $AVS_RESULT_MESSAGE = 'avsResultMessage';

    /**
     * creates an instance of an {@link
     * WirecardCEE_QPay_Response_Toolkit_Order_Payment} object
     *
     * @param string[] $paymentData
     */
    public function __construct($paymentData)
    {
        $this->_data = $paymentData;
    }

    /**
     * getter for payments merchant number
     *
     * @return string
     */
    public function getMerchantNumber()
    {
        return $this->_getField(self::$MERCHANT_NUMBER);
    }

    /**
     * getter for the payment number
     *
     * @return string
     */
    public function getPaymentNumber()
    {
        return $this->_getField(self::$PAYMENT_NUMBER);
    }

    /**
     * getter for the corrensponding order number
     *
     * @return string
     */
    public function getOrderNumber()
    {
        return $this->_getField(self::$ORDER_NUMBER);
    }

    /**
     * getter for the approved amount
     *
     * @return string
     */
    public function getApproveAmount()
    {
        return $this->_getField(self::$APPROVE_AMOUNT);
    }

    /**
     * getter for the deposited amount
     *
     * @return string
     */
    public function getDepositAmount()
    {
        return $this->_getField(self::$DEPOSIT_AMOUNT);
    }

    /**
     * getter for the payment currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->_getField(self::$CURRENCY);
    }

    /**
     * getter for the creation time of this payment
     *
     * @return DateTime
     */
    public function getTimeCreated()
    {
        return DateTime::createFromFormat(self::$DATETIME_FORMAT, $this->_getField(self::$TIME_CREATED));
    }

    /**
     * getter for the last time this payment has been updated
     *
     * @return DateTime
     */
    public function getTimeModified()
    {
        return DateTime::createFromFormat(self::$DATETIME_FORMAT, $this->_getField(self::$TIME_MODIFIED));
    }

    /**
     * getter for the current payment state
     *
     * @return string
     */
    public function getState()
    {
        return $this->_getField(self::$STATE);
    }

    /**
     * getter for the paymenttype
     *
     * @return string
     */
    public function getPaymentType()
    {
        return $this->_getField(self::$PAYMENT_TYPE);
    }

    /**
     * getter for the allowed follow-up operations
     *
     * @return string[]
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
    public function getGatewayReferencenumber()
    {
        return $this->_getField(self::$GATEWAY_REFERENCE_NUMBER);
    }

    /**
     * getter for the AVS result-code
     *
     * @return string
     */
    public function getAvsResultCode()
    {
        return $this->_getField(self::$AVS_RESULT_CODE);
    }

    /**
     * getter for the AVS result-message
     *
     * @return string
     */
    public function getAvsResultMessage()
    {
        return $this->_getField(self::$AVS_RESULT_MESSAGE);
    }
}