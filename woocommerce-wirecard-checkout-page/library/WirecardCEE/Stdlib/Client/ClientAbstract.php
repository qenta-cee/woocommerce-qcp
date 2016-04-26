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
 * @name WirecardCEE_Stdlib_Client_ClientAbstract
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 * @subpackage Client
 * @version 3.0.0
 * @abstract
 */
abstract class WirecardCEE_Stdlib_Client_ClientAbstract {

    /**
     * Secret holder
     *
     * @var string
     */
    protected $_secret;

    /**
     * HTTP Client
     *
     * @var Zend_Http_Client
     */
    protected $_httpClient;

    /**
     *
     * @var string
     */
    protected $userAgent;

    /**
     * Fingerprint order type (dynamic or fixed)
     *
     * @var int
     */
    protected $_fingerprintOrderType = 0;

    /**
     * Fingerprint
     *
     * @var string
     */
    protected $_fingerprintString = null;

    /**
     * Fingeprint order
     *
     * @var WirecardCEE_Stdlib_FingerprintOrder
     */
    protected $_fingerprintOrder;

    /**
     * request data
     *
     * @var string[]
     */
    protected $_requestData;

    /**
     * Request path
     *
     * @var string
     */
    protected $_requestPath = '';

    /**
     * User configuration holder!
     *
     * @var Zend_Config
     */
    protected $oUserConfig;

    /**
     * Client configuration holder!
     *
     * @var Zend_Config
     */
    protected $oClientConfig;

    /**
     * Bool true
     * @var string
     */
    protected static $BOOL_TRUE = 'yes';

    /**
     * BOol false
     * @var string
     */
    protected static $BOOL_FALSE = 'no';

    /**
     * Dynamic fingerprint
     * @var int
     */
    protected static $FINGERPRINT_TYPE_DYNAMIC = 0;

    /**
     * Fixed fingerprint
     * @var int
     */
    protected static $FINGERPRINT_TYPE_FIXED = 1;

    /**
     * Field names variable: customer_id
     * @var string
     */
    const CUSTOMER_ID = 'customerId';

    /**
     * Field names variable: secret
     * @var string
     */
    const SECRET = 'secret';

    /**
     * Field names variable: language
     * @var string
     */
    const LANGUAGE = 'language';

    /**
     * Field names variable: shopId
     * @var string
     */
    const SHOP_ID = 'shopId';

    /**
     * Field names variable: requestFingerprintOrder
     * @var string
     */
    const REQUEST_FINGERPRINT_ORDER = 'requestFingerprintOrder';

    /**
     * Field names variable: requestFingerprint
     * @var string
     */
    const REQUEST_FINGERPRINT = 'requestFingerprint';

    /**
     * Field names variable: amount
     * @var string
     */
    const AMOUNT = 'amount';

    /**
     * Field names variable: currency
     * @var string
     */
    const CURRENCY = 'currency';

    /**
     * Field names variable: orderDescription
     * @var string
     */
    const ORDER_DESCRIPTION = 'orderDescription';

    /**
     * Field names variable: autoDeposit
     * @var string
     */
    const AUTO_DEPOSIT = 'autoDeposit';

    /**
     * Field names variable: orderNumber
     * @var string
     */
    const ORDER_NUMBER = 'orderNumber';

    /**
     * Must be implemented in the client object
     *
     * @param Array $aConfig
     * @abstract
     */
    abstract public function __construct(Array $aConfig = null);

    /**
     * setter for Zend_Http_Client.
     * Use this if you need specific client-configuration.
     * otherwise the clientlibrary instantiates the Zend_Http_Client on its own.
     *
     * @param Zend_Http_Client $httpClient
     * @return WirecardCEE_Stdlib_Client_ClientAbstract
     */
    public function setZendHttpClient(Zend_Http_Client $httpClient) {
        $this->_httpClient = $httpClient;
        return $this;
    }

    /**
     * Returns the user configuration object
     *
     * @return Zend_Config
     */
    public function getUserConfig() {
        return $this->oUserConfig;
    }

    /**
     * Returns the client configuration object
     *
     * @return Zend_Config
     */
    public function getClientConfig() {
        return $this->oClientConfig;
    }

    /**
     * Returns the user agent string
     *
     * @return string
     */
    public function getUserAgentString() {
        $oClientConfig = new Zend_Config(WirecardCEE_Stdlib_Module::getClientConfig());

        $sUserAgent = $this->_getUserAgent() . ";{$oClientConfig->MODULE_NAME};{$oClientConfig->MODULE_VERSION};";

        foreach($oClientConfig->DEPENDENCIES as $sValue) {
            $sUserAgent .= is_string($sValue) ? $sValue . ";" : $sValue->CURRENT . ";";
        }

        return $sUserAgent;
    }

