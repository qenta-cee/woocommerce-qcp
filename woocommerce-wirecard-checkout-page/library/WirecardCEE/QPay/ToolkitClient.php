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
 * @name WirecardCEE_QPay_ToolkitClient
 * @category WirecardCEE
 * @package WirecardCEE_QPay
 * @version 3.0.0
 *
 * @important All the toolkit functions have to call _setField before setting _fingerprintOrder
 */
class WirecardCEE_QPay_ToolkitClient extends WirecardCEE_Stdlib_Client_ClientAbstract {

    /**
     * Toolkit password
     * @var string
     */
    const TOOLKIT_PASSWORD         = 'toolkitPassword';

    /**
     * Payment number
     * @var string
     */
    const PAYMENT_NUMBER         = 'paymentNumber';

    /**
     * Credit number
     * @var string
     */
    const CREDIT_NUMBER         = 'creditNumber';

    /**
     * Source order number
     * @var string
     */
    const SOURCE_ORDER_NUMBER     = 'sourceOrderNumber';

    /**
     * Command
     * @var string
     */
    const COMMAND                 = 'command';

    /**
     * Approve reversal command
     * @staticvar string
     * @internal
     */
    protected static $COMMAND_APPROVE_REVERSAL     = 'approveReversal';

    /**
     * Deposit command
     * @staticvar string
     * @internal
     */
    protected static $COMMAND_DEPOSIT             = 'deposit';

    /**
     * Deposit reversal command
     * @staticvar string
     * @internal
     */
    protected static $COMMAND_DEPOSIT_REVERSAL     = 'depositReversal';

    /**
     * Get order details command
     * @staticvar string
     * @internal
     */
    protected static $COMMAND_GET_ORDER_DETAILS = 'getOrderDetails';

    /**
     * Recur payment command
     * @staticvar string
     * @internal
     */
    protected static $COMMAND_RECUR_PAYMENT     = 'recurPayment';

    /**
     * Refund command
     * @staticvar string
     * @internal
     */
    protected static $COMMAND_REFUND             = 'refund';

    /**
     * Refund reversal command
     * @staticvar string
     * @internal
     */
    protected static $COMMAND_REFUND_REVERSAL     = 'refundReversal';

    /**
     * using FIXED fingerprint order (0 = dynamic, 1 = fixed)
     * @var int
     */
    protected $_fingerprintOrderType = 1;

    /**
     * Creates an instance of WirecardCEE_QPay_ToolkitClient object.
     * used for toolkit operations.
     *
     * @param array $aConfig
     */
    public function __construct(Array $aConfig = null) {
        $this->_fingerprintOrder = new WirecardCEE_Stdlib_FingerprintOrder();

        if(is_null($aConfig)) {
            $aConfig = WirecardCEE_QPay_Module::getConfig();
        }

        if (isset($aConfig['WirecardCEEQPayConfig'])) {
            // we only need the WirecardCEEQPayConfig here
            $aConfig = $aConfig['WirecardCEEQPayConfig'];
        }

        // let's store configuration details in internal objects
        $this->oUserConfig = new Zend_Config($aConfig);
        $this->oClientConfig = new Zend_Config(WirecardCEE_QPay_Module::getClientConfig());

        // now let's check if the CUSTOMER_ID, SHOP_ID, LANGUAGE and SECRET
        // exist in $this->oUserConfig object that we created from config array
        $sCustomerId =         isset($this->oUserConfig->CUSTOMER_ID)         ? trim($this->oUserConfig->CUSTOMER_ID)     : null;
        $sShopId =             isset($this->oUserConfig->SHOP_ID)             ? trim($this->oUserConfig->SHOP_ID)         : null;
        $sLanguage =         isset($this->oUserConfig->LANGUAGE)         ? trim($this->oUserConfig->LANGUAGE)         : null;
        $sSecret =             isset($this->oUserConfig->SECRET)             ? trim($this->oUserConfig->SECRET)             : null;
        $sToolkitPassword = isset($this->oUserConfig->TOOLKIT_PASSWORD) ? trim($this->oUserConfig->TOOLKIT_PASSWORD): null;

        // If not throw the InvalidArgumentException exception!
        if (empty($sCustomerId) || is_null($sCustomerId)) {
            throw new WirecardCEE_QPay_Exception_InvalidArgumentException(sprintf('CUSTOMER_ID passed to %s is invalid.', __METHOD__));
        }

        if (empty($sLanguage) || is_null($sLanguage)) {
            throw new WirecardCEE_QPay_Exception_InvalidArgumentException(sprintf('LANGUAGE passed to %s is invalid.', __METHOD__));
        }

        if (empty($sSecret) || is_null($sSecret)) {
            throw new WirecardCEE_QPay_Exception_InvalidArgumentException(sprintf('SECRET passed to %s is invalid.', __METHOD__));
        }

        if (empty($sToolkitPassword) || is_null($sToolkitPassword)) {
            throw new WirecardCEE_QPay_Exception_InvalidArgumentException(sprintf('TOOLKIT PASSWORD passed to %s is invalid.', __METHOD__));
        }

        // we're using md5 for hash-ing
        WirecardCEE_Stdlib_Fingerprint::setHashAlgorithm(WirecardCEE_Stdlib_Fingerprint::HASH_ALGORITHM_MD5);

        // everything ok! let's set the fields
        $this->_setField(self::CUSTOMER_ID, $sCustomerId);
        $this->_setField(self::SHOP_ID, $sShopId);
        $this->_setField(self::LANGUAGE, $sLanguage);
        $this->_setField(self::TOOLKIT_PASSWORD, $sToolkitPassword);
        $this->_setSecret($sSecret);
    }

