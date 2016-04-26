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
 * @name WirecardCEE_Stdlib_Return_Success_Sofortueberweisung
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 * @subpackage Return_Success
 * @version 3.0.0
 * @abstract
 */
abstract class WirecardCEE_Stdlib_Return_Success_Sofortueberweisung extends WirecardCEE_Stdlib_Return_Success {

    /**
     * getter for the return parameter senderAccountOwner
     *
     * @return string
     */
    public function getSenderAccountOwner() {
        return $this->senderAccountOwner;
    }

    /**
     * getter for the return parameter senderAccountNumber
     *
     * @return string
     */
    public function getSenderAccountNumber() {
        return $this->senderAccountNumber;
    }

    /**
     * getter for the return parameter senderBankNumber
     *
     * @return string
     */
    public function getSenderBankNumber() {
        return $this->senderBankNumber;
    }

    /**
     * getter for the return parameter senderBankName
     *
     * @return string
     */
    public function getSenderBankName() {
        return $this->senderBankName;
    }

    /**
     * getter for the return parameter senderBIC
     *
     * @return string
     */
    public function getSenderBic() {
        return $this->senderBIC;
    }

    /**
     * getter for the return parameter senderIBAN
     *
     * @return string
     */
    public function getSenderIban() {
        return $this->senderIBAN;
    }

    /**
     * getter for the return parameter senderCountry
     *
     * @return string
     */
    public function getSenderCountry() {
        return $this->senderCountry;
    }

    /**
     * getter for the return parameter securityCriteria
     *
     * @return string
     */
    public function getSecurityCriteria() {
        return $this->securityCriteria;
    }
}