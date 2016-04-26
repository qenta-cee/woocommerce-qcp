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
 * @name WirecardCEE_Stdlib_Return_ReturnAbstract
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 * @subpackage Return
 * @version 3.0.0
 * @abstract
 */
abstract class WirecardCEE_Stdlib_Return_ReturnAbstract {
    /**
     * Return data holder
     * @var Array
     * @internal
     */
    protected $_returnData = Array();

    /**
     * Validators holder
     * @var Zend_Validate_Abstract[]
     * @internal
     */
    protected $_validators = Array();

    /**
     * State
     * @var string
     * @internal
     */
    protected $_state = '';

    /**
     * Contructor
     *
     * @param Array $returnData
     */
    public function __construct($returnData) {
        $this->_returnData = $returnData;
    }

    /**
     * Validate function
     *
     * @return boolean
     */
    public function validate() {
        // If there are no validators in the array then the validation is "successfull"
        if(!count($this->_validators)) {
            return true;
        }

        $_bValid = true;

        // Iterate thru all the validators and validate every one of them
        foreach($this->_validators as $param => $aValidator) {
            foreach($aValidator as $oValidator) {
                $param = (string) $param;

                if(!isset($this->_returnData[$param])) {
                    throw new Exception(sprintf("No key '{$param}' found in \$this->_returnData array. Thrown in %s on line %s.", __METHOD__, __LINE__));
                }

                $bValidatorResult = $oValidator->isValid($this->_returnData[$param], $this->_returnData);

                $_bValid = $_bValid && $bValidatorResult;
            }
        }

        return (bool) $_bValid;
    }

    /**
     * Adds the validator
     *
     * @param Zend_Validate_Abstract $oValidator
     * @param string $param
     * @return WirecardCEE_Stdlib_Return_ReturnAbstract
     */
    public function addValidator(Zend_Validate_Abstract $oValidator, $param) {
        $this->_validators[(string) $param][] = $oValidator;
        return $this;
    }

    /**
     * getter for paymentState
     *
     * @return string
     */
    public function getPaymentState() {
        return (string) $this->_state;
    }

    /**
     * magic getter method
     *
     * @param string $name
     * @return string
     */
    public function __get($name) {
        $name = (string) $name;
        return (string) array_key_exists($name, $this->_returnData) ? $this->_returnData[$name] : '';
    }

    /**
     * getter for filtered return data.
     *
     * @return string[]
     */
    public function getReturned() {
        // noone needs the responseFingerprintOrder and responseFingerprint in
        // the shop.
        if (array_key_exists('responseFingerprintOrder', $this->_returnData) && array_key_exists('responseFingerprint', $this->_returnData)) {
            unset($this->_returnData['responseFingerprintOrder']);
            unset($this->_returnData['responseFingerprint']);
        }

        return $this->_returnData;
    }
}