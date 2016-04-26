<?php
/*
* Die vorliegende Software ist Eigentum von Wirecard CEE und daher vertraulich
* zu behandeln. Jegliche Weitergabe an dritte, in welcher Form auch immer, ist
* unzulaessig.
*
* Software & Service Copyright (C) by
* Wirecard Central Eastern Europe GmbH,
* FB-Nr: FN 195599 x, http://www.wirecard.at
*/

/**
 * Container class for consumerData
 *
 * @name WirecardCEE_Stdlib_ConsumerData
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 * @subpackage ConsumerData
 * @version 3.0.0
 */
class WirecardCEE_Stdlib_ConsumerData {
    /**
     *
     * @var string[]
     */
    protected $_consumerData = Array();

    /**
     *
     * @var string
     */
    protected static $IP_ADDRESS = 'IpAddress';

    /**
     *
     * @var string
     */
    protected static $USER_AGENT = 'UserAgent';

    /**
     *
     * @var string
     */
    protected static $PREFIX = 'consumer';

    /**
     *
     * @var string
     */
    protected static $EMAIL = 'Email';

    /**
     *
     * @var string
     */
    protected static $BIRTH_DATE = 'BirthDate';

    /**
     *
     * @var string
     */
    protected static $TAX_IDENTIFICATION_NUMBER = 'TaxIdentificationNumber';

    /**
     *
     * @var string
     */
    protected static $DRIVERS_LICENSE_NUMBER = 'DriversLicenseNumber';

    /**
     *
     * @var string
     */
    protected static $DRIVERS_LICENSE_COUNTRY = 'DriversLicenseCountry';

    /**
     *
     * @var string
     */
    protected static $DRIVERS_LICENSE_STATE    = 'DriversLicenseState';

    /**
     *
     * @var string
     */
    protected static $BIRTH_DATE_FORMAT    = 'Y-m-d';

    /**
     * setter for the mail address of the consumer
     *
     * @param string $mailAddress
     * @return WirecardCEE_Stdlib_ConsumerData
     */
    public function setEmail($mailAddress) {
        $this->_setField(self::$EMAIL, $mailAddress);
        return $this;
    }

    /**
     * setter for the birthdate of the consumer
     *
     * @param DateTime $birthDate
     * @return WirecardCEE_Stdlib_ConsumerData
     */
    public function setBirthDate(DateTime $birthDate) {
        $this->_setField(self::$BIRTH_DATE, $birthDate->format(self::$BIRTH_DATE_FORMAT));
        return $this;
    }

    /**
     * setter for the tax identification number of the consumer
     *
     * @param string $taxIdentificationNumber
     * @return WirecardCEE_Stdlib_ConsumerData
     */
    public function setTaxIdentificationNumber($taxIdentificationNumber) {
        $this->_setField(self::$TAX_IDENTIFICATION_NUMBER, $taxIdentificationNumber);
        return $this;
    }

    /**
     * setter for the drivers license number of the consumer
     *
     * @param string $driversLicenseNumber
     * @return WirecardCEE_Stdlib_ConsumerData
     */
    public function setDriversLicenseNumber($driversLicenseNumber) {
        $this->_setField(self::$DRIVERS_LICENSE_NUMBER, $driversLicenseNumber);
        return $this;
    }

    /**
     * setter for the drivers license country of the consumer
     *
     * @param string $driversLicenseCountry
     * @return WirecardCEE_Stdlib_ConsumerData
     */
    public function setDriversLicenseCountry($driversLicenseCountry) {
        $this->_setField(self::$DRIVERS_LICENSE_COUNTRY, $driversLicenseCountry);
        return $this;
    }

    /**
     * setter for the drivers license state of the consumer
     *
     * @param string $driversLicenseState
     * @return WirecardCEE_Stdlib_ConsumerData
     */
    public function setDriversLicenseState($driversLicenseState) {
        $this->_setField(self::$DRIVERS_LICENSE_STATE, $driversLicenseState);
        return $this;
    }

    /**
     * adds addressinformation to the consumerdata.
     * used {@link WirecardCEE_Stdlib_ConsumerData::getData()}
     *
     * @param WirecardCEE_Stdlib_ConsumerData_Address $address
     * @return WirecardCEE_Stdlib_ConsumerData
     */
    public function addAddressInformation(WirecardCEE_Stdlib_ConsumerData_Address $address) {
        $consumerData = array_merge($this->_consumerData, $address->getData());
        $this->_consumerData = $consumerData;
        return $this;
    }

    /**
     * setter for the consumer IP-Address
     *
     * @param string $consumerIpAddress
     * @return WirecardCEE_Stdlib_ConsumerData
     */
    public function setIpAddress($consumerIpAddress) {
        $this->_setField(self::$IP_ADDRESS, $consumerIpAddress);
        return $this;
    }

    /**
     * setter for the consumer user-agent
     *
     * @param string $consumerUserAgent
     * @return WirecardCEE_Stdlib_ConsumerData
     */
    public function setUserAgent($consumerUserAgent) {
        $this->_setField(self::$USER_AGENT, $consumerUserAgent);
        return $this;
    }

    /**
     * Getter for all consumerData
     *
     * @return string[]
     */
    public function getData() {
        return $this->_consumerData;
    }

    /**
     * Static getter for consumerUserAgentField
     *
     * @internal
     * @return string
     */
    public static function getConsumerUserAgentFieldName() {
        return self::$PREFIX . self::$USER_AGENT;
    }

    /**
     * Static getter for consumerIpField
     *
     * @internal
     * @return string
     */
    public static function getConsumerIpAddressFieldName() {
        return self::$PREFIX . self::$IP_ADDRESS;
    }

    /**
     * setter for consumerdata fields
     *
     * @param string $name
     * @param string $value
     * @access private
     */
    protected function _setField($name, $value) {
        // e.g. consumerBillingFirstname
        $this->_consumerData[self::$PREFIX . $name] = (string) $value;
    }
}