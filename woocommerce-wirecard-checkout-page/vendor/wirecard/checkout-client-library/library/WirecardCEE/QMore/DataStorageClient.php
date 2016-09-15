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
 * @name WirecardCEE_QMore_DataStorageClient
 * @category WirecardCEE
 * @package WirecardCEE_QMore
 */
class WirecardCEE_QMore_DataStorageClient extends WirecardCEE_Stdlib_Client_ClientAbstract
{

    /**
     * Response holder
     *
     * @var WirecardCEE_QMore_DataStorage_Response_Initiation
     */
    protected $oInitResponse;

    /**
     * Read response holder
     *
     * @var WirecardCEE_QMore_DataStorage_Request_Read
     */
    protected $oDataStorageReadResponse;

    /**
     * Fingerprint order type
     *
     * @var int
     */
    protected $_fingerprintOrderType = 1;

    /**
     * ReturnUrl Field name
     *
     * @var string
     */
    const RETURN_URL = 'returnUrl';

    /**
     * Order identification field name
     *
     * @var string
     */
    const ORDER_IDENT = 'orderIdent';

    /**
     * Javascript Script Version field name
     * set to 'pci3' for PCI Dss Saq A compat
     *
     * @var string
     */
    const JAVASCRIPT_SCRIPT_VERSION = 'javascriptScriptVersion';

    /**
     * Storage ID field name
     *
     * @var string
     */
    const STORAGE_ID = "storageId";

    /**
     * Iframe Css Url field name
     *
     * @var string
     */
    const IFRAME_CSS_URL = 'iframeCssUrl';

    /**
     * CreditCard Show Issue Date field name (pci3 only)
     *
     * @var string
     */
    const CREDITCARD_SHOW_ISSUE_DATEFIELD = 'creditcardShowIssueDateField';

    /**
     * CreditCard Show Issue Number field name (pci3 only)
     *
     * @var string
     */
    const CREDITCARD_SHOW_ISSUE_NUMBERFIELD = 'creditcardShowIssueNumberField';

    /**
     * CreditCard Show Cardholder field name (pci3 only)
     *
     * @var string
     */
    const CREDITCARD_SHOW_CARDHOLDER_NAMEFIELD = 'creditcardShowCardholderNameField';

    /**
     * CreditCard Show CVC field name (pci3 only)
     *
     * @var string
     */
    const CREDITCARD_SHOW_CVC_FIELD = 'creditcardShowCvcField';

    /**
     * Placeholder text for the credit card number field.
     *
     * @var string
     */
    const CREDITCARD_PAN_PLACEHOLDER = 'creditcardPanPlaceholder';

    /**
     *  Placeholder text for the credit card verification number field.
     *
     * @var string
     */
    const CREDITCARD_CVC_PLACEHOLDER = 'creditcardCvcPlaceholder';

    /**
     * Placeholder text for the credit card holder field.
     *
     * @var string
     */
    const CREDITCARD_CARDHOLDERNAME_PLACEHOLDER = 'creditcardCardholderNamePlaceholder';

    /**
     * Placeholder text for the credit card issue number.
     *
     * @var string
     */
    const CREDITCARD_ISSUENUMBER_PLACEHOLDER = 'creditcardIssueNumberPlaceholder';

    /**
     *  Display placeholder text for the credit card expiration date.
     *
     * @var string
     */
    const CREDITCARD_SHOW_EXPIRATIONDATE_PLACEHOLDER = 'creditcardShowExpirationDatePlaceholder';

    /**
     * Display placeholder text for the credit card issue date.
     *
     * @var string
     */
    const CREDITCARD_SHOW_ISSUEDATE_PLACEHOLDER = 'creditcardShowIssueDatePlaceholder';

    /**
     * DataStorage contructor.
     *
     * @param array|Object $config
     *
     * @throws WirecardCEE_QMore_Exception_InvalidArgumentException
     */
    public function __construct($config = null)
    {
        $this->_fingerprintOrder = new WirecardCEE_Stdlib_FingerprintOrder();

        //if no config was sent fallback to default config file
        if (is_null($config)) {
            $config = WirecardCEE_QMore_Module::getConfig();
        }

        if (isset( $config['WirecardCEEQMoreConfig'] )) {
            //we only need WirecardCEEQMoreConfig here
            $config = $config['WirecardCEEQMoreConfig'];
        }

        $this->oUserConfig   = is_object($config) ? $config : new WirecardCEE_Stdlib_Config($config);
        $this->oClientConfig = new WirecardCEE_Stdlib_Config(WirecardCEE_QMore_Module::getClientConfig());

        //now let's check if the CUSTOMER_ID, SHOP_ID, LANGUAGE and SECRET exist in config array
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

        $this->_setField(self::SHOP_ID, $sShopId);
        $this->_setField(self::CUSTOMER_ID, $sCustomerId);
        $this->_setField(self::LANGUAGE, $sLanguage);
        $this->_setSecret($sSecret);
    }

