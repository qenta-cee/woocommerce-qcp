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
 * @name WirecardCEE_QMore_Return_Failure
 * @category WirecardCEE
 * @package WirecardCEE_QMore
 * @subpackage Return
 */
class WirecardCEE_QMore_Return_Failure extends WirecardCEE_Stdlib_Return_Failure
{

    /**
     * Returns the number of errors
     *
     * @return int
     */
    public function getNumberOfErrors()
    {
        return (int) $this->__get(self::$ERRORS);
    }

    /**
     * Returns all the errors
     * return Array
     */
    public function getErrors()
    {
        if (empty( $this->_errors )) {
            $errorList = Array();

            foreach ($this->__get(self::$ERROR) as $error) {
                $errorCode       = $error[self::$ERROR_ERROR_CODE];
                $message         = $error[self::$ERROR_MESSAGE];
                $consumerMessage = $error[self::$ERROR_CONSUMER_MESSAGE];
                $paySysMessage   = $error[self::$ERROR_PAY_SYS_MESSAGE];

                $errorObject = new WirecardCEE_QMore_Error($errorCode, $message);
                $errorObject->setPaySysMessage($paySysMessage);
                $errorObject->setConsumerMessage($consumerMessage);

                array_push($errorList, $errorObject);
            }

            $this->_errors = $errorList;
        }

        return $this->_errors;
    }
}