    /**
     * Refund
     *
     * @throws WirecardCEE_Stdlib_Client_Exception_InvalidResponseException
     * @return WirecardCEE_QPay_Response_Toolkit_Refund
     */
    public function refund($iOrderNumber, $iAmount, $sCurrency) {
        $this->_requestData[self::COMMAND] = self::$COMMAND_REFUND;

        $this->_setField(self::ORDER_NUMBER, $iOrderNumber);
        $this->_setField(self::AMOUNT, $iAmount);
        $this->_setField(self::CURRENCY, strtoupper($sCurrency));

        $this->_fingerprintOrder->setOrder(Array(
                self::CUSTOMER_ID,
                self::SHOP_ID,
                self::TOOLKIT_PASSWORD,
                self::SECRET,
                self::COMMAND,
                self::LANGUAGE,
                self::ORDER_NUMBER,
                self::AMOUNT,
                self::CURRENCY
        ));

        return new WirecardCEE_QPay_Response_Toolkit_Refund($this->_send());
    }

    /**
     * Refund reversal
     *
     * @throws WirecardCEE_Stdlib_Client_Exception_InvalidResponseException
     * @return WirecardCEE_QPay_Response_Toolkit_RefundReversal
     */
    public function refundReversal($iOrderNumber, $iCreditNumber) {
        $this->_requestData[self::COMMAND] = self::$COMMAND_REFUND_REVERSAL;

        $this->_setField(self::ORDER_NUMBER, $iOrderNumber);
        $this->_setField(self::CREDIT_NUMBER, $iCreditNumber);

        $this->_fingerprintOrder->setOrder(Array(
                self::CUSTOMER_ID,
                self::SHOP_ID,
                self::TOOLKIT_PASSWORD,
                self::SECRET,
                self::COMMAND,
                self::LANGUAGE,
                self::ORDER_NUMBER,
                self::CREDIT_NUMBER
        ));
        return new WirecardCEE_QPay_Response_Toolkit_RefundReversal($this->_send());
    }

    /**
     * Recur payment
     *
     * @throws WirecardCEE_Stdlib_Client_Exception_InvalidResponseException
     * @return WirecardCEE_QPay_Response_Toolkit_RecurPayment
     */
    public function recurPayment($iSourceOrderNumber, $iAmount, $sCurrency, $sOrderDescription, $iOrderNumber = null, $bDepositFlag = null) {
        $this->_requestData[self::COMMAND] = self::$COMMAND_RECUR_PAYMENT;

        $this->_setField(self::SOURCE_ORDER_NUMBER, $iSourceOrderNumber);
        $this->_setField(self::AMOUNT, $iAmount);
        $this->_setField(self::CURRENCY, strtoupper($sCurrency));

        $this->_setField(self::ORDER_DESCRIPTION, $sOrderDescription);

        if(!is_null($iOrderNumber)) {
            $this->_setField(self::ORDER_NUMBER, $iOrderNumber);
        }

        if(!is_null($bDepositFlag)) {
            $this->_setField(self::AUTO_DEPOSIT, $bDepositFlag ? self::$BOOL_TRUE : self::$BOOL_FALSE);
        }


        $this->_fingerprintOrder->setOrder(Array(
                self::CUSTOMER_ID,
                self::SHOP_ID,
                self::TOOLKIT_PASSWORD,
                self::SECRET,
                self::COMMAND,
                self::LANGUAGE,
                self::ORDER_NUMBER,
                self::SOURCE_ORDER_NUMBER,
                self::AUTO_DEPOSIT,
                self::ORDER_DESCRIPTION,
                self::AMOUNT,
                self::CURRENCY
        ));
        return new WirecardCEE_QPay_Response_Toolkit_RecurPayment($this->_send());
    }