    /**
     *
     * @return WirecardCEE_QMore_DataStorage_Response_Initiation
     */
    public function initiate()
    {
        $aMissingFields = new ArrayObject();

        if (!$this->_isFieldSet(self::CUSTOMER_ID)) {
            $aMissingFields->append(self::CUSTOMER_ID);
        }
        if (!$this->_isFieldSet(self::ORDER_IDENT)) {
            $aMissingFields->append(self::ORDER_IDENT);
        }
        if (!$this->_isFieldSet(self::RETURN_URL)) {
            $aMissingFields->append(self::RETURN_URL);
        }
        if (!$this->_isFieldSet(self::LANGUAGE)) {
            $aMissingFields->append(self::LANGUAGE);
        }
        if (empty( $this->_secret )) {
            $aMissingFields->append(self::SECRET);
        }

        //Are there any errors in the $aMissingFields object?
        //If so throw the InvalidArgumentException and print all the fields that are missing!
        if ($aMissingFields->count()) {
            throw new WirecardCEE_QMore_Exception_InvalidArgumentException(sprintf("Could not initiate DataStorage! Missing mandatory field(s): %s; thrown in %s",
                implode(", ", (array) $aMissingFields), __METHOD__));
        }

        if (!$this->_isFieldSet(self::JAVASCRIPT_SCRIPT_VERSION)) {
            $this->setJavascriptScriptVersion('');
        }

        $this->_fingerprintOrder->setOrder(Array(
            self::CUSTOMER_ID,
            self::SHOP_ID,
            self::ORDER_IDENT,
            self::RETURN_URL,
            self::LANGUAGE,
            self::JAVASCRIPT_SCRIPT_VERSION,
            self::SECRET
        ));

        $this->oInitResponse = new WirecardCEE_QMore_DataStorage_Response_Initiation($this->_send());

        return $this->oInitResponse;
    }

    /**
     *
     * @throws WirecardCEE_QMore_Exception_InvalidArgumentException
     */
    public function read()
    {
        $aMissingFields = new ArrayObject();

        if (!$this->_isFieldSet(self::CUSTOMER_ID)) {
            $aMissingFields->append(self::CUSTOMER_ID);
        }

        // check if storageId has been set from outside. If not fallback to
        // response and see if response can give us storageId
        if (!$this->_isFieldSet(self::STORAGE_ID)) {
            if (!$this->oInitResponse instanceof WirecardCEE_QMore_DataStorage_Response_Initiation) {
                throw new WirecardCEE_QMore_Exception_BadMethodCallException(sprintf("StorageId hasn't been found. Use 'initiate()' or 'setStorageId()'! Thrown in %s",
                    __METHOD__));
            }

            $sStorageId = $this->oInitResponse->getStorageId();

            if (empty( $sStorageId ) || is_null($sStorageId)) {
                $aMissingFields->append(self::STORAGE_ID);
            } else {
                $this->setStorageId($sStorageId);
            }
        }

        //Are there any errors in the $aMissingFields object?
        //If so throw the InvalidArgumentException and print all the fields that are missing!
        if ($aMissingFields->count()) {
            throw new WirecardCEE_QMore_Exception_InvalidArgumentException(sprintf("Could not initiate DataStorage Read! Missing mandatory field(s): %s; thrown in %s",
                implode(", ", (array) $aMissingFields), __METHOD__));
        }

        $_dataStorageRead               = new WirecardCEE_QMore_DataStorage_Request_Read($this->oUserConfig->toArray());
        $this->oDataStorageReadResponse = $_dataStorageRead->read($this->_requestData[self::STORAGE_ID]);

        return $this->oDataStorageReadResponse;
    }


    /**
     * setter for parameter javascriptScriptVersion
     *
     * @param string $javascriptScriptVersion
     *
     * @return WirecardCEE_QMore_DataStorageClient
     */
    public function setJavascriptScriptVersion($javascriptScriptVersion)
    {
        $this->_setField(self::JAVASCRIPT_SCRIPT_VERSION, $javascriptScriptVersion);

        return $this;
    }

    /**
     * Setter for returnUrl
     *
     * @param string $sUrl
     *
     * @return WirecardCEE_QMore_DataStorageClient
     */
    public function setReturnUrl($sUrl)
    {
        $this->_setField(self::RETURN_URL, $sUrl);

        return $this;
    }

