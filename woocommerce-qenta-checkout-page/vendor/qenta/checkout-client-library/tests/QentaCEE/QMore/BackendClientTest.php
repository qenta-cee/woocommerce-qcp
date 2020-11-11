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
use PHPUnit\Framework\TestCase;

class QentaCEE_QMore_BackendClientTest extends TestCase
{
    /**
     * @var array
     */
    protected $aUserConfig;

    /**
     * @var array
     */
    protected $aClientConfig;

    /**
     *
     * @var QentaCEE_QMore_BackendClient
     */
    protected $object;


    public function setUp(): void 
    {
        $this->object        = new QentaCEE_QMore_BackendClient();
        $this->aUserConfig   = QentaCEE_QMore_Module::getConfig();
        $this->aClientConfig = QentaCEE_QMore_Module::getClientConfig();
    }

    /**
     * @dataProvider _provider
     */
    public function testConstructorArrayParam($aConfig)
    {
        $this->assertEquals($this->aUserConfig['QentaCEEQMoreConfig']['CUSTOMER_ID'],
            $this->object->getUserConfig()->CUSTOMER_ID);
        $this->assertEquals($this->aUserConfig['QentaCEEQMoreConfig']['SHOP_ID'],
            $this->object->getUserConfig()->SHOP_ID);
        $this->assertEquals($this->aUserConfig['QentaCEEQMoreConfig']['LANGUAGE'],
            $this->object->getUserConfig()->LANGUAGE);
        $this->assertEquals($this->aUserConfig['QentaCEEQMoreConfig']['SECRET'],
            $this->object->getUserConfig()->SECRET);
        $this->assertEquals($this->aUserConfig['QentaCEEQMoreConfig']['PASSWORD'],
            $this->object->getUserConfig()->PASSWORD);
    }

    
    public function testConstructorWithInvalidParam()
    {
        $this -> expectException(Exception::class);
        $this->object = null;

        try {
            $this->object = new QentaCEE_QMore_BackendClient(array());
        } catch (Exception $e) {
            $this->assertStringStartsWith('CUSTOMER_ID passed', $e->getMessage());
            throw $e;
        }
    }

    /**
     * @dataProvider _provider
     */
    public function testConstructorWhenLanguageParamIsEmpty($aConfig)
    {
        $this -> expectException(QentaCEE_QMore_Exception_InvalidArgumentException::class);
        $aConfig['QentaCEEQMoreConfig']['LANGUAGE'] = null;

        try {
            $this->object = new QentaCEE_QMore_BackendClient($aConfig);
        } catch (QentaCEE_QMore_Exception_InvalidArgumentException $e) {
            $this->assertStringStartsWith('LANGUAGE passed to', $e->getMessage());
            throw $e;
        }
    }

    /**
     * @dataProvider _provider
     */
    public function testConstructorWhenCustomerIdParamIsEmpty($aConfig)
    {
        $this -> expectException(QentaCEE_QMore_Exception_InvalidArgumentException::class);
        $aConfig['QentaCEEQMoreConfig']['CUSTOMER_ID'] = null;

        try {
            $this->object = new QentaCEE_QMore_BackendClient($aConfig);
        } catch (QentaCEE_QMore_Exception_InvalidArgumentException $e) {
            $this->assertStringStartsWith('CUSTOMER_ID passed to', $e->getMessage());
            throw $e;
        }
    }

    /**
     * @dataProvider _provider
     */
    public function testConstructorWhenSecretParamIsEmpty($aConfig)
    {
        $this -> expectException(QentaCEE_QMore_Exception_InvalidArgumentException::class);
        $aConfig['QentaCEEQMoreConfig']['SECRET'] = null;

        try {
            $this->object = new QentaCEE_QMore_BackendClient($aConfig);
        } catch (QentaCEE_QMore_Exception_InvalidArgumentException $e) {
            $this->assertStringStartsWith('SECRET passed to', $e->getMessage());
            throw $e;
        }
    }

    /**
     * @dataProvider _provider
     */
    public function testConstructorWhenPasswordParamIsEmpty($aConfig)
    {
        $this -> expectException(QentaCEE_QMore_Exception_InvalidArgumentException::class);
        $aConfig['QentaCEEQMoreConfig']['PASSWORD'] = null;

        try {
            $this->object = new QentaCEE_QMore_BackendClient($aConfig);
        } catch (QentaCEE_QMore_Exception_InvalidArgumentException $e) {
            $this->assertStringStartsWith('PASSWORD passed to', $e->getMessage());
            throw $e;
        }
    }

