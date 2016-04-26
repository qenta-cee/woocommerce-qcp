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
 * @name WirecardCEE_QPay_Return_Failure
 * @category WirecardCEE
 * @package WirecardCEE_QPay
 * @subpackage Return
 * @version 3.0.0
 */
class WirecardCEE_QPay_Return_Failure extends WirecardCEE_Stdlib_Return_Failure {
    /**
     * getter for list of errors that occured
     *
     * @return WirecardCEE_QPay_Error
     */
    public function getErrors() {
        $oError = new WirecardCEE_QPay_Error($this->_returnData[self::$ERROR_MESSAGE]);

        if(isset($this->_returnData[self::$ERROR_CONSUMER_MESSAGE]))
            $oError->setConsumerMessage($this->_returnData[self::$ERROR_CONSUMER_MESSAGE]);

        return $oError;
    }
}