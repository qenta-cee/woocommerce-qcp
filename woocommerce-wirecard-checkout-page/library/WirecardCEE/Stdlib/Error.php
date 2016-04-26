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
 * @name WirecardCEE_Stdlib_Error
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 * @version 3.0.0
 * @abstract
 */
abstract class WirecardCEE_Stdlib_Error {

    /**
     * Error message
     *
     * @var string
     */
    protected $_message = null;

    /**
     * Consumer message
     *
     * @var string
     */
    protected $_consumerMessage = null;

    /**
     * Message getter
     *
     * @return string
     */
    public function getMessage() {
        return (string) $this->_message;
    }

    /**
     * Error Message setter
     *
     * @param string $message
     * @return WirecardCEE_Stdlib_Error
     */
    public function setMessage($message) {
        $this->_message = (string) $message;
        return $this;
    }

    /**
     * Consumer message setter
     *
     * @param string $consumerMessage
     * @return WirecardCEE_Stdlib_Error
     */
    public function setConsumerMessage($consumerMessage) {
        $this->_consumerMessage = (string) $consumerMessage;
        return $this;
    }

    /**
     * Consumer message getter
     *
     * @return string
     */
    public function getConsumerMessage() {
        return (string) $this->_consumerMessage;
    }
}