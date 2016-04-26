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
 * @name WirecardCEE_Stdlib_Response_ResponseAbstract
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 * @subpackage Response
 * @version 3.0.0
 * @abstract
 */
abstract class WirecardCEE_Stdlib_Response_ResponseAbstract {
    /**
     * State success
     * @var int
     */
    const STATE_SUCCESS = 0;

    /**
     * State failure
     * @var int
     */
    const STATE_FAILURE = 1;

    /**
     * Response holder
     * @var array
     */
    protected $_response = Array();

    /**
     * RedirectURL Field name
     * @var string
     */
    const REDIRECT_URL = 'redirectUrl';

    /**
     * Errors holder
     * @var Array
    */
    protected $_errors = Array();

    /**
     * Error message
     * @staticvar string
     * @internal
     */
    protected static $ERROR_MESSAGE             = 'message';

    /**
     * Error consumer message
     * @staticvar string
     * @internal
     */
    protected static $ERROR_CONSUMER_MESSAGE     = 'consumerMessage';

    /**
     * base constructor for Response objects
     *
     * @param Zend_Http_Response $response
     */
    public function __construct($response) {
        if ($response instanceof Zend_Http_Response) {
            $this->_response = WirecardCEE_Stdlib_SerialApi::decode($response->getBody());
        }
        elseif (is_array($response)) {
            $this->_response = $response;
        }
        else {
            throw new WirecardCEE_Stdlib_Exception_InvalidResponseException(sprintf('Invalid response from WirecardCEE thrown in %s.', __METHOD__));
        }
    }

    /**
     * Cheks to see if the object request failed or not
     *
     * @return boolean
     */
    public function hasFailed() {
        return (bool) ($this->getStatus() == self::STATE_FAILURE);
    }

    /**
     * getter for given field
     *
     * @param string $name
     * @return string|array|null
     */
    protected function _getField($name) {
        return isset($this->_response[$name]) ? $this->_response[$name] : null;
    }


    /**
     * getter for the returned redirect url
     *
     * @return string
     */
    public function getRedirectUrl() {
        return (string) $this->_getField(self::REDIRECT_URL);
    }
}