    /**
     * Returns all the request data as an array
     * @return array
     */
    public function getRequestData() {
        return (array) $this->_requestData;
    }

    /**
     * Destructor
     */
    public function __destruct() {
        unset($this);
    }

    /**************************
     *   PROTECTED METHODS    *
     **************************/

    /**
     * Must be implemented in the client
     *
     * @return string
     * @abstract
     */
    abstract protected function _getRequestUrl();

    /**
     * Must be implemented in the client
     *
     * @return string
     * @abstract
     */
    abstract protected function _getUserAgent();

    /**
     * 'Secret' setter
     *
     * @param string $secret
     */
    protected function _setSecret($secret) {
        $this->_secret = $secret;
        $this->_fingerprintOrder[] = self::SECRET;
    }

    /**
     * sends the request and returns the zend http response object instance
     *
     * @throws WirecardCEE_Stdlib_Client_Exception_InvalidResponseException
     * @return Zend_Http_Response
     */
    protected function _send() {
        if (count($this->_fingerprintOrder)) {
            $this->_fingerprintString = $this->_calculateFingerprint();
            if (!is_null($this->_fingerprintString)) {
                $this->_requestData[self::REQUEST_FINGERPRINT] = $this->_fingerprintString;
            }
        }

        try {
            $response = $this->_sendRequest();
        }
        catch (Zend_Http_Client_Exception $e) {
            throw new WirecardCEE_Stdlib_Client_Exception_InvalidResponseException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }

    /**
     * method to calculate md5 fingerprintstring from given fields.
     *
     * @return string - md5 fingerprint hash
     */
    protected function _calculateFingerprint() {
        $oFingerprintOrder = $this->_fingerprintOrder;

        if ($this->_fingerprintOrderType == self::$FINGERPRINT_TYPE_DYNAMIC) {
            // we have to add REQUESTFINGERPRINTORDER to local fingerprintOrder to add correct value to param list
            $oFingerprintOrder[] = self::REQUEST_FINGERPRINT_ORDER;
            $this->_requestData[self::REQUEST_FINGERPRINT_ORDER] = (string) $oFingerprintOrder;
        }
        // fingerprintFields == requestFields + secret - secret MUST NOT be send as param
        $fingerprintFields = $this->_requestData;
        $fingerprintFields[self::SECRET] = $this->_secret;

        return WirecardCEE_Stdlib_Fingerprint::generate($fingerprintFields, $oFingerprintOrder);
    }

    /**
     * Sends the request and returns the zend http response object instance
     *
     * @throws Zend_Http_Client_Exception
     * @return Zend_Http_Response
     */
    protected function _sendRequest() {
        $httpClient = $this->_getZendHttpClient();
        $httpClient->setParameterPost($this->_requestData);
        $httpClient->setConfig(Array(
                'useragent' => $this->getUserAgentString()
        ));

        return $httpClient->request(Zend_Http_Client::POST);
    }

    /**
     * Setter for requestfield.
     * Bare in mind that $this->_fingerprintOrder is an WirecardCEE_Stdlib_FingerprintOrder object which implements
     * the ArrayAccess interface meaning we can use the array annotation [] on an object
     *
     * @see WirecardCEE_Stdlib_FingerprintOrder
     * @param string $name
     * @param mixed $value
     */
    protected function _setField($name, $value) {
        $this->_requestData[(string) $name] = (string) $value;
        $this->_fingerprintOrder[] = (string) $name;
    }

    /**
     * Check if we the field is set in the _requestData array
     *
     * @param string $sFieldname
     * @return boolean
     */
    protected function _isFieldSet($sFieldname) {
        return (bool) (isset($this->_requestData[$sFieldname]) && !empty($this->_requestData[$sFieldname]));
    }

    /**
     * private getter for the Zend_Http_Client
     * if not set yet it will be instantiated
     *
     * @return Zend_Http_Client
     */
    protected function _getZendHttpClient() {
        if (is_null($this->_httpClient)) {
            // @todo implement SSL check here
            $this->_httpClient = new Zend_Http_Client($this->_getRequestUrl());
        }
        else {
            $this->_httpClient->resetParameters(true);
            $this->_httpClient->setUri($this->_getRequestUrl());
        }

        return $this->_httpClient;
    }
}