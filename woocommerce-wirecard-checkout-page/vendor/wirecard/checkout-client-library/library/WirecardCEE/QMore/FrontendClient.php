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
 * @name WirecardCEE_QMore_FrontendClient
 * @category WirecardCEE
 * @package WirecardCEE_QMore
 */
class WirecardCEE_QMore_FrontendClient extends WirecardCEE_Stdlib_Client_ClientAbstract
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
     * Field name: confirmUrl
     *
     * @var string
     */
    const CONFIRM_URL = 'confirmUrl';

    /**
     * Field name: pendingUrl
     *
     * @var string
     */
    const PENDING_URL = 'pendingUrl';

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
     * Field name: window name
     *
     * @var string
     */
    const WINDOW_NAME = 'windowName';

    /**
     * Field name: window name
     *
     * @var string
     */
    const DUPLICATE_REQUEST_CHECK = 'duplicateRequestCheck';

    /**
     * Field name: window name
     *
     * @var string
     */
    const CUSTOMER_STATEMENT = 'customerStatement';

    /**
     * Field name: window name
     *
     * @var string
     */
    const ORDER_REFERENCE = 'orderReference';

    /**
     * Field name: window name
     *
     * @var string
     */
    const CONFIRM_MAIL = 'confirmMail';

    /**
     * Field name: pluginVersion
     *
     * @var string
     */
    const PLUGIN_VERSION = 'pluginVersion';

    /**
     * Field name: customerMerchantCrmId
     *
     * @var string
     */
    const CONSUMER_MERCHANT_CRM_ID = 'consumerMerchantCrmId';

    /**
     * Field name: financialInstitution
     *
     * @var string
     */
    const FINANCIAL_INSTITUTION = 'financialInstitution';

    /**
     * Consumer data holder
     *
     * @var WirecardCEE_Stdlib_ConsumerData
     */
    protected $oConsumerData;

    /**
     * Shopping basket data
     *
     * @var WirecardCEE_Stdlib_Basket
     */
    protected $oBasket;

    /**
     * Internal response holder
     *
     * @var WirecardCEE_QMore_Response_Initiation
     */
    protected $oResponse;

    /**
     * Library name
     *
     * @staticvar string
     * @internal
     */
    protected static $LIBRARY_NAME = 'WirecardCEE_QMore';

    /**
     * Library version
     *
     * @staticvar string
     * @internal
     */
    protected static $LIBRARY_VERSION = '3.4.0';

    /**
     *
     * @param array|Object $config
     */
    public function __construct($config = null)
    {
        $this->_fingerprintOrder = new WirecardCEE_Stdlib_FingerprintOrder();

        //if no config was sent fallback to default config file
        if (is_null($config)) {
            $config = WirecardCEE_QMore_Module::getConfig();
        }

        if (isset( $config['WirecardCEEQMoreConfig'] )) {
            //we only need the WirecardCEEQMoreConfig here
            $config = $config['WirecardCEEQMoreConfig'];
        }

        //let's store configuration details in internal objects
        $this->oUserConfig = is_object($config) ? $config : new WirecardCEE_Stdlib_Config($config);
        $this->oClientConfig = new WirecardCEE_Stdlib_Config(WirecardCEE_QMore_Module::getClientConfig());

        //now let's check if the CUSTOMER_ID, SHOP_ID, LANGUAGE and SECRET exist in $this->oUserConfig object that we've created from config array
        $sCustomerId = isset( $this->oUserConfig->CUSTOMER_ID ) ? trim($this->oUserConfig->CUSTOMER_ID) : null;
        $sShopId     = isset( $this->oUserConfig->SHOP_ID ) ? trim($this->oUserConfig->SHOP_ID) : null;
        $sLanguage   = isset( $this->oUserConfig->LANGUAGE ) ? trim($this->oUserConfig->LANGUAGE) : null;
        $sSecret     = isset( $this->oUserConfig->SECRET ) ? trim($this->oUserConfig->SECRET) : null;


        //If not throw the InvalidArgumentException exception!
        if (empty( $sCustomerId ) || is_null($sCustomerId)) {
            throw new WirecardCEE_QMore_Exception_InvalidArgumentException(sprintf('CUSTOMER_ID passed to %s is invalid.',
                __METHOD__));
        }

        if (empty( $sLanguage ) || is_null($sLanguage)) {
            throw new WirecardCEE_QMore_Exception_InvalidArgumentException(sprintf('LANGUAGE passed to %s is invalid.',
                __METHOD__));
        }

        if (empty( $sSecret ) || is_null($sSecret)) {
            throw new WirecardCEE_QMore_Exception_InvalidArgumentException(sprintf('SECRET passed to %s is invalid.',
                __METHOD__));
        }

        //everything ok! let's set the fields
        $this->_setField(self::SHOP_ID, $sShopId);
        $this->_setField(self::CUSTOMER_ID, $sCustomerId);
        $this->_setField(self::LANGUAGE, $sLanguage);
        $this->_setSecret($sSecret);
    }

    /**
     *
     * @throws WirecardCEE_QMore_Exception_InvalidArgumentException
     */
    public function initiate()
    {
        $aMissingFields = new ArrayObject();

        if (!$this->_isFieldSet(self::CUSTOMER_ID)) {
            $aMissingFields->append(self::CUSTOMER_ID);
        }
        if (!$this->_isFieldSet(self::AMOUNT)) {
            $aMissingFields->append(self::AMOUNT);
        }
        if (!$this->_isFieldSet(self::CURRENCY)) {
            $aMissingFields->append(self::CURRENCY);
        }
        if (!$this->_isFieldSet(self::PAYMENT_TYPE)) {
            $aMissingFields->append(self::PAYMENT_TYPE);
        }
        if (!$this->_isFieldSet(self::LANGUAGE)) {
            $aMissingFields->append(self::LANGUAGE);
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
        if (!$this->_isFieldSet(self::CONFIRM_URL)) {
            $aMissingFields->append(self::CONFIRM_URL);
        }
        if (!$this->_isConsumerDataValid()) {
            $aMissingFields->append('Consumer Data Object (IP and USER_AGENT fields are madatory)');
        }

        //Are there any errors in the $aMissingFields object?
        //If so throw the InvalidArgumentException and print all the fields that are missing!
        if ($aMissingFields->count()) {
            throw new WirecardCEE_QMore_Exception_InvalidArgumentException(sprintf(
                "Could not initiate QMore! Missing mandatory field(s): %s; thrown in %s; Please use the appropriate setter functions to set the missing fields!",
                implode(", ", (array) $aMissingFields), __METHOD__));
        }

        //this is where the magic happens! We send our data to response object and hopefully get back the response object with 'redirectUrl'.
        //Reponse object is also the one who will, if anything goes wrong, return the errors in an array!
        try {
            $this->oResponse = new WirecardCEE_QMore_Response_Initiation($this->_send());

            return $this->oResponse;
        } catch (WirecardCEE_Stdlib_Client_Exception_InvalidResponseException $e) {
            throw $e;
        }
    }

    /**
     * Setter for amount
     *
     * @param int|float $amount
     *
     * @return WirecardCEE_QMore_FrontendClient
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
     * @return WirecardCEE_QMore_FrontendClient
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
     * @return WirecardCEE_QMore_FrontendClient
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
     * @return WirecardCEE_QMore_FrontendClient
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
     * @return WirecardCEE_QMore_FrontendClient
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
     * @return WirecardCEE_QMore_FrontendClient
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
     * @return WirecardCEE_QMore_FrontendClient
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
     * @return WirecardCEE_QMore_FrontendClient
     */
    public function setServiceUrl($sUrl)
    {
        $this->_setField(self::SERVICE_URL, $sUrl);

        return $this;
    }

    /**
     * Setter for the QMore parameter financialInstitution
     *
     * @param string $financialInstitution
     *
     * @return WirecardCEE_QMore_FrontendClient
     */
    public function setFinancialInstitution($financialInstitution)
    {
        $this->_setField(self::FINANCIAL_INSTITUTION, $financialInstitution);

        return $this;
    }

    /**
     * setter for the QMore parameter confirmUrl
     *
     * @param string $confirmUrl
     *
     * @return WirecardCEE_QMore_FrontendClient
     */
    public function setConfirmUrl($confirmUrl)
    {
        $this->_setField(self::CONFIRM_URL, $confirmUrl);

        return $this;
    }

    /**
     * setter for the QMore parameter pendingUrl
     *
     * @param string $pendingUrl
     *
     * @return WirecardCEE_QMore_FrontendClient
     */
    public function setPendingUrl($pendingUrl)
    {
        $this->_setField(self::PENDING_URL, $pendingUrl);

        return $this;
    }

    /**
     * setter for the QMore parameter windowName
     *
     * @param string $windowName
     *
     * @return WirecardCEE_QMore_FrontendClient
     */
    public function setWindowName($windowName)
    {
        $this->_requestData[self::WINDOW_NAME] = $windowName;

        return $this;
    }

    /**
     * setter for the QMore parameter duplicateRequestCheck
     *
     * @param bool $duplicateRequestCheck
     *
     * @return WirecardCEE_QMore_FrontendClient
     */
    public function setDuplicateRequestCheck($duplicateRequestCheck)
    {
        if ($duplicateRequestCheck) {
            $this->_setField(self::DUPLICATE_REQUEST_CHECK, self::$BOOL_TRUE);
        }

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
     * setter for the QMore parameter orderReference
     *
     * @param string $orderReference
     *
     * @return WirecardCEE_QMore_FrontendClient
     */
    public function setOrderReference($orderReference)
    {
        $this->_setField(self::ORDER_REFERENCE, $orderReference);

        return $this;
    }

    /**
     * setter for the QMore paramter autoDeposit
     *
     * @param string $autoDeposit
     *
     * @return WirecardCEE_QMore_FrontendClient
     */
    public function setAutoDeposit($autoDeposit)
    {
        if ($autoDeposit) {
            $this->_setField(self::AUTO_DEPOSIT, self::$BOOL_TRUE);
        }

        return $this;
    }

    /**
     * setter for the QMore parameter orderNumber
     *
     * @param string $orderNumber
     *
     * @return WirecardCEE_QMore_FrontendClient
     */
    public function setOrderNumber($orderNumber)
    {
        $this->_setField(self::ORDER_NUMBER, $orderNumber);

        return $this;
    }

    /**
     * setter for the QMore parameter confirmMail
     *
     * @param string $confirmMail
     *
     * @return WirecardCEE_QMore_FrontendClient
     */
    public function setConfirmMail($confirmMail)
    {
        $this->_setField(self::CONFIRM_MAIL, $confirmMail);

        return $this;
    }

    /**
     * adds given consumerData to QMore request
     *
     * @param WirecardCEE_Stdlib_ConsumerData $consumerData
     *
     * @return WirecardCEE_QMore_FrontendClient
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
     * setter for dataStorage reference data ONLY IN QMORE
     *
     * @param string $orderIdent
     * @param string $storageId
     *
     * @return WirecardCEE_QMore_FrontendClient
     */
    public function setStorageReference($orderIdent, $storageId)
    {
        $this->setStorageId($storageId)->setOrderIdent($orderIdent);

        return $this;
    }

    /**
     * Storage ID setter
     *
     * @param string $sStorageId
     *
     * @return WirecardCEE_QMore_FrontendClient
     */
    public function setStorageId($sStorageId)
    {
        $this->_setField(self::STORAGE_ID, $sStorageId);

        return $this;
    }

    /**
     * Order identification setter
     *
     * @param string $sOrderIdent
     *
     * @return WirecardCEE_QMore_FrontendClient
     */
    public function setOrderIdent($sOrderIdent)
    {
        $this->_setField(self::ORDER_IDENT, $sOrderIdent);

        return $this;
    }

    /**
     * @param string $sPluginVersion
     *
     * @return $this
     */
    public function setPluginVersion($sPluginVersion)
    {
        $this->_setField(self::PLUGIN_VERSION, $sPluginVersion);

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
     * Getter for response object
     *
     * @return WirecardCEE_QMore_Response_Initiation
     * @throws Exception
     */
    public function getResponse()
    {
        if (!$this->oResponse instanceof WirecardCEE_QMore_Response_Initiation) {
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
     * generates an base64 encoded pluginVersion string from the given shop- plugin- and library-versions
     * QMore Client Libary Version will be added automatically
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
        $libraryString = self::_getQMoreClientVersionString();
        if (is_array($libraries)) {
            foreach ($libraries AS $libName => $libVersion) {
                $libraryString .= ", {$libName} {$libVersion}";
            }
        }

        $version = base64_encode("{$shopName};{$shopVersion};{$libraryString};{$pluginName};{$pluginVersion}");

        return $version;
    }


    /***************************
     *       PROTECTED METHODS    *
     ***************************/

    /**
     * Checks to see if the consumer data object is set and has at least madatory fields set
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

        // @see WirecardCEE_QMore_Request_Initiation_ConsumerData
        $sConsumerIpAddressField = WirecardCEE_Stdlib_ConsumerData::getConsumerIpAddressFieldName();
        $sConsumerUserAgentField = WirecardCEE_Stdlib_ConsumerData::getConsumerUserAgentFieldName();

        // get all the consumer data in an array
        // @todo when 5.4 becomes available on our server we coulde use eg. $this->oConsumerData->getData()[$sConsumerIpAddressField]
        $aConsumerData = $this->oConsumerData->getData();

        // check
        return ( isset( $aConsumerData[$sConsumerIpAddressField] ) && !empty( $aConsumerData[$sConsumerIpAddressField] ) ) &&
               ( isset( $aConsumerData[$sConsumerUserAgentField] ) && !empty( $aConsumerData[$sConsumerUserAgentField] ) );
    }

    /**
     * Getter for QMore Client Library Versionstring
     *
     * @access private
     * @return String
     */
    protected static function _getQMoreClientVersionString()
    {
        return self::$LIBRARY_NAME . ' ' . self::$LIBRARY_VERSION;
    }

    /**
     * @see WirecardCEE_Stdlib_Client_ClientAbstract::_getRequestUrl()
     */
    protected function _getRequestUrl()
    {
        return $this->oClientConfig->FRONTEND_URL . '/init';
    }

    /**
     * Returns the user agent string
     *
     * @return string
     */
    protected function _getUserAgent()
    {
        return (string) "{$this->oClientConfig->MODULE_NAME};{$this->oClientConfig->MODULE_VERSION}";
    }
}