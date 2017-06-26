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
 * @name WirecardCEE_QPay_FrontendClient
 * @category WirecardCEE
 * @package WirecardCEE_QPay
 */
class WirecardCEE_QPay_FrontendClient extends WirecardCEE_Stdlib_Client_ClientAbstract
{

    /**
     * Field name: PaymentType
     *
     * @var string
     */
    const PAYMENT_TYPE = 'paymentType';

    /**
     * Field name: successUrl
     *
     * @var string
     */
    const SUCCESS_URL = 'successUrl';

    /**
     * Field name: cancelUrl
     *
     * @var string
     */
    const CANCEL_URL = 'cancelUrl';

    /**
     * Field name: failureUrl
     *
     * @var string
     */
    const FAILURE_URL = 'failureUrl';

    /**
     * Field name: serviceUrl
     *
     * @var string
     */
    const SERVICE_URL = 'serviceUrl';

    /**
     * Field name: pendingUrl
     *
     * @var string
     */
    const PENDING_URL = 'pendingUrl';

    /**
     * Field name: financialInstitution
     *
     * @var string
     */
    const FINANCIAL_INSTITUTION = 'financialInstitution';

    /**
     * Field name: displayText
     *
     * @var string
     */
    const DISPLAY_TEXT = 'displayText';

    /**
     * Field name: confirmUrl
     *
     * @var string
     */
    const CONFIRM_URL = 'confirmUrl';

    /**
     * Field name: imageUrl
     *
     * @var string
     */
    const IMAGE_URL = 'imageUrl';

    /**
     * Field name: windowName
     *
     * @var string
     */
    const WINDOW_NAME = 'windowName';

    /**
     * Field name: duplicateRequestCheck
     *
     * @var string
     */
    const DUPLICATE_REQUEST_CHECK = 'duplicateRequestCheck';

    /**
     * Field name: customerStatement
     *
     * @var string
     */
    const CUSTOMER_STATEMENT = 'customerStatement';

    /**
     * Field name: orderReference
     *
     * @var string
     */
    const ORDER_REFERENCE = 'orderReference';

    /**
     * Field name: maxRetries
     *
     * @var string
     */
    const MAX_RETRIES = 'maxRetries';

    /**
     * Field name: confirmMail
     *
     * @var string
     */
    const CONFIRM_MAIL = 'confirmMail';

    /**
     * Field name: orderIdent
     *
     * @var string
     */
    const ORDER_IDENT = 'orderIdent';

    /**
     * Field name: storageId
     *
     * @var string
     */
    const STORAGE_ID = 'storageId';

    /**
     * Field name: backgroundColor
     *
     * @var string
     */
    const BACKGROUND_COLOR = 'backgroundColor';

    /**
     * Field name: layout
     *
     * @var string
     */
    const LAYOUT = 'layout';

    /**
     * Field name: paymenttypeSortOrder
     *
     * @var string
     */
    const PAYMENTTYPE_SORTORDER = 'paymenttypeSortOrder';

    /**
     * Field name: pluginVersion
     *
     * @var string
     */
    const PLUGIN_VERSION = 'pluginVersion';

    /**
     * Field name: consumerMerchantCrmId
     *
     * @var string
     */
    const CONSUMER_MERCHANT_CRM_ID = 'consumerMerchantCrmId';

    /**
     * Field name: shippingProfile
     *
     * @var string
     */
    const SHIPPING_PROFILE = 'shippingProfile';

    /**
     * Type of the fingerprint order
     *
     * @var int
     */
    protected $_fingerprintOrderType = 0;

    /**
     * Response object
     *
     * @var WirecardCEE_QPay_Response_Initiation
     */
    protected $oResponse;

    /**
     * Consumer data holder
     *
     * @var WirecardCEE_Stdlib_ConsumerData
     */
    protected $oConsumerData;

    /**
     * @var WirecardCEE_Stdlib_Basket
     */
    protected $oBasket;

    /**
     * Library name
     *
     * @staticvar string
     * @internal
     */
    protected static $LIBRARY_NAME = 'WirecardCEE_QPay';

