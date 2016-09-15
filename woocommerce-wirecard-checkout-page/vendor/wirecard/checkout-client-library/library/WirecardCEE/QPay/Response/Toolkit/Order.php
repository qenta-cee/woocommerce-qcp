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
 * @name WirecardCEE_QPay_Response_Toolkit_Order
 * @category WirecardCEE
 * @package WirecardCEE_QPay
 * @subpackage Response_Toolkit
 */
class WirecardCEE_QPay_Response_Toolkit_Order extends WirecardCEE_QPay_Response_Toolkit_FinancialObject
{
    /**
     * CreditIterator object holder
     *
     * @var WirecardCEE_QPay_Response_Toolkit_Order_CreditIterator
     * @internal
     */
    private $_credits;

    /**
     * PaymentIterator object holder
     *
     * @var WirecardCEE_QPay_Response_Toolkit_Order_PaymentIterator
     * @internal
     */
    private $_payments;

    /**
     * Merchant number
     *
     * @staticvar string
     * @internal
     */
    private static $MERCHANT_NUMBER = 'merchantNumber';

    /**
     * Order number
     *
     * @staticvar string
     * @internal
     */
    private static $ORDER_NUMBER = 'orderNumber';

    /**
     * Payment type
     *
     * @staticvar string
     * @internal
     */
    private static $PAYMENT_TYPE = 'paymentType';

    /**
     * Amount
     *
     * @staticvar string
     * @internal
     */
    private static $AMOUNT = 'amount';

    /**
     * Brand
     *
     * @staticvar string
     * @internal
     */
    private static $BRAND = 'brand';

    /**
     * Currency
     *
     * @staticvar string
     * @internal
     */
    private static $CURRENCY = 'currency';

    /**
     * Order description
     *
     * @staticvar string
     * @internal
     */
    private static $ORDER_DESCRIPTION = 'orderDescription';

    /**
     * Acquirer
     *
     * @staticvar string
     * @internal
     */
    private static $ACQUIRER = 'acquirer';

    /**
     * Contract number
     *
     * @staticvar string
     * @internal
     */
    private static $CONTRACT_NUMBER = 'contractNumber';

    /**
     * Operations allowes
     *
     * @staticvar string
     * @internal
     */
    private static $OPERATIONS_ALLOWED = 'operationsAllowed';

    /**
     * Order reference
     *
     * @staticvar string
     * @internal
     */
    private static $ORDER_REFERENCE = 'orderReference';

    /**
     * Customer statement
     *
     * @staticvar string
     * @internal
     */
    private static $CUSTOMER_STATEMENT = 'customerStatement';

    /**
     * Order text
     *
     * @staticvar string
     * @internal
     */
    private static $ORDER_TEXT = 'orderText';

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
     * Source number
     *
     * @staticvar string
     * @internal
     */
    private static $SOURCE_ORDER_NUMBER = 'sourceOrderNumber';

    /**
     * Merchant number
     *
     * @staticvar string
     * @internal
     */
    private static $PAYMENTTYPE_PAYPAL = 'PPL';

    /**
     * Merchant number
     *
     * @staticvar string
     * @internal
     */
    private static $PAYMENTTYPE_SOFORTUEBERWEISUNG = 'SUE';

    /**
     * Merchant number
     *
     * @staticvar string
     * @internal
     */
    private static $PAYMENTTYPE_IDEAL = 'IDL';

    /**
     * creates an instance of the {@link
     * WirecardCEE_QPay_Response_Toolkit_Order} object
     *
     * @param string[] $orderData
     */
    public function __construct($orderData)
    {
        $this->_setPayments($orderData['paymentData']);
        $this->_setCredits($orderData['creditData']);

        unset( $orderData['paymentData'] );
        unset( $orderData['creditData'] );

        $this->_data = $orderData;
    }

    /**
     * setter for payment object iterator
     *
     * @access private
     *
     * @param string[] $payments
     */
    private function _setPayments($paymentEntries)
    {
        $payments = Array();
        foreach ($paymentEntries as $paymentEntry) {
            switch ($paymentEntry['paymentType']) {
                case self::$PAYMENTTYPE_PAYPAL:
                    $payments[] = new WirecardCEE_QPay_Response_Toolkit_Order_Payment_Paypal($paymentEntry);
                    break;
                case self::$PAYMENTTYPE_SOFORTUEBERWEISUNG:
                    $payments[] = new WirecardCEE_QPay_Response_Toolkit_Order_Payment_Sofortueberweisung($paymentEntry);
                    break;
                case self::$PAYMENTTYPE_IDEAL:
                    $payments[] = new WirecardCEE_QPay_Response_Toolkit_Order_Payment_Ideal($paymentEntry);
                    break;
                default:
                    $payments[] = new WirecardCEE_QPay_Response_Toolkit_Order_Payment($paymentEntry);
                    break;
            }
        }
        $this->_payments = new WirecardCEE_QPay_Response_Toolkit_Order_PaymentIterator($payments);
    }

