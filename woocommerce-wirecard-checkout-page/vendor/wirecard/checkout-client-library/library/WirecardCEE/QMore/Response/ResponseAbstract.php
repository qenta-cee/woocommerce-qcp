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


/**
 * @name WirecardCEE_QMore_Response_ResponseAbstract
 * @category WirecardCEE
 * @package WirecardCEE_QMore
 * @subpackage Response
 * @abstract
 */
abstract class WirecardCEE_QMore_Response_ResponseAbstract extends WirecardCEE_Stdlib_Response_ResponseAbstract
{
    /**
     * Errors
     *
     * @staticvar string
     * @internal
     */
    protected static $ERRORS = 'errors';

    /**
     * Error
     *
     * @staticvar string
     * @internal
     */
    protected static $ERROR = 'error';

    /**
     * Error code
     *
     * @staticvar string
     * @internal
     */
    protected static $ERROR_CODE = 'errorCode';

    /**
     * Pay sys message
     *
     * @staticvar string
     * @internal
     */
    protected static $ERROR_PAYSYS_MESSAGE = 'paySysMessage';

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
     * Returns the number of errors
     *
     * @return number
     */
    public function getNumberOfErrors()
    {
        return (int) $this->_getField(self::$ERRORS);
    }

    /**
     * getter for list of errors that occured
     *
     * @return WirecardCEE_QMore_Error[]
     */
    public function getErrors()
    {
        $aErrors = Array();
        if (empty( $this->_errors )) {
            if (is_array($this->_getField(self::$ERROR))) {
                foreach ($this->_getField(self::$ERROR) as $error) {
                    $errorCode       = isset( $error[self::$ERROR_CODE] ) ? $error[self::$ERROR_CODE] : 0;
                    $message         = isset( $error[self::$ERROR_MESSAGE] ) ? $error[self::$ERROR_MESSAGE] : '';
                    $consumerMessage = isset( $error[self::$ERROR_CONSUMER_MESSAGE] ) ? $error[self::$ERROR_CONSUMER_MESSAGE] : '';
                    $paySysMessage   = isset( $error[self::$ERROR_PAYSYS_MESSAGE] ) ? $error[self::$ERROR_PAYSYS_MESSAGE] : '';

                    $error = new WirecardCEE_QMore_Error($errorCode, $message);
                    $error->setConsumerMessage($consumerMessage);
                    $error->setPaySysMessage($paySysMessage);

                    $aErrors[] = $error;
                }
            }

            $this->_errors = $aErrors;
        }

        return $this->_errors;
    }
}