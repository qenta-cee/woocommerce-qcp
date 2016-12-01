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
 * @name WirecardCEE_Stdlib_Validate_Fingerprint
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 * @subpackage Validate
 */
class WirecardCEE_Stdlib_Validate_Fingerprint extends WirecardCEE_Stdlib_Validate_ValidateAbstract
{

    /**
     * Fingeprint order
     *
     * @var WirecardCEE_Stdlib_FingerprintOrder
     */
    protected $fingerprintOrder;

    /**
     * Type of fingerprint order
     *
     * @var string
     */
    protected $fingerprintOrderType = self::TYPE_FIXED;

    /**
     * Hash algorithm
     *
     * @var string
     */
    protected $hashAlgorithm = WirecardCEE_Stdlib_Fingerprint::HASH_ALGORITHM_SHA512;

    /**
     * Secret
     *
     * @var string
     */
    protected $secret = '';

    /**
     * Mandatory fields internal holder
     *
     * @var array
     * @internal
     */
    protected $_mandatoryFields = Array();

    /**
     * Fingerprint order field
     *
     * @var string
     */
    protected $fingerprintOrderField = '';

    /**
     * Const: Dynamic type
     *
     * @var string
     */
    const TYPE_DYNAMIC = 'dynamic';

    /**
     * Const: Fixed type
     *
     * @var string
     */
    const TYPE_FIXED = 'fixed';

    /**
     * Const: Invalid
     *
     * @var string
     */
    const INVALID = 'invalid';

    /**
     * Const: Invalid Length
     *
     * @var string
     */
    const INVALID_LENGTH = 'invalidLength';

    /**
     * Const: Fingerprint order missing
     *
     * @var string
     */
    const FINGERPRINTORDER_MISSING = 'fingerprintorderMissing';

    /**
     * Message templates
     *
     * @var array
     * @internal
     */
    protected $_messageTemplates = array(
        self::INVALID                  => "Given fingerprint does not match calculated one.",
        self::INVALID_LENGTH           => "'%value%' has invalid length for hash algorithm %hash%.",
        self::FINGERPRINTORDER_MISSING => 'Parameter fingerprintOrder is missing'
    );

    /**
     * Message variables
     *
     * @var array
     * @internal
     */
    protected $_messageVariables = array(
        'hash' => 'hashAlgorithm'
    );

    /**
     * Constructor
     *
     * @param array $options - optional
     */
    public function __construct($options = array())
    {
        $this->fingerprintOrder = new WirecardCEE_Stdlib_FingerprintOrder();

        if ($options instanceof WirecardCEE_Stdlib_Config) {
            $options = $options->toArray();
        }

        if (!empty( $options['fingerprintOrder'] )) {
            $this->setOrder($options['fingerprintOrder']);
        }

        if (!empty( $options['fingerprintOrderField'] )) {
            $this->setFingerprintOrderField($options['fingerprintOrderField']);
        }
        if (!empty( $options['hashAlgorithm'] )) {
            $this->setHashAlgorithm($options['hashAlgorithm']);
        }
        if (!empty( $options['orderType'] )) {
            $this->setOrderType($options['orderType']);
        }
        if (!empty( $options['secret'] )) {
            $this->setSecret($options['secret']);
        }
    }

    /**
     * Sets the fingerprint order field
     *
     * @param string $sFingerprintOrderField
     *
     * @return WirecardCEE_Stdlib_Validate_Fingerprint
     */
    public function setFingerprintOrderField($sFingerprintOrderField)
    {
        $this->fingerprintOrderField = strtolower($sFingerprintOrderField);

        return $this;
    }

    /**
     * Sets the ordere type
     *
     * @param string $orderType
     *
     * @return WirecardCEE_Stdlib_Validate_Fingerprint
     */
    public function setOrderType($orderType)
    {
        $this->fingerprintOrderType = (string) $orderType;

        return $this;
    }

