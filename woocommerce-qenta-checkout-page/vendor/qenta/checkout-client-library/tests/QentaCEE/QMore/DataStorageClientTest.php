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
class MockClient extends QentaCEE_QMore_DataStorageClient
{
    public function unsetCustomerId()
    {
        $this->_setField(QentaCEE_Stdlib_Client_ClientAbstract::CUSTOMER_ID, null);
    }

    public function unsetStorageId()
    {
        $this->oInitResponse = null;
        $this->_setField(QentaCEE_QMore_DataStorageClient::STORAGE_ID, null);
    }
}

/**
 * QentaCEE_QMore_FrontendClient test case.
 */
use PHPUnit\Framework\TestCase;
class QentaCEE_QMore_DataStorageClientTest extends TestCase
{
    /**
     *
     * @var string
     */
    private $sReturnUrl = 'http://foo.bar.com/library/storageReturn.php';

    /**
     *
     * @var string
     */
    private $sOrderIdent = 'phpunit test';

    /**
     *
     * @var QentaCEE_QMore_DataStorageClient
     */
    private $object;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->object        = new QentaCEE_QMore_DataStorageClient();
        $this->aUserConfig   = QentaCEE_QMore_Module::getConfig();
        $this->aClientConfig = QentaCEE_QMore_Module::getClientConfig();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown(): void
    {
        $this->object        = null;
        $this->aUserConfig   = null;
        $this->aClientConfig = null;
        parent::tearDown();
    }

    public function testInitiate()
    {
        $oQMoreDataStorageResponse = $this->object->setOrderIdent($this->sOrderIdent)->setReturnUrl($this->sReturnUrl)->initiate();

        $this->assertInstanceOf('QentaCEE_QMore_DataStorage_Response_Initiation', $oQMoreDataStorageResponse);
        $this->assertEquals($oQMoreDataStorageResponse->getStatus(), 0);
        $this->assertEmpty($oQMoreDataStorageResponse->getErrors());
    }

    public function testInitiateForException()
    {
        $this -> expectException(QentaCEE_QMore_Exception_InvalidArgumentException::class);
        $oQMoreDataStorageResponse = $this->object->setOrderIdent(null)->setReturnUrl($this->sReturnUrl)->initiate();
    }

    public function testReadForInvalidArgumentException()
    {
        $this -> expectException(QentaCEE_QMore_Exception_InvalidArgumentException::class);
        $object                    = new MockClient();
        $oQMoreDataStorageResponse = $object->setOrderIdent($this->sOrderIdent)->setReturnUrl($this->sReturnUrl)->initiate();
        $object->unsetCustomerId();
        $oQMoreDataStorageRead = $object->read();
    }

    public function testReadForBadMethodCallException()
    {
        $this -> expectException(QentaCEE_QMore_Exception_BadMethodCallException::class);
        $object                    = new MockClient();
        $oQMoreDataStorageResponse = $object->setOrderIdent($this->sOrderIdent)->setReturnUrl($this->sReturnUrl)->initiate();
        $object->unsetStorageId();
        $oQMoreDataStorageRead = $object->read();
    }

    public function testRead()
    {
        $oQMoreDataStorageResponse = $this->object->setOrderIdent($this->sOrderIdent)->setReturnUrl($this->sReturnUrl)->initiate();

        $oQMoreDataStorageRead = $this->object->read();

        $this->assertInstanceOf('QentaCEE_QMore_DataStorage_Response_Read', $oQMoreDataStorageRead);
        $this->assertEquals($oQMoreDataStorageRead->getStatus(), 0);
        $this->assertEmpty($oQMoreDataStorageRead->getErrors());
    }

    public function testGetPaymentInformationWithRead()
    {
        $oQMoreDataStorageResponse = $this->object->setOrderIdent($this->sOrderIdent)->setReturnUrl($this->sReturnUrl)->initiate();
        $sStorageId                = $oQMoreDataStorageResponse->getStorageId();

        $oQMoreDataStorageRead = $this->object->read();


        $this->assertInstanceOf('QentaCEE_QMore_DataStorage_Response_Read', $oQMoreDataStorageRead);
        $this->assertEquals($oQMoreDataStorageRead->getStatus(), 0);
        $this->assertEmpty($oQMoreDataStorageRead->getErrors());
        $this->assertEquals($oQMoreDataStorageRead->getStorageId(), $sStorageId);
    }

