<?php
/**
 * Shop System Plugins - Terms of Use
 *
 * The plugins offered are provided free of charge by Qenta Payment CEE GmbH
 * (abbreviated to Qenta CEE) and are explicitly not part of the Qenta CEE range of
 * products and services.
 *
 * They have been tested and approved for full functionality in the standard configuration
 * (status on delivery) of the corresponding shop system. They are under General Public
 * License Version 2 (GPLv2) and can be used, developed and passed on to third parties under
 * the same terms.
 *
 * However, Qenta CEE does not provide any guarantee or accept any liability for any errors
 * occurring when used in an enhanced, customized shop system configuration.
 *
 * Operation in an enhanced, customized configuration is at your own risk and requires a
 * comprehensive test phase by the user of the plugin.
 *
 * Customers use the plugins at their own risk. Qenta CEE does not guarantee their full
 * functionality neither does Qenta CEE assume liability for any disadvantages related to
 * the use of the plugins. Additionally, Qenta CEE does not guarantee the full functionality
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
 * @name QentaCEE_QMore_Request_Backend_TransferFund_SkrillWallet
 * @category QentaCEE
 * @package  QentaCEE_QMore
 */
class QentaCEE_QPay_Request_Backend_TransferFund_SkrillWallet extends QentaCEE_QPay_Request_Backend_TransferFund
{

    public function send($amount, $currency, $orderDescription, $customerStatement, $consumerEmail)
    {
        $this->_setField(self::AMOUNT, $amount);
        $this->_setField(self::CURRENCY, $currency);
        $this->_setField(self::ORDER_DESCRIPTION, $orderDescription);
        $this->_setField(self::CUSTOMER_STATEMENT, $customerStatement);
        $this->_setField(self::CONSUMEREMAIL, $consumerEmail);

        $orderArray = Array(
            self::CUSTOMER_ID,
            self::SHOP_ID,
            self::TOOLKIT_PASSWORD,
            self::SECRET,
            self::COMMAND,
            self::LANGUAGE
        );
        if ($this->_getField(self::ORDER_NUMBER) !== null) {
            $orderArray[] = self::ORDER_NUMBER;
        }

        if ($this->_getField(self::CREDIT_NUMBER) !== null) {
            $orderArray[] = self::CREDIT_NUMBER;
        }

        $orderArray[] = self::ORDER_DESCRIPTION;
        $orderArray[] = self::AMOUNT;
        $orderArray[] = self::CURRENCY;

        if ($this->_getField(self::ORDER_REFERENCE) !== null) {
            $orderArray[] = self::ORDER_REFERENCE;
        }

        if ($this->_getField(self::CUSTOMER_STATEMENT) !== null) {
            $orderArray[] = self::CUSTOMER_STATEMENT;
        }

        $orderArray[] = self::FUNDTRANSFERTYPE;
        $orderArray[] = self::CONSUMEREMAIL;

        $this->_fingerprintOrder->setOrder($orderArray);

        return new QentaCEE_QPay_Response_Toolkit_TransferFund($this->_send());
    }
}