    /**
     * Returns order details
     *
     * @param int|string $iOrderNumber
     * @throws WirecardCEE_Stdlib_Client_Exception_InvalidResponseException
     * @return WirecardCEE_QPay_Response_Toolkit_GetOrderDetails
     */
    public function getOrderDetails($iOrderNumber) {
        $this->_requestData[self::COMMAND] = self::$COMMAND_GET_ORDER_DETAILS;
        $this->_setField(self::ORDER_NUMBER, $iOrderNumber);

        $this->_fingerprintOrder->setOrder(Array(
                self::CUSTOMER_ID,
                self::SHOP_ID,
                self::TOOLKIT_PASSWORD,
                self::SECRET,
                self::COMMAND,
                self::LANGUAGE,
                self::ORDER_NUMBER
        ));

        return new WirecardCEE_QPay_Response_Toolkit_GetOrderDetails($this->_send());
    }

    /**
     * Approve reversal
     *
     * @throws WirecardCEE_Stdlib_Client_Exception_InvalidResponseException
     * @return WirecardCEE_QPay_Response_Toolkit_ApproveReversal
     */
    public function approveReversal($iOrderNumber) {
        $this->_requestData[self::COMMAND] = self::$COMMAND_APPROVE_REVERSAL;
        $this->_setField(self::ORDER_NUMBER, $iOrderNumber);

        $this->_fingerprintOrder->setOrder(Array(
                self::CUSTOMER_ID,
                self::SHOP_ID,
                self::TOOLKIT_PASSWORD,
                self::SECRET,
                self::COMMAND,
                self::LANGUAGE,
                self::ORDER_NUMBER
        ));
        return new WirecardCEE_QPay_Response_Toolkit_ApproveReversal($this->_send());
    }

    /**
     * Deposit
     *
     * @throws WirecardCEE_Stdlib_Client_Exception_InvalidResponseException
     * @return WirecardCEE_QPay_Response_Toolkit_Deposit
     */
    public function deposit($iOrderNumber, $iAmount, $sCurrency) {
        $this->_requestData[self::COMMAND] = self::$COMMAND_DEPOSIT;

        $this->_setField(self::ORDER_NUMBER, $iOrderNumber);
        $this->_setField(self::AMOUNT, $iAmount);
        $this->_setField(self::CURRENCY, strtoupper($sCurrency));

        $this->_fingerprintOrder->setOrder(Array(
                self::CUSTOMER_ID,
                self::SHOP_ID,
                self::TOOLKIT_PASSWORD,
                self::SECRET,
                self::COMMAND,
                self::LANGUAGE,
                self::ORDER_NUMBER,
                self::AMOUNT,
                self::CURRENCY
        ));
        return new WirecardCEE_QPay_Response_Toolkit_Deposit($this->_send());
    }

    /**
     * Deposit reversal
     *
     * @throws WirecardCEE_Stdlib_Client_Exception_InvalidResponseException
     * @return WirecardCEE_QPay_Response_Toolkit_DepositReversal
     */
    public function depositReversal($iOrderNumber, $iPaymentNumber) {
        $this->_requestData[self::COMMAND] = self::$COMMAND_DEPOSIT_REVERSAL;

        $this->_setField(self::ORDER_NUMBER, $iOrderNumber);
        $this->_setField(self::PAYMENT_NUMBER, $iPaymentNumber);

        $this->_fingerprintOrder->setOrder(Array(
                self::CUSTOMER_ID,
                self::SHOP_ID,
                self::TOOLKIT_PASSWORD,
                self::SECRET,
                self::COMMAND,
                self::LANGUAGE,
                self::ORDER_NUMBER,
                self::PAYMENT_NUMBER
        ));
        return new WirecardCEE_QPay_Response_Toolkit_DepositReversal($this->_send());
    }

    /**
     * *******************
     * PROTECTED METHODS *
     * *******************
     */

    /**
     *
     * @see WirecardCEE_Stdlib_Client_ClientAbstract::_getRequestUrl()
     * @return string
     */
    protected function _getRequestUrl() {
        return (string) $this->oClientConfig->TOOLKIT_URL;
    }

    /**
     * Returns the user agent string
     * @return string
     */
    protected function _getUserAgent() {
        return "{$this->oClientConfig->MODULE_NAME};{$this->oClientConfig->MODULE_VERSION}";
    }
}