    /**
     * Sets the fingeprint order
     *
     * @param string|array $order
     *
     * @return WirecardCEE_Stdlib_Validate_Fingerprint
     */
    public function setOrder($order)
    {
        $this->fingerprintOrder->setOrder($order);

        return $this;
    }

    /**
     * Hash algorithm setter
     *
     * @param string $hashAlgorithm
     *
     * @return WirecardCEE_Stdlib_Validate_Fingerprint
     */
    public function setHashAlgorithm($hashAlgorithm)
    {
        $this->hashAlgorithm = (string) $hashAlgorithm;
        WirecardCEE_Stdlib_Fingerprint::setHashAlgorithm($hashAlgorithm);

        return $this;
    }

    /**
     * Secret setter
     *
     * @param string $secret
     *
     * @return WirecardCEE_Stdlib_Validate_Fingerprint
     */
    public function setSecret($secret)
    {
        $this->secret = (string) $secret;

        return $this;
    }

    /**
     * Add madatory field
     *
     * @param string $mandatoryField
     *
     * @return WirecardCEE_Stdlib_Validate_Fingerprint
     */
    public function addMandatoryField($mandatoryField)
    {
        if (!in_array((string) $mandatoryField, $this->_mandatoryFields)) {
            $this->_mandatoryFields[] = (string) $mandatoryField;
        }

        return $this;
    }

    /**
     * Sets mandatory fields
     *
     * @param array $mandatoryFields
     *
     * @return WirecardCEE_Stdlib_Validate_Fingerprint
     */
    public function setMandatoryFields(Array $mandatoryFields)
    {
        $this->_mandatoryFields = $mandatoryFields;

        return $this;
    }

    /**
     * Is validator check valid?
     *
     * @see WirecardCEE_Stdlib_Validate_Interface::isValid()
     */
    public function isValid($value, $context = null)
    {
        $context = array_change_key_case($context, CASE_LOWER);

        switch ($this->hashAlgorithm) {
            case WirecardCEE_Stdlib_Fingerprint::HASH_ALGORITHM_HMAC_SHA512:
            case WirecardCEE_Stdlib_Fingerprint::HASH_ALGORITHM_SHA512:
                $stringLength = 128;
                break;
            case WirecardCEE_Stdlib_Fingerprint::HASH_ALGORITHM_MD5:
                $stringLength = 32;
                break;
            default:
                throw new WirecardCEE_Stdlib_Exception_UnexpectedValueException(sprintf("Used hash algorithm '%s' is not supported. MD5, SHA512, or HMAC_SHA512 are currently supported.",
                    $this->hashAlgorithm));
                break;
        }

        if (strlen($value) != $stringLength) {
            return false;
        }

        if ($this->fingerprintOrderType == self::TYPE_FIXED) {
            $fingerprintOrder = $this->fingerprintOrder;
        } else {
            if (array_key_exists($this->fingerprintOrderField, $context)) {
                $fingerprintOrder = new WirecardCEE_Stdlib_FingerprintOrder(strtolower($context[$this->fingerprintOrderField]));
            } else {
                $this->_error(self::FINGERPRINTORDER_MISSING);

                return false;
            }
        }

        $fingerprintOrder->setOrder(array_map('strtolower', $this->fingerprintOrder->__toArray()));
        if (!in_array('secret', $fingerprintOrder->__toArray())) {
            throw new WirecardCEE_Stdlib_Exception_UnexpectedValueException();
        }

        $fingerprintFields = Array();
        foreach ($fingerprintOrder as $fingerprintFieldKey) {
            if ($fingerprintFieldKey == 'secret') {
                $fingerprintFields[$fingerprintFieldKey] = $this->secret;
            } else {
                $fingerprintFields[$fingerprintFieldKey] = isset( $context[$fingerprintFieldKey] ) ? $context[$fingerprintFieldKey] : '';
            }
        }

        if (!WirecardCEE_Stdlib_Fingerprint::compare($fingerprintFields, $fingerprintOrder, $value)) {
            $this->_error(self::INVALID);

            return false;
        }

        return true;
    }
}

?>