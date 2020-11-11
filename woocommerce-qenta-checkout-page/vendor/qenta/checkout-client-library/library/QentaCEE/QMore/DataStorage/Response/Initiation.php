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
 * @name QentaCEE_QMore_DataStorage_Response_Initiation
 * @category QentaCEE
 * @package QentaCEE_QMore
 * @subpackage DataStorage_Response
 */
class QentaCEE_QMore_DataStorage_Response_Initiation extends QentaCEE_QMore_Response_ResponseAbstract
{
    /**
     * Storage id
     *
     * @staticvar string
     * @internal
     */
    protected static $STORAGE_ID = 'storageId';

    /**
     * Javascript url
     *
     * @staticvar string
     * @internal
     */
    protected static $JAVASCRIPT_URL = 'javascriptUrl';

    /**
     * getter for the Response status
     * values: 0 .
     * .. success
     * 1 ... failure
     *
     * @return int
     */
    public function getStatus()
    {
        return ( $this->_getField(self::$STORAGE_ID) ) ? self::STATE_SUCCESS : self::STATE_FAILURE;
    }

    /**
     * getter for storageId returned by the dataStorage
     *
     * @return string
     */
    public function getStorageId()
    {
        return $this->_getField(self::$STORAGE_ID);
    }

    /**
     * getter for javascriptUrl returned by the dataStorage
     *
     * the script behind this url is used by the shopsystem to save
     * paymentInformation in the dataStorage
     *
     * @return string
     */
    public function getJavascriptUrl()
    {
        return $this->_getField(self::$JAVASCRIPT_URL);
    }
}