    /**
     * Library version
     *
     * @staticvar string
     * @internal
     */
    protected static $LIBRARY_VERSION = '3.4.0';

    /**
     * Constructor
     *
     * @param mixed $aConfig
     *
     * @throws WirecardCEE_QPay_Exception_InvalidParamLengthException
     * @throws WirecardCEE_QPay_Exception_InvalidArgumentException
     * @formatter:off
     */
    public function __construct($aConfig = null)
    {
        $this->_fingerprintOrder = new WirecardCEE_Stdlib_FingerprintOrder();

        //if no config was sent fallback to default config file
        if (is_null($aConfig)) {
            $aConfig = WirecardCEE_QPay_Module::getConfig();
        }

        if (isset( $aConfig['WirecardCEEQPayConfig'] )) {
            //we only need the WirecardCEEQPayConfig here
            $aConfig = $aConfig['WirecardCEEQPayConfig'];
        }

        //let's store configuration details in internal objects
        $this->oUserConfig = new WirecardCEE_Stdlib_Config($aConfig);
        $this->oClientConfig = new WirecardCEE_Stdlib_Config(WirecardCEE_QPay_Module::getClientConfig());

        //now let's check if the CUSTOMER_ID, SHOP_ID, LANGUAGE and SECRET exist in $this->oUserConfig object that we created from config array
        $sCustomerId = isset( $this->oUserConfig->CUSTOMER_ID ) ? trim($this->oUserConfig->CUSTOMER_ID) : null;
        $sShopId     = isset( $this->oUserConfig->SHOP_ID ) ? trim($this->oUserConfig->SHOP_ID) : null;
        $sLanguage   = isset( $this->oUserConfig->LANGUAGE ) ? trim($this->oUserConfig->LANGUAGE) : null;
        $sSecret     = isset( $this->oUserConfig->SECRET ) ? trim($this->oUserConfig->SECRET) : null;

        //If not throw the InvalidArgumentException exception!
        if (empty( $sCustomerId ) || is_null($sCustomerId)) {
            throw new WirecardCEE_QPay_Exception_InvalidArgumentException(sprintf('CUSTOMER_ID passed to %s is invalid.',
                __METHOD__));
        }

        if (empty( $sLanguage ) || is_null($sLanguage)) {
            throw new WirecardCEE_QPay_Exception_InvalidArgumentException(sprintf('LANGUAGE passed to %s is invalid.',
                __METHOD__));
        }

        if (empty( $sSecret ) || is_null($sSecret)) {
            throw new WirecardCEE_QPay_Exception_InvalidArgumentException(sprintf('SECRET passed to %s is invalid.',
                __METHOD__));
        }

        // we're using hmac sha512 for hash-ing
        WirecardCEE_Stdlib_Fingerprint::setHashAlgorithm(WirecardCEE_Stdlib_Fingerprint::HASH_ALGORITHM_HMAC_SHA512);

        //everything ok! let's set the fields
        $this->_setField(self::CUSTOMER_ID, $sCustomerId);
        $this->_setField(self::SHOP_ID, $sShopId);
        $this->_setField(self::LANGUAGE, $sLanguage);
        $this->_setSecret($sSecret);
    }

