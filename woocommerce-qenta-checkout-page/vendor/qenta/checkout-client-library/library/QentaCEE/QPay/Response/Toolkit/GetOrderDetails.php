<?php
/**
 * Shop System Plugins - Terms of Use
 *
 * The plugins offered are provided free of charge by Qenta Payment CEE GmbH
 * (abbreviated to Qenta CEE) and are explicitly not part of the Qenta CEE range of
 * products and services.
 *
 * They have been tested and approved for full functionality in the standard configuration
 * (status on delivery) of the corresponding shop system. They are under General Public
 * License Version 2 (GPLv2) and can be used, developed and passed on to third parties under
 * the same terms.
 *
 * However, Qenta CEE does not provide any guarantee or accept any liability for any errors
 * occurring when used in an enhanced, customized shop system configuration.
 *
 * Operation in an enhanced, customized configuration is at your own risk and requires a
 * comprehensive test phase by the user of the plugin.
 *
 * Customers use the plugins at their own risk. Qenta CEE does not guarantee their full
 * functionality neither does Qenta CEE assume liability for any disadvantages related to
 * the use of the plugins. Additionally, Qenta CEE does not guarantee the full functionality
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
 * @name QentaCEE_QPay_Response_Toolkit_GetOrderDetails
 * @category QentaCEE
 * @package QentaCEE_QPay
 * @subpackage Response_Toolkit
 */
class QentaCEE_QPay_Response_Toolkit_GetOrderDetails extends QentaCEE_QPay_Response_Toolkit_ResponseAbstract
{
    /**
     * Internal order holder
     *
     * @var QentaCEE_QPay_Response_Toolkit_Order
     */
    private $_order;

    /**
     * Order
     *
     * @staticvar string
     */
    private static $ORDER = 'order';

    /**
     * Payment
     *
     * @staticvar string
     */
    private static $PAYMENT = 'payment';

    /**
     * Credit
     *
     * @staticvar string
     */
    private static $CREDIT = 'credit';

    /**
     *
     * @see QentaCEE_QPay_Response_Toolkit_Abstract
     *
     * @param array $result
     */
    public function __construct($result)
    {
        parent::__construct($result);

        $orders   = $this->_getField(self::$ORDER);
        $payments = $this->_getField(self::$PAYMENT);
        $credits  = $this->_getField(self::$CREDIT);
        if(!isset($orders)){
            $orders = Array();
        }
        if(!isset($payments)){
            $payments = Array();
        }
        if(!isset($credits)){
            $credits = Array();
        }

        $order                = isset($orders[0]) ? $orders[0] : Array();
        $order['paymentData'] = isset($payments[0]) ? $payments[0] : Array();
        $order['creditData']  = isset($credits[0]) ? $credits[0] : Array();

        $this->_order = new QentaCEE_QPay_Response_Toolkit_Order($order);
        
    }

    /**
     * getter for the returned order object
     *
     * @return QentaCEE_QPay_Response_Toolkit_Order
     */
    public function getOrder()
    {
        return $this->_order;
    }
}
