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
 * @name WirecardCEE_Stdlib_Return_Success
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 * @subpackage Return
 * @version 3.0.0
 * @abstract
 */
abstract class WirecardCEE_Stdlib_Return_Success extends WirecardCEE_Stdlib_Return_ReturnAbstract {
    /**
     *
     * @var string
     */
    private $_secret;

    /**
     *
     * @var string
     */
    protected $_state = 'SUCCESS';

    /**
     *
     * @staticvar string
     * @internal
     */
    protected static $SECRET = 'secret';


    /**
     * Fingerprintorder field
     * @var string
     * @internal
     */
    protected static $FINGERPRINT_ORDER_FIELD = 'fingerprintOrderField';

    /**
     * creates an instance of an WirecardCEE_Stdlib_Return_Success object
     *
     * @param Array $returnData
     * @param string $secret
     */
    public function __construct(Array $returnData, $secret) {
        $this->_secret = (string) $secret;
        parent::__construct($returnData);

        $oFingerprintValidator = new WirecardCEE_Stdlib_Validate_Fingerprint(Array(
                self::$SECRET => $secret,
                self::$FINGERPRINT_ORDER_FIELD => 'responseFingerprintOrder',
        ));

        $oFingerprintValidator->setHashAlgorithm(WirecardCEE_Stdlib_Fingerprint::HASH_ALGORITHM_MD5);
        $oFingerprintValidator->setOrderType(WirecardCEE_Stdlib_Validate_Fingerprint::TYPE_DYNAMIC);

        $this->addValidator($oFingerprintValidator, 'responseFingerprint');
    }

    /**
     * getter for the return parameter amount
     *
     * @return string
     */
    public function getAmount() {
        return $this->amount;
    }

    /**
     * getter for the return parameter currency
     *
     * @return string
     */
    public function getCurrency() {
        return (string) $this->currency;
    }

    /**
     * getter for the return parameter paymentType
     *
     * @return string
     */
    public function getPaymentType() {
        return (string) $this->paymentType;
    }

    /**
     * getter for the return parameter financialInstitution
     *
     * @return string
     */
    public function getFinancialInstitution() {
        return (string) $this->financialInstitution;
    }

    /**
     * getter for the return parameter Language
     *
     * @return string
     */
    public function getLanguage() {
        return (string) $this->language;
    }

    /**
     * getter for the return parameter orderNumber
     *
     * @return string
     */
    public function getOrderNumber() {
        return $this->orderNumber;
    }

    /**
     * getter for the return parameter gatewayReferenceNumber
     *
     * @return string
     */
    public function getGatewayReferenceNumber() {
        return $this->gatewayReferenceNumber;
    }

    /**
     * getter for the return parameter gatewayContractNumber
     *
     * @return string
     */
    public function getGatewayContractNumber() {
        return $this->gatewayContractNumber;
    }

    /**
     * getter for the return parameter avsResponseCode
     *
     * @return string
     */
    public function getAvsResponseCode() {
        return $this->avsResponseCode;
    }

    /**
     * getter for the return parameter avsResponseMessage
     *
     * @return string
     */
    public function getAvsResponseMessage() {
        return (string) $this->avsResponseMessage;
    }
}