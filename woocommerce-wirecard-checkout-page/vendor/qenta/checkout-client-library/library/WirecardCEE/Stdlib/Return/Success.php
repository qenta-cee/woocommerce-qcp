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
 * @name WirecardCEE_Stdlib_Return_Success
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 * @subpackage Return
 * @abstract
 */
abstract class WirecardCEE_Stdlib_Return_Success extends WirecardCEE_Stdlib_Return_ReturnAbstract
{
    /**
     *
     * @var string
     */
    protected $_secret;

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
     *
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
    public function __construct(
        array $returnData,
        $secret,
        $hashAlgo = WirecardCEE_Stdlib_Fingerprint::HASH_ALGORITHM_HMAC_SHA512
    ) {
        $this->_secret = (string) $secret;
        parent::__construct($returnData);

        $oFingerprintValidator = new WirecardCEE_Stdlib_Validate_Fingerprint(Array(
            self::$SECRET => $secret,
            self::$FINGERPRINT_ORDER_FIELD => 'responseFingerprintOrder',
        ));

        $oFingerprintValidator->setHashAlgorithm($hashAlgo);
        $oFingerprintValidator->setOrderType(WirecardCEE_Stdlib_Validate_Fingerprint::TYPE_DYNAMIC);

        $this->addValidator($oFingerprintValidator, 'responseFingerprint');
    }

    /**
     * getter for the return parameter amount
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * getter for the return parameter currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return (string) $this->currency;
    }

    /**
     * getter for the return parameter paymentType
     *
     * @return string
     */
    public function getPaymentType()
    {
        return (string) $this->paymentType;
    }

    /**
     * getter for the return parameter financialInstitution
     *
     * @return string
     */
    public function getFinancialInstitution()
    {
        return (string) $this->financialInstitution;
    }

    /**
     * getter for the return parameter Language
     *
     * @return string
     */
    public function getLanguage()
    {
        return (string) $this->language;
    }

    /**
     * getter for the return parameter orderNumber
     *
     * @return string
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * getter for the return parameter gatewayReferenceNumber
     *
     * @return string
     */
    public function getGatewayReferenceNumber()
    {
        return $this->gatewayReferenceNumber;
    }

    /**
     * getter for the return parameter gatewayContractNumber
     *
     * @return string
     */
    public function getGatewayContractNumber()
    {
        return $this->gatewayContractNumber;
    }

    /**
     * getter for the return parameter avsResponseCode
     *
     * @return string
     */
    public function getAvsResponseCode()
    {
        return $this->avsResponseCode;
    }

    /**
     * getter for the return parameter avsResponseMessage
     *
     * @return string
     */
    public function getAvsResponseMessage()
    {
        return (string) $this->avsResponseMessage;
    }
}