    public function testReaderResponseInitiation()
    {
        $oQMoreDataStorageResponse = $this->object->setOrderIdent($this->sOrderIdent)->setReturnUrl($this->sReturnUrl)->initiate();

        $this->assertInstanceOf('QentaCEE_QMore_DataStorage_Response_Initiation', $oQMoreDataStorageResponse);
        $this->assertEquals($oQMoreDataStorageResponse->getStatus(), 0);
    }

    public function testSetStorageId()
    {
        $sStorageId = '10763469b2b8049f6619c914e57faa19';

        $oQMoreDataStorageResponse = $this->object->setOrderIdent($this->sOrderIdent)->setReturnUrl($this->sReturnUrl)->setStorageId($sStorageId)->initiate();

        $this->assertInstanceOf('QentaCEE_QMore_DataStorage_Response_Initiation', $oQMoreDataStorageResponse);
        $this->assertEquals($oQMoreDataStorageResponse->getStatus(), 0);
        $this->assertEmpty($oQMoreDataStorageResponse->getErrors());
    }

    public function testDataStorageReader()
    {
        $oQMoreDataStorageResponse = $this->object->setOrderIdent($this->sOrderIdent)->setReturnUrl($this->sReturnUrl)->initiate();
        $oQMoreDataStorageRead     = $this->object->read();

        $this->assertInstanceOf('QentaCEE_QMore_DataStorage_Response_Read', $oQMoreDataStorageRead);
        $this->assertEquals($oQMoreDataStorageRead->getStatus(), 0);
        $this->assertEmpty($oQMoreDataStorageRead->getErrors());
        $this->assertNotEmpty($oQMoreDataStorageRead->getStorageId());
        $this->assertEquals(Array(), $oQMoreDataStorageRead->getPaymentInformation());
    }

    public function testConstructorWithInvalidParam()
    {
        $this -> expectException(Exception::class);
        $this->object = null;

        try {
            $this->object = new QentaCEE_QMore_DataStorageClient(array());
        } catch (Exception $e) {
            $this->assertStringStartsWith('CUSTOMER_ID passed', $e->getMessage());
            throw $e;
        }
    }

    /**
     * @dataProvider provider
     */
    public function testConstructorWhenLanguageParamIsEmpty($aConfig)
    {
        $this -> expectException(QentaCEE_QMore_Exception_InvalidArgumentException::class);
        $aConfig['QentaCEEQMoreConfig']['LANGUAGE'] = null;

        try {
            $this->object = new QentaCEE_QMore_DataStorageClient($aConfig);
        } catch (Exception $e) {
            $this->assertStringStartsWith('LANGUAGE passed to', $e->getMessage());
            throw $e;
        }
    }

    /**
     * @dataProvider provider
     */
    public function testConstructorWhenSecretParamIsEmpty($aConfig)
    {
        $this -> expectException(QentaCEE_QMore_Exception_InvalidArgumentException::class);
        $aConfig['QentaCEEQMoreConfig']['SECRET'] = null;

        try {
            $this->object = new QentaCEE_QMore_DataStorageClient($aConfig);
        } catch (Exception $e) {
            $this->assertStringStartsWith('SECRET passed to', $e->getMessage());
            throw $e;
        }
    }

    /**
     * @dataProvider provider
     */
    public function testConstructorWhenCustomerIdParamIsEmpty($aConfig)
    {
        $this -> expectException(QentaCEE_QMore_Exception_InvalidArgumentException::class);
        $aConfig['QentaCEEQMoreConfig']['CUSTOMER_ID'] = null;

        try {
            $this->object = new QentaCEE_QMore_DataStorageClient($aConfig);
        } catch (Exception $e) {
            $this->assertStringStartsWith('CUSTOMER_ID passed to', $e->getMessage());
            throw $e;
        }
    }

    /**
     * Provider function (dummy data)
     *
     * @return array
     */
    public function provider()
    {
        return Array(
            Array(
                Array(
                    'QentaCEEQMoreConfig' => Array(
                        'CUSTOMER_ID' => 'D200001',
                        'SHOP_ID'     => 'qmore',
                        'SECRET'      => 'B8AKTPWBRMNBV455FG6M2DANE99WU2',
                        'LANGUAGE'    => 'en'
                    )
                )
            )
        );
    }
}