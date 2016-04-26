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
 * @name WirecardCEE_Stdlib_Return_Success_PayPal
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 * @subpackage Return_Success
 * @version 3.0.0
 * @abstract
 */
abstract class WirecardCEE_Stdlib_Return_Success_PayPal extends WirecardCEE_Stdlib_Return_Success {

    /**
     * getter for the return parameter paypalPayerID
     *
     * @return string
     */
    public function getPayerId() {
        return $this->paypalPayerID;
    }

    /**
     * getter for the return parameter paypalPayerEmail
     *
     * @return string
     */
    public function getPayerEmail() {
        return $this->paypalPayerEmail;
    }

    /**
     * getter for the return parameter paypalPayerLastName
     *
     * @return string
     */
    public function getPayerLastName() {
        return $this->paypalPayerLastName;
    }

    /**
     * getter for the return parameter paypalPayerFirstName
     *
     * @return string
     */
    public function getPayerFirstName() {
        return $this->paypalPayerFirstName;
    }

    /**
     * getter for the return parameter paypalPayerAddressName
     *
     * @return string
     */
    public function getPayerAddressName() {
        return $this->paypalPayerAddressName;
    }

    /**
     * getter for the return parameter paypalPayerAddressCountry
     *
     * @return string
     */
    public function getPayerAddressCountry() {
        return $this->paypalPayerAddressCountry;
    }

    /**
     * getter for the return parameter paypalPayerAddressCity
     *
     * @return string
     */
    public function getPayerAddressCity() {
        return $this->paypalPayerAddressCity;
    }

    /**
     * getter for the return parameter paypalPayerAddressState
     *
     * @return string
     */
    public function getPayerAddressState() {
        return $this->paypalPayerAddressState;
    }

    /**
     * getter for the return parameter paypalPayerAddressStreet1
     *
     * @return string
     */
    public function getPayerAddressStreet1() {
        return $this->paypalPayerAddressStreet1;
    }

    /**
     * getter for the return parameter paypalPayerAddressStreet2
     *
     * @return string
     */
    public function getPayerAddressStreet2() {
        return $this->paypalPayerAddressStreet2;
    }

    /**
     * getter for the return parameter paypalPayerAddressZIP
     *
     * @return string
     */
    public function getPayerAddressZip() {
        return $this->paypalPayerAddressZIP;
    }
}