    public function testRefund()
    {
        $oResponse = $this->object->refund(123456, '1.2', 'USD');
        $this->assertInstanceOf('QentaCEE_QMore_Response_Backend_Refund', $oResponse);
        $this->assertEquals($oResponse->getStatus(), 0);
        $this->assertEmpty($oResponse->getErrors());
        $this->assertIsString($oResponse->getCreditNumber());
        $this->assertNotEquals('', $oResponse->getCreditNumber());
        $this->assertFalse($oResponse->hasFailed());
    }

    public function testRefundReversal()
    {
        $oResponse = $this->object->refundReversal(123456, 321312);
        $this->assertInstanceOf('QentaCEE_QMore_Response_Backend_RefundReversal', $oResponse);
        $this->assertEquals($oResponse->getStatus(), 0);
        $this->assertEmpty($oResponse->getErrors());
        $this->assertFalse($oResponse->hasFailed());
    }

    public function testRecurPayment()
    {
        $object = new QentaCEE_QMore_BackendClient(
            Array(
                'QentaCEEQMoreConfig' => Array(
                    'CUSTOMER_ID' => 'D200001',
                    'SHOP_ID'     => 'seamless',
                    'SECRET'      => 'B8AKTPWBRMNBV455FG6M2DANE99WU2',
                    'LANGUAGE'    => 'en',
                    'PASSWORD'    => 'jcv45z'
                )
            ));
        $oResponse = $object->recurPayment('23473341', '1,2', 'EUR', __METHOD__, '', false);
        $this->assertInstanceOf('QentaCEE_QMore_Response_Backend_RecurPayment', $oResponse);
        $this->assertNotEquals('', $oResponse->getOrderNumber());
        $this->assertEquals($oResponse->getStatus(), 0);
        $this->assertEmpty($oResponse->getErrors());
        $this->assertFalse($oResponse->hasFailed());
    }


    public function testGetOrderDetails()
    {
        $oResponse = $this->object->getOrderDetails(123456);
        $this->assertInstanceOf('QentaCEE_QMore_Response_Backend_GetOrderDetails', $oResponse);
        $this->assertEquals($oResponse->getStatus(), 0);
        $this->assertEmpty($oResponse->getErrors());
        $this->assertFalse($oResponse->hasFailed());

        $order = $oResponse->getOrder();
        $this->assertInstanceOf('QentaCEE_QMore_Response_Backend_Order', $order);
    }

    public function testApproveReversal()
    {
        $oResponse = $this->object->approveReversal(123456);
        $this->assertInstanceOf('QentaCEE_QMore_Response_Backend_ApproveReversal', $oResponse);
        $this->assertEquals($oResponse->getStatus(), 0);
        $this->assertEmpty($oResponse->getErrors());
        $this->assertFalse($oResponse->hasFailed());
    }

    public function testDeposit()
    {
        $oResponse = $this->object->deposit(123456, 100, 'eur');
        $this->assertInstanceOf('QentaCEE_QMore_Response_Backend_Deposit', $oResponse);
        $this->assertEquals($oResponse->getStatus(), 0);
        $this->assertEmpty($oResponse->getErrors());
        $this->assertFalse($oResponse->hasFailed());
        $this->assertEquals(123456, $oResponse->getPaymentNumber());

    }

    public function testDepositReversal()
    {
        $oResponse = $this->object->depositReversal(123456, 123445);
        $this->assertInstanceOf('QentaCEE_QMore_Response_Backend_DepositReversal', $oResponse);
        $this->assertEquals($oResponse->getStatus(), 0);
        $this->assertEmpty($oResponse->getErrors());
        $this->assertFalse($oResponse->hasFailed());
    }

    public function _provider()
    {
        return Array(
            Array(
                Array(
                    'QentaCEEQMoreConfig' => Array(
                        'CUSTOMER_ID' => 'D200001',
                        'SHOP_ID'     => 'qmore',
                        'SECRET'      => 'B8AKTPWBRMNBV455FG6M2DANE99WU2',
                        'LANGUAGE'    => 'en',
                        'PASSWORD'    => 'jcv45z'
                    )
                )
            )
        );
    }

}