<?php
/*
 * Die vorliegende Software ist Eigentum von Wirecard CEE und daher vertraulich
 * zu behandeln. Jegliche Weitergabe an dritte, in welcher Form auch immer, ist
 * unzulaessig. Software & Service Copyright (C) by Wirecard Central Eastern
 * Europe GmbH, FB-Nr: FN 195599 x, http://www.wirecard.at
 */
/**
 * Factory method for returned params validators
 *
 * @name WirecardCEE_QPay_ReturnFactory
 * @category WirecardCEE
 * @package WirecardCEE_QPay
 * @version 3.0.0
 */
class WirecardCEE_QPay_ReturnFactory extends WirecardCEE_Stdlib_ReturnFactoryAbstract {
    /**
     * no initiation allowed.
     */
    private function __construct() {}


    /**
     * creates an Return instance (Cancel, Failure, Success...)
     *
     * @param array $return - returned post data
     * @param type $secret - QPAY secret
     * @return WirecardCEE_QPay_Return
     */
    public static function getInstance($return, $secret) {
        if (!is_array($return)) {
            $return = WirecardCEE_Stdlib_SerialApi::decode($return);
        }

        if (array_key_exists('paymentState', $return)) {
            return self::_getInstance($return, $secret);
        }
        else {
            throw new WirecardCEE_QPay_Exception_InvalidResponseException('Invalid response from QPAY. Paymentstate is missing.');
        }
    }

    /***************************
     *       PROTECTED METHODS    *
     ***************************/

    /**
     *
     * @param array $return
     * @param string $secret
     * @throws WirecardCEE_QPay_Exception_InvalidResponseException
     * @return Mixed <WirecardCEE_QPay_Return_Success, WirecardCEE_QPay_Return_Success_CreditCard, WirecardCEE_QPay_Return_Success_PayPal, WirecardCEE_QPay_Return_Success_Sofortueberweisung, WirecardCEE_QPay_Return_Success_Ideal>|WirecardCEE_QPay_Return_Cancel|WirecardCEE_QPay_Return_Failure
     */
    protected static function _getInstance($return, $secret) {
        switch(strtoupper($return['paymentState'])) {
            case self::STATE_SUCCESS:
                return self::_getSuccessInstance($return, $secret);
                break;
            case self::STATE_CANCEL:
                return new WirecardCEE_QPay_Return_Cancel($return);
                break;
            case self::STATE_FAILURE:
                return new WirecardCEE_QPay_Return_Failure($return);
                break;
            case parent::STATE_PENDING:
                return new WirecardCEE_QPay_Return_Pending($return, $secret);
                break;
            default:
                throw new WirecardCEE_QPay_Exception_InvalidResponseException('Invalid response from QPAY. Unexpected paymentState: ' . $return['paymentState']);
                break;
        }
    }

    /**
     * getter for the correct qpay success return instance
     *
     * @param string[] $return
     * @param string $secret
     * @access private
     * @return WirecardCEE_QPay_Return_Success
     */
    protected static function _getSuccessInstance($return, $secret) {
        if (!array_key_exists('paymentType', $return)) {
            throw new WirecardCEE_QPay_Exception_InvalidResponseException('Invalid response from QPAY. Paymenttype is missing.');
        }

        switch(strtoupper($return['paymentType'])) {
            case WirecardCEE_Stdlib_PaymentTypeAbstract::CCARD:
            case WirecardCEE_Stdlib_PaymentTypeAbstract::CCARD_MOTO:
            case WirecardCEE_Stdlib_PaymentTypeAbstract::MAESTRO:
                return new WirecardCEE_QPay_Return_Success_CreditCard($return, $secret);
                break;
            case WirecardCEE_Stdlib_PaymentTypeAbstract::PAYPAL:
                return new WirecardCEE_QPay_Return_Success_PayPal($return, $secret);
                break;
            case WirecardCEE_Stdlib_PaymentTypeAbstract::SOFORTUEBERWEISUNG:
                return new WirecardCEE_QPay_Return_Success_Sofortueberweisung($return, $secret);
                break;
            case WirecardCEE_Stdlib_PaymentTypeAbstract::IDL:
                return new WirecardCEE_QPay_Return_Success_Ideal($return, $secret);
                break;
            default:
                return new WirecardCEE_QPay_Return_Success($return, $secret);
                break;
        }
    }
}