    /**
     * Initialization of QPay Client
     * This function should be called AFTER you've set all the mandatory fields
     * (for a list of mandatory fields please consult the integration manual)
     *
     * @throws WirecardCEE_QPay_Exception_InvalidArgumentException
     * @return WirecardCEE_QPay_Response_Initiation
     */
    public function initiate()
    {
        //First let's check if all mandatory fields are set! If not add them to $aMissingFields Array Object
        $aMissingFields = new ArrayObject();

        if (!$this->_isFieldSet(self::AMOUNT)) {
            $aMissingFields->append(self::AMOUNT);
        }
        if (!$this->_isFieldSet(self::PAYMENT_TYPE)) {
            $aMissingFields->append(self::PAYMENT_TYPE);
        }
        if (!$this->_isFieldSet(self::ORDER_DESCRIPTION)) {
            $aMissingFields->append(self::ORDER_DESCRIPTION);
        }
        if (!$this->_isFieldSet(self::SUCCESS_URL)) {
            $aMissingFields->append(self::SUCCESS_URL);
        }
        if (!$this->_isFieldSet(self::CANCEL_URL)) {
            $aMissingFields->append(self::CANCEL_URL);
        }
        if (!$this->_isFieldSet(self::FAILURE_URL)) {
            $aMissingFields->append(self::FAILURE_URL);
        }
        if (!$this->_isFieldSet(self::SERVICE_URL)) {
            $aMissingFields->append(self::SERVICE_URL);
        }
        if (!$this->_isFieldSet(self::CURRENCY)) {
            $aMissingFields->append(self::CURRENCY);
        }
        if (!$this->_isFieldSet(self::LANGUAGE)) {
            $aMissingFields->append(self::LANGUAGE);
        }
        if (!$this->_isConsumerDataValid()) {
            $aMissingFields->append('Consumer IP Address, Consumer User Agent');
        }

        //Are there any errors in the $aMissingFields object?
        //If so throw the InvalidArgumentException and print all the fields that are missing!
        if ($aMissingFields->count()) {
            throw new WirecardCEE_QPay_Exception_InvalidArgumentException(sprintf(
                "Could not initiate QPay! Missing mandatory field(s): %s; thrown in %s; Please use the appropriate setter functions to set missing fields.",
                implode(", ", (array) $aMissingFields), __METHOD__));
        }

        //this is where the magic happens! We send our data to response object and hopefully get back the response object with 'redirectUrl'.
        //Reponse object is also the one who will, if anything goes wrong, return the errors in an array!
        $this->oResponse = new WirecardCEE_QPay_Response_Initiation($this->_send());

        //and return the Response object
        return $this->oResponse;
    }

    /**
     * Setter for amount
     *
     * @param int|float $amount
     *
     * @return WirecardCEE_QPay_FrontendClient
     * @formatter:on
     */
    public function setAmount($amount)
    {
        $this->_setField(self::AMOUNT, $amount);

        return $this;
    }

    /**
     * Setter for currency
     *
     * @param string $sCurrency
     *
     * @return WirecardCEE_QPay_FrontendClient
     */
    public function setCurrency($sCurrency)
    {
        $this->_setField(self::CURRENCY, $sCurrency);

        return $this;
    }

    /**
     * Setter for payment type
     *
     * @param string $sPaymentType
     *
     * @return WirecardCEE_QPay_FrontendClient
     */
    public function setPaymentType($sPaymentType)
    {
        $this->_setField(self::PAYMENT_TYPE, $sPaymentType);

        return $this;
    }

    /**
     * Setter for order description
     *
     * @param string $sDesc
     *
     * @return WirecardCEE_QPay_FrontendClient
     */
    public function setOrderDescription($sDesc)
    {
        $this->_setField(self::ORDER_DESCRIPTION, $sDesc);

        return $this;
    }

    /**
     * Setter for success url
     *
     * @param string $sUrl
     *
     * @return WirecardCEE_QPay_FrontendClient
     */
    public function setSuccessUrl($sUrl)
    {
        $this->_setField(self::SUCCESS_URL, $sUrl);

        return $this;
    }

    /**
     * Setter for cancel url
     *
     * @param string $sUrl
     *
     * @return WirecardCEE_QPay_FrontendClient
     */
    public function setCancelUrl($sUrl)
    {
        $this->_setField(self::CANCEL_URL, $sUrl);

        return $this;
    }

    /**
     * Setter for failure url
     *
     * @param string $sUrl
     *
     * @return WirecardCEE_QPay_FrontendClient
     */
    public function setFailureUrl($sUrl)
    {
        $this->_setField(self::FAILURE_URL, $sUrl);

        return $this;
    }

