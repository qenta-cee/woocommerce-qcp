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
 * @name WirecardCEE_QMore_Response_Backend_Order_Payment_Paypal
 * @category WirecardCEE
 * @package WirecardCEE_QMore
 * @subpackage Response_Backend_Order_Payment
 */
class WirecardCEE_QMore_Response_Backend_Order_Payment_Paypal extends WirecardCEE_QMore_Response_Backend_Order_Payment
{
    /**
     * Paypal payer ID
     *
     * @staticvar string
     * @internal
     */
    private static $PAYER_ID = 'paypalPayerID';

    /**
     * Paypal payer email
     *
     * @staticvar string
     * @internal
     */
    private static $PAYER_EMAIL = 'paypalPayerEmail';

    /**
     * Paypal payer first name
     *
     * @staticvar string
     * @internal
     */
    private static $PAYER_FIRST_NAME = 'paypalPayerFirstName';

    /**
     * Paypal payer last name
     *
     * @staticvar string
     * @internal
     */
    private static $PAYER_LAST_NAME = 'paypalPayerLastName';

    /**
     * Paypal payer address country
     *
     * @staticvar string
     * @internal
     */
    private static $PAYER_ADDRESS_COUNTRY = 'paypalPayerAddressCountry';

    /**
     * Paypal payer address city
     *
     * @staticvar string
     * @internal
     */
    private static $PAYER_ADDRESS_CITY = 'paypalPayerAddressCity';

    /**
     * Paypal payer address - state
     *
     * @staticvar string
     * @internal
     */
    private static $PAYER_ADDRESS_STATE = 'paypalPayerAddressState';

    /**
     * Paypal payer address name
     *
     * @staticvar string
     * @internal
     */
    private static $PAYER_ADDRESS_NAME = 'paypalPayerAddressName';

    /**
     * Paypal payer address street 1
     *
     * @staticvar string
     * @internal
     */
    private static $PAYER_ADDRESS_STREET_1 = 'paypalPayerAddressStreet1';

    /**
     * Paypal payer address street 2
     *
     * @staticvar string
     * @internal
     */
    private static $PAYER_ADDRESS_STREET_2 = 'paypalPayerAddressStreet2';

    /**
     * Paypal payer address street zip
     *
     * @staticvar string
     * @internal
     */
    private static $PAYER_ADDRESS_ZIP = 'paypalPayerAddressZIP';

    /**
     * Paypal payer address status
     *
     * @staticvar string
     * @internal
     */
    private static $PAYER_ADDRESS_STATUS = 'paypalPayerAddressStatus';

    /**
     * Paypal Protection Eligibility
     *
     * @staticvar string
     * @internal
     */
    private static $PROTECTION_ELIGIBILITY = 'paypalProtectionEligibility';

    /**
     * getter for PayPal payerID
     *
     * @return string
     */
    public function getPayerId()
    {
        return $this->_getField(self::$PAYER_ID);
    }

    /**
     * getter for PayPal payer email
     *
     * @return string
     */
    public function getPayerEmail()
    {
        return $this->_getField(self::$PAYER_EMAIL);
    }

    /**
     * getter for PayPal payer firstname
     *
     * @return string
     */
    public function getPayerFirstName()
    {
        return $this->_getField(self::$PAYER_FIRST_NAME);
    }

    /**
     * getter for PayPal payer lastname
     *
     * @return string
     */
    public function getPayerLastName()
    {
        return $this->_getField(self::$PAYER_LAST_NAME);
    }

    /**
     * getter for PayPal payer country address field
     *
     * @return string
     */
    public function getPayerAddressCountry()
    {
        return $this->_getField(self::$PAYER_ADDRESS_COUNTRY);
    }

    /**
     * getter for PayPal payer city address field
     *
     * @return string
     */
    public function getPayerAddressCity()
    {
        return $this->_getField(self::$PAYER_ADDRESS_CITY);
    }

    /**
     * getter for PayPal payer state address field
     *
     * @return string
     */
    public function getPayerAddressState()
    {
        return $this->_getField(self::$PAYER_ADDRESS_STATE);
    }

    /**
     * getter for PayPal payer name address field
     *
     * @return string
     */
    public function getPayerAddressName()
    {
        return $this->_getField(self::$PAYER_ADDRESS_NAME);
    }

    /**
     * getter for PayPal payer street 1 address field
     *
     * @return string
     */
    public function getPayerAddressStreet1()
    {
        return $this->_getField(self::$PAYER_ADDRESS_STREET_1);
    }

    /**
     * getter for PayPal payer street 2 address field
     *
     * @return string
     */
    public function getPayerAddressStreet2()
    {
        return $this->_getField(self::$PAYER_ADDRESS_STREET_2);
    }

    /**
     * getter for PayPal payer zipcode address field
     *
     * @return string
     */
    public function getPayerAddressZip()
    {
        return $this->_getField(self::$PAYER_ADDRESS_ZIP);
    }

    /**
     * getter for PayPal payer address status
     *
     * @return string
     */
    public function getPayerAddressStatus()
    {
        return $this->_getField(self::$PAYER_ADDRESS_STATUS);
    }

    /**
     * getter for PayPal protection eligibility
     *
     * @return string
     */
    public function getProtectionEligibility()
    {
        return $this->_getField(self::$PROTECTION_ELIGIBILITY);
    }
}