    /**
     * Setter for order identification
     * (uniqueness of the order identification number must be provided by the merchant)
     *
     * @param string $sOrderIdent
     *
     * @return WirecardCEE_QMore_DataStorageClient
     */
    public function setOrderIdent($sOrderIdent)
    {
        $this->_setField(self::ORDER_IDENT, $sOrderIdent);

        return $this;
    }

    /**
     *
     * @param string $sStorageId
     *
     * @return WirecardCEE_QMore_DataStorageClient
     */
    public function setStorageId($sStorageId)
    {
        $this->_setField(self::STORAGE_ID, $sStorageId);

        return $this;
    }

    /**
     * setter for parameter iframeCssUrl
     *
     * @param $iframeCssUrl
     */
    public function setIframeCssUrl($iframeCssUrl)
    {
        $this->_setField(self::IFRAME_CSS_URL, $iframeCssUrl);
    }

    /**
     * setter for parameter showIssueDateFields
     *
     * @param $showIssueDateField
     */
    public function setCreditCardShowIssueDateField($showIssueDateField)
    {
        $this->_setField(self::CREDITCARD_SHOW_ISSUE_DATEFIELD, $showIssueDateField ? 'true' : 'false');
    }

    /**
     * setter for parameter showIssueNumberField
     *
     * @param $showIssueNumberField
     */
    public function setCreditCardShowIssueNumberField($showIssueNumberField)
    {
        $this->_setField(self::CREDITCARD_SHOW_ISSUE_NUMBERFIELD, $showIssueNumberField ? 'true' : 'false');
    }

    /**
     * setter for parameter showCardholderField
     *
     * @param $showCardholderField
     */
    public function setCreditCardShowCardholderNameField($showCardholderField)
    {
        $this->_setField(self::CREDITCARD_SHOW_CARDHOLDER_NAMEFIELD, $showCardholderField ? 'true' : 'false');
    }

    /**
     * setter for parameter showCvcField
     *
     * @param $showCvcField
     */
    public function setCreditCardShowCvcField($showCvcField)
    {
        $this->_setField(self::CREDITCARD_SHOW_CVC_FIELD, $showCvcField ? 'true' : 'false');
    }

    /**
     * setter for parameter creditcardPanPlaceholder
     *
     * @param $placeholder
     */
    public function setCreditCardPanPlaceholder($placeholder)
    {
        $this->_setField(self::CREDITCARD_PAN_PLACEHOLDER, $placeholder);
    }

    /**
     * setter for parameter creditcardCvcPlaceholder
     *
     * @param $placeholder
     */
    public function setCreditCardCvcPlaceholder($placeholder)
    {
        $this->_setField(self::CREDITCARD_CVC_PLACEHOLDER, $placeholder);
    }

    /**
     * setter for parameter creditcardCardholderNamePlaceholder
     *
     * @param $placeholder
     */
    public function setCreditCardCardholderNamePlaceholder($placeholder)
    {
        $this->_setField(self::CREDITCARD_CARDHOLDERNAME_PLACEHOLDER, $placeholder);
    }

    /**
     * setter for parameter creditcardIssueNumberPlaceholder
     *
     * @param $placeholder
     */
    public function setCreditCardCardIssueNumberPlaceholder($placeholder)
    {
        $this->_setField(self::CREDITCARD_ISSUENUMBER_PLACEHOLDER, $placeholder);
    }

    /**
     * setter for creditcardShowExpirationDatePlaceholder
     *
     * @param $showPlaceholder
     */
    public function setCreditCardShowExpirationDatePlaceholder($showPlaceholder)
    {
        $this->_setField(self::CREDITCARD_SHOW_EXPIRATIONDATE_PLACEHOLDER, $showPlaceholder ? 'true' : 'false');
    }

    /**
     * setter for creditcardShowIssueDatePlaceholder
     *
     * @param $showPlaceholder
     */
    public function setCreditCardShowIssueDatePlaceholder($showPlaceholder)
    {
        $this->_setField(self::CREDITCARD_SHOW_ISSUEDATE_PLACEHOLDER, $showPlaceholder ? 'true' : 'false');
    }

    /**
     * *******************
     * PROTECTED METHODS *
     * *******************
     */

    /**
     * @see WirecardCEE_Stdlib_Client_Request_Abstract::_getRequestUrl()
     * @return string
     */
    protected function _getRequestUrl()
    {
        return $this->oClientConfig->DATA_STORAGE_URL . '/init';
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
