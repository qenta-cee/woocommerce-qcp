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
 * QentaCEE_QPay_ToolkitClient test case.
 */
use PHPUnit\Framework\TestCase;

class QentaCEE_QPay_ToolkitClientTest extends TestCase
{

    /**
     *
     * @var QentaCEE_QPay_ToolkitClient
     */
    private $object;
    protected $_secret = 'B8AKTPWBRMNBV455FG6M2DANE99WU2';
    protected $_customerId = 'D200001';
    protected $_shopId = '';
    protected $_language = 'en';
    protected $_toolkitPassword = 'jcv45z';
    protected $_amount = '1.2';
    protected $_currency = 'eur';
    protected $_sourceOrderNumber = '23473341';
    protected $_depositFlag = false;
    protected $_orderDescription = 'Unittest OrderDescr';
    protected $_orderNumber = 123456;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp(): void
    {
        $this->object = new QentaCEE_QPay_ToolkitClient(Array(
            'CUSTOMER_ID'      => $this->_customerId,
            'SHOP_ID'          => $this->_shopId,
            'SECRET'           => $this->_secret,
            'LANGUAGE'         => $this->_language,
            'TOOLKIT_PASSWORD' => $this->_toolkitPassword
        ));
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown(): void
    {
        $this->object = null;
        parent::tearDown();
    }

    /**
     * Tests QentaCEE_QPay_ToolkitClient->refund()
     */
    public function testRefund()
    {
        $oResult = $this->object->refund($this->_orderNumber, $this->_amount, $this->_currency);

        $this->assertInstanceOf('QentaCEE_QPay_Response_Toolkit_Refund', $oResult);
        $this->assertEquals($oResult->getStatus(), 0);
        $this->assertFalse($oResult->hasFailed());
        $this->assertFalse($oResult->getError());
        $this->assertIsString($oResult->getCreditNumber());
        $this->assertNotEquals('', $oResult->getCreditNumber());
    }

    /**
     * Tests QentaCEE_QPay_ToolkitClient->refundReversal()
     */
    public function testRefundReversal()
    {
        $iCreditNumber = 321312;

        $oResult = $this->object->refundReversal($this->_orderNumber, $iCreditNumber);

        $this->assertInstanceOf('QentaCEE_QPay_Response_Toolkit_RefundReversal', $oResult);
        $this->assertEquals($oResult->getStatus(), 0);
        $this->assertFalse($oResult->hasFailed());
        $this->assertFalse($oResult->getError());

    }

    /**
     * Tests QentaCEE_QPay_ToolkitClient->recurPayment()
     */
    public function testRecurPayment()
    {
        $object = new QentaCEE_QPay_ToolkitClient(Array(
            'CUSTOMER_ID'      => $this->_customerId,
            'SHOP_ID'          => $this->_shopId,
            'SECRET'           => $this->_secret,
            'LANGUAGE'         => $this->_language,
            'TOOLKIT_PASSWORD' => $this->_toolkitPassword
        ));

        $oResult = $object->recurPayment($this->_sourceOrderNumber, $this->_amount, $this->_currency,
            $this->_orderDescription, $this->_orderNumber, $this->_depositFlag);
        $this->assertInstanceOf('QentaCEE_QPay_Response_Toolkit_RecurPayment', $oResult);
        $this->assertEquals($oResult->getStatus(), 0);
        $this->assertFalse($oResult->hasFailed());
        $this->assertFalse($oResult->getError());
    }

    /**
     * Tests QentaCEE_QPay_ToolkitClient->getOrderDetails()
     */
    public function testGetOrderDetails()
    {
        $iOrderNumber = 23473341;
        $oResult      = $this->object->getOrderDetails($iOrderNumber);
        $order        = $oResult->getOrder();
        $sPaymentType = $order->getPaymentType();

        $this->assertEquals('VPG', $sPaymentType);
        $this->assertInstanceOf('QentaCEE_QPay_Response_Toolkit_Order', $order);
        $this->assertEquals($oResult->getStatus(), 0);
        $this->assertFalse($oResult->hasFailed());
        $this->assertFalse($oResult->getError());
    }

    /**
     * Tests QentaCEE_QPay_ToolkitClient->approveReversal()
     */
    public function testApproveReversal()
    {
        $oResult = $this->object->approveReversal($this->_orderNumber);

        $this->assertInstanceOf('QentaCEE_QPay_Response_Toolkit_ApproveReversal', $oResult);
        $this->assertEquals($oResult->getStatus(), 0);
        $this->assertFalse($oResult->hasFailed());
        $this->assertFalse($oResult->getError());
    }

    /**
     * Tests QentaCEE_QPay_ToolkitClient->deposit()
     */
    public function testDeposit()
    {
        $oResult = $this->object->deposit($this->_orderNumber, $this->_amount, $this->_currency);

        $this->assertInstanceOf('QentaCEE_QPay_Response_Toolkit_Deposit', $oResult);
        $this->assertEquals($this->_orderNumber, $oResult->getPaymentNumber());
        $this->assertEquals($oResult->getStatus(), 0);
        $this->assertFalse($oResult->hasFailed());
        $this->assertFalse($oResult->getError());
    }

    /**
     * Tests QentaCEE_QPay_ToolkitClient->depositReversal()
     */
    public function testDepositReversal()
    {
        $_paymentNumber = 123445;
        $oResult        = $this->object->depositReversal($this->_orderNumber, $_paymentNumber);

        $this->assertInstanceOf('QentaCEE_QPay_Response_Toolkit_DepositReversal', $oResult);
        $this->assertEquals($oResult->getStatus(), 0);
        $this->assertFalse($oResult->hasFailed());
        $this->assertFalse($oResult->getError());
    }

    public function testCustomerIdIsEmpty()
    {
        $this -> expectException(QentaCEE_QPay_Exception_InvalidArgumentException::class);
        $object = new QentaCEE_QPay_ToolkitClient(Array(
            'CUSTOMER_ID'      => '',
            'SHOP_ID'          => $this->_shopId,
            'SECRET'           => $this->_secret,
            'LANGUAGE'         => $this->_language,
            'TOOLKIT_PASSWORD' => $this->_toolkitPassword
        ));
    }

    public function testLanguageIsEmpty()
    {
        $this -> expectException(QentaCEE_QPay_Exception_InvalidArgumentException::class);
        $object = new QentaCEE_QPay_ToolkitClient(Array(
            'CUSTOMER_ID'      => $this->_customerId,
            'SHOP_ID'          => $this->_shopId,
            'SECRET'           => $this->_secret,
            'LANGUAGE'         => '',
            'TOOLKIT_PASSWORD' => $this->_toolkitPassword
        ));
    }

    public function testSecretIsEmpty()
    {
        $this -> expectException(QentaCEE_QPay_Exception_InvalidArgumentException::class);
        $object = new QentaCEE_QPay_ToolkitClient(Array(
            'CUSTOMER_ID'      => $this->_customerId,
            'SHOP_ID'          => $this->_shopId,
            'SECRET'           => '',
            'LANGUAGE'         => $this->_language,
            'TOOLKIT_PASSWORD' => $this->_toolkitPassword
        ));
    }

    public function testToolkitPasswordIsEmpty()
    {
        $this -> expectException(QentaCEE_QPay_Exception_InvalidArgumentException::class);
        $object = new QentaCEE_QPay_ToolkitClient(Array(
            'CUSTOMER_ID'      => $this->_customerId,
            'SHOP_ID'          => $this->_shopId,
            'SECRET'           => $this->_secret,
            'LANGUAGE'         => $this->_language,
            'TOOLKIT_PASSWORD' => ''
        ));
    }

    public function testConfigFallback()
    {
        $object      = new QentaCEE_QPay_ToolkitClient();
        $oUserConfig = $object->getUserConfig();
        $this->assertInstanceOf('QentaCEE_Stdlib_Config', $oUserConfig);
        $this->assertEquals($oUserConfig->CUSTOMER_ID, 'D200001');
    }

}