    /**
     * Setter for service url
     *
     * @param string $sUrl
     *
     * @return WirecardCEE_QPay_FrontendClient
     */
    public function setServiceUrl($sUrl)
    {
        $this->_setField(self::SERVICE_URL, $sUrl);

        return $this;
    }

    /**
     * setter for the QPay parameter pendingUrl
     *
     * @param string $pendingUrl
     *
     * @return WirecardCEE_QPay_FrontendClient
     */
    public function setPendingUrl($pendingUrl)
    {
        $this->_setField(self::PENDING_URL, $pendingUrl);

        return $this;
    }

    /**
     * Setter for the qpay parameter financialInstitution
     * Only applicable if payment type is EPS or IDL (iDeal)
     *
     * @param string $financialInstitution
     *
     * @return WirecardCEE_QPay_FrontendClient
     */
    public function setFinancialInstitution($financialInstitution)
    {
        $this->_setField(self::FINANCIAL_INSTITUTION, $financialInstitution);

        return $this;
    }

    /**
     * setter for the qpay parameter displaytext
     *
     * @param string $displayText
     *
     * @return WirecardCEE_QPay_FrontendClient
     */
    public function setDisplayText($displayText)
    {
        $this->_setField(self::DISPLAY_TEXT, $displayText);

        return $this;
    }

    /**
     * setter for the qpay parameter confirmUrl
     *
     * @param string $confirmUrl
     *
     * @return WirecardCEE_QPay_FrontendClient
     */
    public function setConfirmUrl($confirmUrl)
    {
        $this->_setField(self::CONFIRM_URL, $confirmUrl);

        return $this;
    }

    /**
     * setter for the qpay parameter imageUrl
     *
     * @param string $imageUrl
     *
     * @return WirecardCEE_QPay_FrontendClient
     */
    public function setImageUrl($imageUrl)
    {
        $this->_setField(self::IMAGE_URL, $imageUrl);

        return $this;
    }

    /**
     * setter for the qpay parameter windowName
     *
     * @param string $windowName
     *
     * @return WirecardCEE_QPay_FrontendClient
     */
    public function setWindowName($windowName)
    {
        $this->_requestData[self::WINDOW_NAME] = $windowName;

        return $this;
    }

    /**
     * setter for the qpay parameter duplicateRequestCheck
     *
     * @param bool $duplicateRequestCheck
     *
     * @return WirecardCEE_QPay_FrontendClient
     */
    public function setDuplicateRequestCheck($duplicateRequestCheck)
    {
        if ($duplicateRequestCheck) {
            $this->_setField(self::DUPLICATE_REQUEST_CHECK, self::$BOOL_TRUE);
        }

        return $this;
    }

    /**
     * setter for the QMore parameter customerStatement
     *
     * @param string $customerStatement
     *
     * @return $this
     */
    public function setCustomerStatement($customerStatement)
    {
        $this->_setField(self::CUSTOMER_STATEMENT, $customerStatement);

        return $this;
    }

    /**
     * Setter for TransactionIdentifier
     *
     * @param string $sTxIdent
     *
     * @return WirecardCEE_QPay_FrontendClient
     */
    public function setTransactionIdentifier($sTxIdent)
    {
        $this->_setField(self::TX_IDENT, $sTxIdent);

        return $this;
    }

    /**
     * setter for Paymenttype sort oder
     *
     * @param array $paymentTypes
     *
     * @return WirecardCEE_QPay_FrontendClient
     */
    public function setPaymenttypeSortOrder($paymentTypes)
    {
        $this->_setField(self::PAYMENTTYPE_SORTORDER, implode(',', $paymentTypes));

        return $this;
    }


    /**
     * @param string|null $prefix Prefix, e.g. Shopname
     * @param string|null $uniqString Uniqid
     *
     * @return $this
     * @throws Exception
     */
    public function generateCustomerStatement($prefix = null, $uniqString = null)
    {
        if (!$this->_isFieldSet(self::PAYMENT_TYPE)) {
            throw new Exception('Paymenttype field is not set.');
        }

        $this->_setField(
            self::CUSTOMER_STATEMENT,
            $this->_composeCustomerStatement($this->_requestData[self::PAYMENT_TYPE], $prefix, $uniqString));

        return $this;
    }

