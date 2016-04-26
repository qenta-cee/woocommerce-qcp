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
 * @name WirecardCEE_Stdlib_Return_Success_CreditCard
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 * @subpackage Return_Success
 * @version 3.0.0
 * @abstract
 */
abstract class WirecardCEE_Stdlib_Return_Success_CreditCard extends WirecardCEE_Stdlib_Return_Success {

    /**
     * getter for the return parameter anonymousPan
     *
     * @return string
     */
    public function getAnonymousPan() {
        return (string) $this->anonymousPan;
    }

    /**
     * getter for the return parameter authenticated
     *
     * @return string
     */
    public function getAuthenticated() {
        return (string) $this->authenticated;
    }

    /**
     * getter for the return parameter expiry
     *
     * @return string
     */
    public function getExpiry() {
        return (string) $this->expiry;
    }

    /**
     * getter for the return parameter cardholder
     *
     * @return string
     */
    public function getCardholder() {
        return (string) $this->cardholder;
    }

    /**
     * getter for the return parameter maskedPan
     *
     * @return string
     */
    public function getMaskedPan() {
        return (string) $this->maskedPan;
    }
}