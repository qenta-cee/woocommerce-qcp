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
 * @name WirecardCEE_Stdlib_Validate_Fingerprint
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 * @subpackage Validate
 * @version 3.0.0
 */
class WirecardCEE_Stdlib_Validate_Fingerprint extends Zend_Validate_Abstract {

    /**
     * Fingeprint order
     * @var WirecardCEE_Stdlib_FingerprintOrder
     */
    protected $fingerprintOrder;

    /**
     * Type of fingerprint order
     * @var string
     */
    protected $fingerprintOrderType = self::TYPE_FIXED;

    /**
     * Hash algorithm
     * @var string
     */
    protected $hashAlgorithm = WirecardCEE_Stdlib_Fingerprint::HASH_ALGORITHM_SHA512;

    /**
     * Secret
     * @var string
     */
    protected $secret = '';

    /**
     * Mandatory fields internal holder
     * @var array
     * @internal
     */
    protected $_mandatoryFields = Array();

    /**
     * Fingerprint order field
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
            self::INVALID => "Given fingerprint does not match calculated one.",
            self::INVALID_LENGTH => "'%value%' has invalid length for hash algorithm %hash%.",
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
     * @param Array $options - optional
     */
    public function __construct($options = array()) {
        $this->fingerprintOrder = new WirecardCEE_Stdlib_FingerprintOrder();

        if($options instanceof Zend_Config) {
            $options = $options->toArray();
        }

        if(!empty($options['fingerprintOrder'])) {
            $this->setOrder($options['fingerprintOrder']);
        }

        if(!empty($options['fingerprintOrderField'])) {
            $this->setFingerprintOrderField($options['fingerprintOrderField']);
        }
        if(!empty($options['hashAlgorithm'])) {
            $this->setHashAlgorithm($options['hashAlgorithm']);
        }
        if(!empty($options['orderType'])) {
            $this->setOrderType($options['orderType']);
        }
        if(!empty($options['secret'])) {
            $this->setSecret($options['secret']);
        }
    }

    /**
     * Sets the fingerprint order field
     * @param string $sFingerprintOrderField
     * @return WirecardCEE_Stdlib_Validate_Fingerprint
     */
    public function setFingerprintOrderField($sFingerprintOrderField) {
        $this->fingerprintOrderField = strtolower($sFingerprintOrderField);
        return $this;
    }

    /**
     * Sets the ordere type
     * @param string $orderType
     * @return WirecardCEE_Stdlib_Validate_FingerprintValidator
     */
    public function setOrderType($orderType) {
        $this->fingerprintOrderType = (string) $orderType;
        return $this;
    }

    /**
     * Sets the fingeprint order
     * @param string|array $order
     * @return WirecardCEE_Stdlib_Validate_FingerprintValidator
     */
    public function setOrder($order) {
        $this->fingerprintOrder->setOrder($order);
        return $this;
    }

    /**
     * Hash algorithm setter
     * @param string $hashAlgorithm
     * @return WirecardCEE_Stdlib_Validate_FingerprintValidator
     */
    public function setHashAlgorithm($hashAlgorithm) {
        $this->hashAlgorithm = (string) $hashAlgorithm;
        WirecardCEE_Stdlib_Fingerprint::setHashAlgorithm($hashAlgorithm);
        return $this;
    }

    /**
     * Secret setter
     * @param string $secret
     * @return WirecardCEE_Stdlib_Validate_FingerprintValidator
     */
    public function setSecret($secret) {
        $this->secret = (string) $secret;
        return $this;
    }

    /**
     * Add madatory field
     * @param string $mandatoryField
     * @return WirecardCEE_Stdlib_Validate_FingerprintValidator
     */
    public function addMandatoryField($mandatoryField) {
        if(!in_array((string) $mandatoryField, $this->_mandatoryFields)) {
            $this->_mandatoryFields[] = (string) $mandatoryField;
        }
        return $this;
    }

    /**
     * Sets mandatory fields
     * @param array $mandatoryFields
     * @return WirecardCEE_Stdlib_Validate_FingerprintValidator
     */
    public function setMandatoryFields(Array $mandatoryFields) {
        $this->_mandatoryFields = $mandatoryFields;
        return $this;
    }

    /**
     * Is validator check valid?
     * @see Zend_Validate_Interface::isValid()
     */
    public function isValid($value, $context = null) {
        $context = array_change_key_case($context, CASE_LOWER);

        switch($this->hashAlgorithm) {
            case WirecardCEE_Stdlib_Fingerprint::HASH_ALGORITHM_SHA512:
                $stringLength = 128;
                break;
            case WirecardCEE_Stdlib_Fingerprint::HASH_ALGORITHM_MD5:
                $stringLength = 32;
                break;
            default:
                throw new WirecardCEE_Stdlib_Exception_UnexpectedValueException(sprintf("Used hash algorithm '%s' is not supported. MD5 or SHA512 are currently supported.", $this->hashAlgorithm));
                break;
        }

        if(strlen($value) != $stringLength) {
            return false;
        }

        if($this->fingerprintOrderType == self::TYPE_FIXED) {
            $fingerprintOrder = $this->fingerprintOrder;
        }
        else {
            if(array_key_exists($this->fingerprintOrderField, $context)) {
                $fingerprintOrder = new WirecardCEE_Stdlib_FingerprintOrder(strtolower($context[$this->fingerprintOrderField]));
            }
            else {
                $this->_error(self::FINGERPRINTORDER_MISSING);
                return false;
            }
        }

        $fingerprintOrder->setOrder(array_map('strtolower', $this->fingerprintOrder->__toArray()));

        $fingerprintFields = Array();
        foreach($fingerprintOrder as $fingerprintFieldKey) {
            if($fingerprintFieldKey == 'secret') {
                $fingerprintFields[$fingerprintFieldKey] = $this->secret;
            }
            else {
                $fingerprintFields[$fingerprintFieldKey] = isset($context[$fingerprintFieldKey]) ? $context[$fingerprintFieldKey] : '';
            }
        }

        if(!WirecardCEE_Stdlib_Fingerprint::compare($fingerprintFields, $fingerprintOrder, $value)) {
            $this->_error(self::INVALID);
            return false;
        }

        return true;
    }
}

?>