    /**
     * getter for the QMore parameter customerStatement
     *
     * @return string|null
     */
    public function getCustomerStatement()
    {
        if (!$this->_isFieldSet(self::CUSTOMER_STATEMENT)) {
            return null;
        }

        return $this->_requestData[self::CUSTOMER_STATEMENT];
    }

    /**
     * setter for the qpay parameter orderReference
     *
     * @param string $orderReference
     *
     * @return WirecardCEE_QPay_FrontendClient
     */
    public function setOrderReference($orderReference)
    {
        $this->_setField(self::ORDER_REFERENCE, $orderReference);

        return $this;
    }

    /**
     * setter for the qpay paramter autoDeposit
     *
     * @param string $bBool
     *
     * @return WirecardCEE_QPay_FrontendClient
     */
    public function setAutoDeposit($bBool)
    {
        $this->_setField(self::AUTO_DEPOSIT, ( $bBool ) ? self::$BOOL_TRUE : self::$BOOL_FALSE);

        return $this;
    }

    /**
     * setter for the qpay parameter maxRetries
     *
     * @param string $maxRetries
     *
     * @return WirecardCEE_QPay_FrontendClient
     */
    public function setMaxRetries($maxRetries)
    {
        $maxRetries = intval($maxRetries);
        if ($maxRetries >= 0) {
            $this->_setField(self::MAX_RETRIES, $maxRetries);
        }

        return $this;
    }

    /**
     * setter for the customer merchant crm id
     * @param $userEmail
     *
     * @return $this
     */
    public function createConsumerMerchantCrmId($userEmail)
    {
        $this->_setField(self::CONSUMER_MERCHANT_CRM_ID, md5($userEmail));

        return $this;
    }


    /**
     * setter for the qpay parameter orderNumber
     *
     * @param int $orderNumber
     *
     * @return WirecardCEE_QPay_FrontendClient
     */
    public function setOrderNumber($orderNumber)
    {
        $this->_setField(self::ORDER_NUMBER, $orderNumber);

        return $this;
    }

    /**
     * setter for the qpay parameter confirmMail
     *
     * @param string $confirmMail
     *
     * @return WirecardCEE_QPay_FrontendClient
     */
    public function setConfirmMail($confirmMail)
    {
        $this->_setField(self::CONFIRM_MAIL, $confirmMail);

        return $this;
    }

    /**
     * setter for the qpay parameter backgroundColor
     *
     * @param string $backgroundColor
     *
     * @return WirecardCEE_QPay_FrontendClient
     */
    public function setBackgroundColor($backgroundColor)
    {
        $this->_setField(self::BACKGROUND_COLOR, $backgroundColor);

        return $this;
    }

    /**
     * setter for the qpay parameter backgroundColor
     *
     * @param string $layout
     *
     * @return WirecardCEE_QPay_FrontendClient
     */
    public function setLayout($layout)
    {
        $this->_setField(self::LAYOUT, $layout);

        return $this;
    }

    /**
     * adds given consumerData to qpay request
     *
     * @param WirecardCEE_Stdlib_ConsumerData $consumerData
     *
     * @return WirecardCEE_QPay_FrontendClient
     */
    public function setConsumerData(WirecardCEE_Stdlib_ConsumerData $consumerData)
    {
        $this->oConsumerData = $consumerData;
        foreach ($consumerData->getData() as $key => $value) {
            $this->_setField($key, $value);
        }

        return $this;
    }

    /**
     * @param WirecardCEE_Stdlib_Basket $basket
     * @return $this
     */
    public function setBasket(WirecardCEE_Stdlib_Basket $basket) {
        $this->oBasket = $basket;
        foreach($basket->getData() AS $key => $value) {
            $this->_setField($key, $value);
        }
        return $this;
    }

