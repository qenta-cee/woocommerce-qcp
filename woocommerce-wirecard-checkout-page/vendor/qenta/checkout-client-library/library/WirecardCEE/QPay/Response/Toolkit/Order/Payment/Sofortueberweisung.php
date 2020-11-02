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
 * @name WirecardCEE_QPay_Response_Toolkit_Order_Payment_Sofortueberweisung
 * @category WirecardCEE
 * @package WirecardCEE_QPay
 * @subpackage Response_Toolkit_Order_Payment
 */
class WirecardCEE_QPay_Response_Toolkit_Order_Payment_Sofortueberweisung extends WirecardCEE_QPay_Response_Toolkit_Order_Payment
{
    /**
     * Sender - account owner
     *
     * @staticvar string
     * @internal
     */
    private static $SENDER_ACCOUNT_OWNER = 'senderAccountOwner';

    /**
     * Sender - account number
     *
     * @staticvar string
     * @internal
     */
    private static $SENDER_ACCOUNT_NUMBER = 'senderAccountNumber';

    /**
     * Sender - bank number
     *
     * @staticvar string
     * @internal
     */
    private static $SENDER_BANK_NUMBER = 'senderBankNumber';

    /**
     * Sender - bank name
     *
     * @staticvar string
     * @internal
     */
    private static $SENDER_BANK_NAME = 'senderBankName';

    /**
     * Sender - BIC
     *
     * @staticvar string
     * @internal
     */
    private static $SENDER_BIC = 'senderBIC';

    /**
     * Sender - IBAN
     *
     * @staticvar string
     * @internal
     */
    private static $SENDER_IBAN = 'senderIBAN';

    /**
     * Sender - Country
     *
     * @staticvar string
     * @internal
     */
    private static $SENDER_COUNTRY = 'senderCountry';

    /**
     * Security criteria
     *
     * @staticvar string
     * @internal
     */
    private static $SECURITY_CRITERIA = 'securityCriteria';

    /**
     * getter for sofortueberweisung.de sender account owner
     *
     * @return string
     */
    public function getSenderAccountOwner()
    {
        return $this->_getField(self::$SENDER_ACCOUNT_OWNER);
    }

    /**
     * getter for sofortueberweisung.de sender account number
     *
     * @return string
     */
    public function getSenderAccountNumber()
    {
        return $this->_getField(self::$SENDER_ACCOUNT_NUMBER);
    }

    /**
     * getter for sofortueberweisung.de sender bank number
     *
     * @return string
     */
    public function getSenderBankNumber()
    {
        return $this->_getField(self::$SENDER_BANK_NUMBER);
    }

    /**
     * getter for sofortueberweisung.de sender bank name
     *
     * @return string
     */
    public function getSenderBankName()
    {
        return $this->_getField(self::$SENDER_BANK_NAME);
    }

    /**
     * getter for sofortueberweisung.de sender BIC
     *
     * @return string
     */
    public function getSenderBic()
    {
        return $this->_getField(self::$SENDER_BIC);
    }

    /**
     * getter for sofortueberweisung.de sender IBAN
     *
     * @return string
     */
    public function getSenderIban()
    {
        return $this->_getField(self::$SENDER_IBAN);
    }

    /**
     * getter for sofortueberweisung.de sender country
     *
     * @return string
     */
    public function getSenderCountry()
    {
        return $this->_getField(self::$SENDER_COUNTRY);
    }

    /**
     * getter for sofortueberweisung.de Security criteria
     *
     * @return string
     */
    public function getSecurityCriteria()
    {
        return $this->_getField(self::$SECURITY_CRITERIA);
    }
}