    /**
     * setter for credit object iterator
     *
     * @access private
     *
     * @param string[] $credits
     */
    private function _setCredits($creditEntries)
    {
        $credits = Array();
        foreach ($creditEntries as $creditEntry) {
            $credits[] = new WirecardCEE_QPay_Response_Toolkit_Order_Credit($creditEntry);
        }
        $this->_credits = new WirecardCEE_QPay_Response_Toolkit_Order_CreditIterator($credits);
    }

    /**
     * getter for order merchant number
     *
     * @return string
     */
    public function getMerchantNumber()
    {
        return $this->_getField(self::$MERCHANT_NUMBER);
    }

    /**
     * getter for order number
     *
     * @return string
     */
    public function getOrderNumber()
    {
        return $this->_getField(self::$ORDER_NUMBER);
    }

    /**
     * getter for used payment type
     *
     * @return string
     */
    public function getPaymentType()
    {
        return $this->_getField(self::$PAYMENT_TYPE);
    }

    /**
     * getter for orders amount
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->_getField(self::$AMOUNT);
    }

    /**
     * getter for orders brand
     *
     * @return string
     */
    public function getBrand()
    {
        return $this->_getField(self::$BRAND);
    }

    /**
     * getter for orders currency
     *
     * @return type
     */
    public function getCurrency()
    {
        return $this->_getField(self::$CURRENCY);
    }

    /**
     * getter for the order description
     *
     * @return string
     */
    public function getOrderDescription()
    {
        return $this->_getField(self::$ORDER_DESCRIPTION);
    }

    /**
     * getter for the acquirer name
     *
     * @return string
     */
    public function getAcquirer()
    {
        return $this->_getField(self::$ACQUIRER);
    }

    /**
     * getter for the contract number
     *
     * @return string
     */
    public function getContractNumber()
    {
        return $this->_getField(self::$CONTRACT_NUMBER);
    }

    /**
     * getter for allowed follow-up operations
     *
     * @return string[]
     */
    public function getOperationsAllowed()
    {
        if ($this->_getField(self::$OPERATIONS_ALLOWED) == '') {
            return Array();
        } else {
            return explode(',', $this->_getField(self::$OPERATIONS_ALLOWED));
        }
    }

    /**
     * getter for order reference
     *
     * @return string
     */
    public function getOrderReference()
    {
        return $this->_getField(self::$ORDER_REFERENCE);
    }

    /**
     * getter for customer statement text
     *
     * @return string
     */
    public function getCustomerStatement()
    {
        return $this->_getField(self::$CUSTOMER_STATEMENT);
    }

    /**
     * getter for the order text
     *
     * @return string
     */
    public function getOrderText()
    {
        return $this->_getField(self::$ORDER_TEXT);
    }

    /**
     * getter for the time this order has been created
     *
     * @return DateTime
     */
    public function getTimeCreated()
    {
        return DateTime::createFromFormat(self::$DATETIME_FORMAT, $this->_getField(self::$TIME_CREATED));
    }

    /**
     * getter for the last time this order has been modified
     *
     * @return DateTime
     */
    public function getTimeModified()
    {
        return DateTime::createFromFormat(self::$DATETIME_FORMAT, $this->_getField(self::$TIME_MODIFIED));
    }

    /**
     * getter for the current order state
     *
     * @return string
     */
    public function getState()
    {
        return $this->_getField(self::$STATE);
    }

    /**
     * getter for the source order number
     *
     * @return string
     */
    public function getSourceOrderNumber()
    {
        return $this->_getField(self::$SOURCE_ORDER_NUMBER);
    }

    /**
     * getter for corresponding payment objects
     *
     * @return WirecardCEE_QPay_Response_Toolkit_Order_PaymentIterator
     */
    public function getPayments()
    {
        return $this->_payments;
    }

    /**
     * getter for corresponding credit objects
     *
     * @return WirecardCEE_QPay_Response_Toolkit_Order_CreditIterator
     */
    public function getCredits()
    {
        return $this->_credits;
    }
}