    /**
     *
     * @param string $sPluginVersion
     *
     * @return WirecardCEE_QPay_FrontendClient
     */
    public function setPluginVersion($sPluginVersion)
    {
        $this->_setField(self::PLUGIN_VERSION, $sPluginVersion);

        return $this;
    }

    public function setShippingProfile($shippingProfile)
    {
        $this->_setField(self::SHIPPING_PROFILE, $shippingProfile);
    }

    /**
     * Getter for response object
     *
     * @return WirecardCEE_QPay_Response_Initiation
     * @throws Exception
     */
    public function getResponse()
    {
        if (!$this->oResponse instanceof WirecardCEE_QPay_Response_Initiation) {
            throw new Exception(sprintf("%s should be called after the initiate() function!", __METHOD__));
        }

        return $this->oResponse;
    }

    /**
     * Magic method for setting request parameters.
     * may be used for additional parameters
     *
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $this->_setField($name, $value);
    }

    /**
     * generates an base64 encoded pluginVersion string from the given shop-
     * plugin- and library-versions
     * QPAY Client Libary Version will be added automatically
     *
     * @param string $shopName
     * @param string $shopVersion
     * @param string $pluginName
     * @param string $pluginVersion
     * @param array|null $libraries
     *
     * @return string base64 encoded pluginVersion
     */
    public static function generatePluginVersion(
        $shopName,
        $shopVersion,
        $pluginName,
        $pluginVersion,
        $libraries = null
    ) {
        $libraryString = self::_getQPayClientVersionString();
        if (is_array($libraries)) {
            foreach ($libraries as $libName => $libVersion) {
                $libraryString .= ", {$libName} {$libVersion}";
            }
        }

        $version = base64_encode("{$shopName};{$shopVersion};{$libraryString};{$pluginName};{$pluginVersion}");

        return $version;
    }

    #----------------------------#
    #     PROTECTED METHODS      #
    #----------------------------#

    /**
     * Checks to see if the consumer data object is set and has at least
     * madatory fields set
     *
     * @return boolean
     */
    protected function _isConsumerDataValid()
    {
        // if consumer data is not an instance of WirecardCEE_Stdlib_ConsumerData
        // or if it's empty don't even bother with any checkings...
        if (empty( $this->oConsumerData ) || !$this->oConsumerData instanceof WirecardCEE_Stdlib_ConsumerData) {
            return false;
        }

        // @see WirecardCEE_QPay_Request_Initiation_ConsumerData
        $sConsumerIpAddressField = WirecardCEE_Stdlib_ConsumerData::getConsumerIpAddressFieldName();
        $sConsumerUserAgentField = WirecardCEE_Stdlib_ConsumerData::getConsumerUserAgentFieldName();

        // get all the consumer data in an array
        // @todo when 5.4 becomes available on our server we coulde use eg.
        // $this->oConsumerData->getData()[$sConsumerIpAddressField]
        $aConsumerData = $this->oConsumerData->getData();

        // check
        return ( isset( $aConsumerData[$sConsumerIpAddressField] ) && !empty( $aConsumerData[$sConsumerIpAddressField] ) ) &&
               ( isset( $aConsumerData[$sConsumerUserAgentField] ) && !empty( $aConsumerData[$sConsumerUserAgentField] ) );
    }

    /**
     * Returns the requestUrl
     *
     * @see WirecardCEE_Stdlib_Client_ClientAbstract::_getRequestUrl()
     * @return string
     */
    protected function _getRequestUrl()
    {
        return $this->oClientConfig->FRONTEND_URL . '/init';
    }

    /**
     * Getter for QPay Client Library Versionstring
     *
     * @access private
     * @return String
     */
    protected static function _getQPayClientVersionString()
    {
        return self::$LIBRARY_NAME . ' ' . self::$LIBRARY_VERSION;
    }

    /**
     * Returns the user agent string
     *
     * @return string
     */
    protected function _getUserAgent()
    {
        return "{$this->oClientConfig->MODULE_NAME};{$this->oClientConfig->MODULE_VERSION}";
    }
}