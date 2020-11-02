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
 * Factory method for returned params validators
 *
 * @name WirecardCEE_Stdlib_ReturnFactoryAbstract
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 * @subpackage Return
 * @abstract
 */
abstract class WirecardCEE_Stdlib_ReturnFactoryAbstract
{
    /**
     * Success
     *
     * @var string
     */
    const STATE_SUCCESS = 'SUCCESS';

    /**
     * Cancel
     *
     * @var string
     */
    const STATE_CANCEL = 'CANCEL';

    /**
     * Failure
     *
     * @var string
     */
    const STATE_FAILURE = 'FAILURE';

    /**
     * Pending
     *
     * @var string
     */
    const STATE_PENDING = 'PENDING';


    /**
     * generator for qpay confirm response strings.
     * the response-string must be returned to QPAY in confirmation process.
     *
     * @param string $messages
     * @param bool $inCommentTag
     *
     * @return string
     */
    public static function generateConfirmResponseString($messages = null, $inCommentTag = false)
    {
        $template = '<QPAY-CONFIRMATION-RESPONSE result="%status%" %message%/>';
        if (empty( $messages )) {
            $returnValue = str_replace('%status%', 'OK', $template);
            $returnValue = str_replace('%message%', '', $returnValue);
        } else {
            $returnValue = str_replace('%status%', 'NOK', $template);
            $returnValue = str_replace('%message%', 'message="' . strval($messages) . '" ', $returnValue);
        }
        if ($inCommentTag) {
            $returnValue = '<!--' . $returnValue . '-->';
        }

        return $returnValue;
    }
}