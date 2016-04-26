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
 * @name WirecardCEE_QPay_Response_Initiation
 * @category WirecardCEE
 * @package WirecardCEE_QPay
 * @subpackage Response
 * @version 3.0.0
 */
class WirecardCEE_QPay_Response_Initiation extends WirecardCEE_QPay_Response_ResponseAbstract {
    /**
     * @see WirecardCEE_QPay_Response_ResponseAbstract::getStatus()
     * if we have got a redirectUrl the initiation has been successful
     * @return int
     */
    public function getStatus() {
        return ($this->_getField(self::REDIRECT_URL)) ? self::STATE_SUCCESS : self::STATE_FAILURE;
    }
}