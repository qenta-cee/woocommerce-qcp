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
 * @name WirecardCEE_Stdlib_Return_ReturnAbstract
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 * @subpackage Return
 * @abstract
 */
abstract class WirecardCEE_Stdlib_Return_ReturnAbstract
{
    /**
     * Return data holder
     *
     * @var array
     * @internal
     */
    protected $_returnData = Array();

    /**
     * Validators holder
     *
     * @var WirecardCEE_Stdlib_Validate_ValidateAbstract[]
     * @internal
     */
    protected $_validators = Array();

    /**
     * State
     *
     * @var string
     * @internal
     */
    protected $_state = '';

    /**
     * Contructor
     *
     * @param array $returnData
     */
    public function __construct($returnData)
    {
        $this->_returnData = $returnData;
    }

    /**
     * Validate function
     *
     * @return bool
     * @throws Exception
     */
    public function validate()
    {
        // If there are no validators in the array then the validation is "successfull"
        if (!count($this->_validators)) {
            return true;
        }

        $_bValid = true;

        // Iterate thru all the validators and validate every one of them
        foreach ($this->_validators as $param => $aValidator) {
            foreach ($aValidator as $oValidator) {
                /** @var WirecardCEE_Stdlib_Validate_ValidateAbstract $oValidator */
                $param = (string) $param;

                if (!isset( $this->_returnData[$param] )) {
                    throw new Exception(sprintf("No key '{$param}' found in \$this->_returnData array. Thrown in %s on line %s.",
                        __METHOD__, __LINE__));
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
     * @param WirecardCEE_Stdlib_Validate_ValidateAbstract $oValidator
     * @param string $param
     *
     * @return WirecardCEE_Stdlib_Return_ReturnAbstract
     */
    public function addValidator(WirecardCEE_Stdlib_Validate_ValidateAbstract $oValidator, $param)
    {
        $this->_validators[(string) $param][] = $oValidator;

        return $this;
    }

    /**
     * getter for paymentState
     *
     * @return string
     */
    public function getPaymentState()
    {
        return (string) $this->_state;
    }

    /**
     * magic getter method
     *
     * @param string $name
     *
     * @return string
     */
    public function __get($name)
    {
        $name = (string) $name;

        return (string) array_key_exists($name, $this->_returnData) ? $this->_returnData[$name] : '';
    }

    /**
     * getter for filtered return data.
     *
     * @return string[]
     */
    public function getReturned()
    {
        $ret = $this->_returnData;

        // noone needs the responseFingerprintOrder and responseFingerprint in the shop.
        if (array_key_exists('responseFingerprintOrder', $ret)) {
            unset( $ret['responseFingerprintOrder'] );
        }

        if (array_key_exists('responseFingerprint', $ret)) {
            unset( $ret['responseFingerprint'] );
        }

        return $ret;
    }
}