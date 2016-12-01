<?php
/**
 * Shop System Plugins - Terms of Use
 *
 * The plugins offered are provided free of charge by Wirecard Central Eastern Europe GmbH
 * (abbreviated to Wirecard CEE) and are explicitly not part of the Wirecard CEE range of
 * products and services.
 *
 * They have been tested and approved for full functionality in the standard configuration
 * (status on delivery) of the corresponding shop system. They are under General Public
 * License Version 2 (GPLv2) and can be used, developed and passed on to third parties under
 * the same terms.
 *
 * However, Wirecard CEE does not provide any guarantee or accept any liability for any errors
 * occurring when used in an enhanced, customized shop system configuration.
 *
 * Operation in an enhanced, customized configuration is at your own risk and requires a
 * comprehensive test phase by the user of the plugin.
 *
 * Customers use the plugins at their own risk. Wirecard CEE does not guarantee their full
 * functionality neither does Wirecard CEE assume liability for any disadvantages related to
 * the use of the plugins. Additionally, Wirecard CEE does not guarantee the full functionality
 * for customized shop systems or installed plugins of other vendors of plugins within the same
 * shop system.
 *
 * Customers are responsible for testing the plugin's functionality before starting productive
 * operation.
 *
 * By installing the plugin into the shop system the customer agrees to these terms of use.
 * Please do not use the plugin if you do not agree to these terms of use!
 */


use Psr\Http\Message\ResponseInterface;

/**
 * @name WirecardCEE_Stdlib_Response_ResponseAbstract
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 * @subpackage Response
 * @abstract
 */
abstract class WirecardCEE_Stdlib_Response_ResponseAbstract
{
    /**
     * State success
     *
     * @var int
     */
    const STATE_SUCCESS = 0;

    /**
     * State failure
     *
     * @var int
     */
    const STATE_FAILURE = 1;

    /**
     * Response holder
     *
     * @var array
     */
    protected $_response = Array();

    /**
     * RedirectURL Field name
     *
     * @var string
     */
    const REDIRECT_URL = 'redirectUrl';

    /**
     * Errors holder
     *
     * @var array
     */
    protected $_errors = Array();

    /**
     * Error message
     *
     * @staticvar string
     * @internal
     */
    protected static $ERROR_MESSAGE = 'message';

    /**
     * Error consumer message
     *
     * @staticvar string
     * @internal
     */
    protected static $ERROR_CONSUMER_MESSAGE = 'consumerMessage';

    /**
     * base constructor for Response objects
     *
     * @param ResponseInterface $response
     *
     * @throws WirecardCEE_Stdlib_Exception_InvalidResponseException
     */
    public function __construct($response)
    {
        if ($response instanceof ResponseInterface) {
            $this->_response = WirecardCEE_Stdlib_SerialApi::decode($response->getBody());
        } elseif (is_array($response)) {
            $this->_response = $response;
        } else {
            throw new WirecardCEE_Stdlib_Exception_InvalidResponseException(sprintf('Invalid response from WirecardCEE thrown in %s.',
                __METHOD__));
        }
    }

    /**
     * Cheks to see if the object request failed or not
     *
     * @return boolean
     */
    public function hasFailed()
    {
        return (bool) ( $this->getStatus() >= self::STATE_FAILURE );
    }

    /**
     * getter for given field
     *
     * @param string $name
     *
     * @return string|array|null
     */
    protected function _getField($name)
    {
        return isset( $this->_response[$name] ) ? $this->_response[$name] : null;
    }


    /**
     * getter for the returned redirect url
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        return (string) $this->_getField(self::REDIRECT_URL);
    }

    /**
     * getter for the response data
     *
     * @return array
     */
    public function getResponse()
    {
        return $this->_response;
    }
}
