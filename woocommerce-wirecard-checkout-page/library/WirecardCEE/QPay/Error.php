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
 * @name WirecardCEE_QPay_Error
 * @category WirecardCEE
 * @package WirecardCEE_QPay
 * @version 3.0.0
 */
class WirecardCEE_QPay_Error extends WirecardCEE_Stdlib_Error {

    /**
     * WirecardCEE_QPay_Error contructor
     *
     * @param string $message
     */
    public function __construct($message) {
        $this->setMessage($message);
    }
}