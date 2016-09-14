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
 * Container class for consumerData
 *
 * @name WirecardCEE_Stdlib_ConsumerData
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 * @subpackage ConsumerData
 */
class WirecardCEE_Stdlib_ConsumerData_Address
{
    /**
     * Constant: Shipping
     *
     * @var string
     */
    const TYPE_SHIPPING = 'Shipping';

    /**
     * Constant: Billing
     *
     * @var string
     */
    const TYPE_BILLING = 'Billing';

    /**
     * Consumer
     *
     * @staticvar string
     * @internal
     */
    protected static $PREFIX = 'consumer';

    /**
     * Firstname
     *
     * @staticvar string
     * @internal
     */
    protected static $FIRSTNAME = 'Firstname';

    /**
     * Lastname
     *
     * @staticvar string
     * @internal
     */
    protected static $LASTNAME = 'Lastname';

    /**
     * Address1
     *
     * @staticvar string
     * @internal
     */
    protected static $ADDRESS1 = 'Address1';

    /**
     * Address2
     *
     * @staticvar string
     * @internal
     */
    protected static $ADDRESS2 = 'Address2';

    /**
     * City
     *
     * @staticvar string
     * @internal
     */
    protected static $CITY = 'City';

    /**
     * Country
     *
     * @staticvar string
     * @internal
     */
    protected static $COUNTRY = 'Country';

    /**
     * State
     *
     * @staticvar string
     * @internal
     */
    protected static $STATE = 'State';

    /**
     * ZipCode
     *
     * @staticvar string
     * @internal
     */
    protected static $ZIP_CODE = 'ZipCode';

    /**
     * Phone
     *
     * @staticvar string
     * @internal
     */
    protected static $PHONE = 'Phone';

    /**
     * Fax
     *
     * @staticvar string
     * @internal
     */
    protected static $FAX = 'Fax';

    /**
     * Address type
     *
     * @var string
     */
    protected $_addressType;

    /**
     * Internal address data holder
     *
     * @var array
     */
    protected $_addressData = Array();

    /**
     * creates an instance of the WirecardCEE_Stdlib_ConsumerData_Address object.
     * addressType should be Shipping or Billing.
     *
     * @param string $addressType
     */
    public function __construct($addressType)
    {
        $this->_addressType = $addressType;
    }

    /**
     * setter for the firstname used for the given address.
     *
     * @param string $firstname
     *
     * @return WirecardCEE_Stdlib_ConsumerData_Address
     */
    public function setFirstname($firstname)
    {
        $this->_setField(self::$FIRSTNAME, $firstname);

        return $this;
    }

    /**
     * setter for the lastname used for the given address.
     *
     * @param string $lastname
     *
     * @return WirecardCEE_Stdlib_ConsumerData_Address
     */
    public function setLastname($lastname)
    {
        $this->_setField(self::$LASTNAME, $lastname);

        return $this;
    }

    /**
     * setter for the addressfield 1 used for the given address.
     *
     * @param string $address1
     *
     * @return WirecardCEE_Stdlib_ConsumerData_Address
     */
    public function setAddress1($address1)
    {
        $this->_setField(self::$ADDRESS1, $address1);

        return $this;
    }

    /**
     * setter for the addressfield 2 used for the given address.
     *
     * @param string $address2
     *
     * @return WirecardCEE_Stdlib_ConsumerData_Address
     */
    public function setAddress2($address2)
    {
        $this->_setField(self::$ADDRESS2, $address2);

        return $this;
    }

    /**
     * setter for the city used for the given address.
     *
     * @param string $city
     *
     * @return WirecardCEE_Stdlib_ConsumerData_Address
     */
    public function setCity($city)
    {
        $this->_setField(self::$CITY, $city);

        return $this;
    }

    /**
     * setter for the country used for the given address.
     *
     * @param string $country
     *
     * @return WirecardCEE_Stdlib_ConsumerData_Address
     */
    public function setCountry($country)
    {
        $this->_setField(self::$COUNTRY, $country);

        return $this;
    }

    /**
     * setter for the state used for the given address.
     *
     * @param string $state
     *
     * @return WirecardCEE_Stdlib_ConsumerData_Address
     */
    public function setState($state)
    {
        $this->_setField(self::$STATE, $state);

        return $this;
    }

    /**
     * setter for the zip code used for the given address.
     *
     * @param string $zipCode
     *
     * @return WirecardCEE_Stdlib_ConsumerData_Address
     */
    public function setZipCode($zipCode)
    {
        $this->_setField(self::$ZIP_CODE, $zipCode);

        return $this;
    }

    /**
     * setter for the phone number used for the given address.
     *
     * @param string $phone
     *
     * @return WirecardCEE_Stdlib_ConsumerData_Address
     */
    public function setPhone($phone)
    {
        $this->_setField(self::$PHONE, $phone);

        return $this;
    }

    /**
     * setter for the fax number used for the given address.
     *
     * @param string $fax
     *
     * @return WirecardCEE_Stdlib_ConsumerData_Address
     */
    public function setFax($fax)
    {
        $this->_setField(self::$FAX, $fax);

        return $this;
    }

    /**
     * setter for an addressfield.
     *
     * @param string $name
     * @param string $value
     */
    protected function _setField($name, $value)
    {
        // e.g. consumerBillingFirstname
        $this->_addressData[self::$PREFIX . $this->_addressType . $name] = (string) $value;
    }

    /**
     * returns the given addressfields as an array
     *
     * @return string[]
     */
    public function getData()
    {
        return $this->_addressData;
    }
}