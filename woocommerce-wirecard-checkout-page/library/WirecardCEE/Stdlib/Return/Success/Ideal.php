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
 * @name WirecardCEE_Stdlib_Return_Success_Ideal
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 * @subpackage Return_Success
 * @version 3.0.0
 * @abstract
 */
abstract class WirecardCEE_Stdlib_Return_Success_Ideal extends WirecardCEE_Stdlib_Return_Success {
    /**
     * getter for the return parameter idealConsumerName
     *
     * @return string
     */
    public function getConsumerName() {
        return (string) $this->idealConsumerName;
    }

    /**
     * getter for the return parameter idealConsumerCity
     *
     * @return string
     */
    public function getConsumerCity() {
        return (string) $this->idealConsumerCity;
    }

    /**
     * getter for the return parameter idealConsunerAccountNumber
     *
     * @return string
     */
    public function getConsumerAccountNumber() {
        return (string) $this->idealConsumerAccountNumber;
    }
}