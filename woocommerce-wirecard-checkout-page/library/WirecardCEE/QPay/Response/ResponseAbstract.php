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
 * @name WirecardCEE_QPay_Response_ResponseAbstract
 * @category WirecardCEE
 * @package WirecardCEE_QPay
 * @subpackage Response
 * @version 3.0.0
 * @abstract
 */
abstract class WirecardCEE_QPay_Response_ResponseAbstract extends WirecardCEE_Stdlib_Response_ResponseAbstract {
    /**
     * getter for the Response status
     * values:
     * 0 ... success
     * 1 ... failure
     *
     * @return int
     */
    abstract public function getStatus();

    /**
     * getter for list of errors that occured
     *
     * @return WirecardCEE_Stdlib_Error[]
     */
    public function getError() {
        $oError = false;

        if(isset($this->_response[self::$ERROR_MESSAGE])) {
            $oError = new WirecardCEE_QPay_Error($this->_response[self::$ERROR_MESSAGE]);

            if(isset($this->_response[self::$ERROR_CONSUMER_MESSAGE]))
                $oError->setConsumerMessage($this->_response[self::$ERROR_CONSUMER_MESSAGE]);
        }

        return $oError;
    }
}