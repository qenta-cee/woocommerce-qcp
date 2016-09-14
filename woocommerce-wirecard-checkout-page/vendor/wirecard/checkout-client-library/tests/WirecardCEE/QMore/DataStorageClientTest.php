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
class MockClient extends WirecardCEE_QMore_DataStorageClient
{
    public function unsetCustomerId()
    {
        $this->_setField(WirecardCEE_Stdlib_Client_ClientAbstract::CUSTOMER_ID, null);
    }

    public function unsetStorageId()
    {
        $this->oInitResponse = null;
        $this->_setField(WirecardCEE_QMore_DataStorageClient::STORAGE_ID, null);
    }
}

/**
 * WirecardCEE_QMore_FrontendClient test case.
 */
class WirecardCEE_QMore_DataStorageClientTest extends PHPUnit_Framework_TestCase
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
     * @var WirecardCEE_QMore_DataStorageClient
     */
    private $object;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->object        = new WirecardCEE_QMore_DataStorageClient();
        $this->aUserConfig   = WirecardCEE_QMore_Module::getConfig();
        $this->aClientConfig = WirecardCEE_QMore_Module::getClientConfig();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->object        = null;
        $this->aUserConfig   = null;
        $this->aClientConfig = null;
        unset( $this );
        parent::tearDown();
    }

    public function testInitiate()
    {
        $oQMoreDataStorageResponse = $this->object->setOrderIdent($this->sOrderIdent)->setReturnUrl($this->sReturnUrl)->initiate();

        $this->assertInstanceOf('WirecardCEE_QMore_DataStorage_Response_Initiation', $oQMoreDataStorageResponse);
        $this->assertEquals($oQMoreDataStorageResponse->getStatus(), 0);
        $this->assertEmpty($oQMoreDataStorageResponse->getErrors());
    }

    /**
     * @expectedException WirecardCEE_QMore_Exception_InvalidArgumentException
     */
    public function testInitiateForException()
    {
        $oQMoreDataStorageResponse = $this->object->setOrderIdent(null)->setReturnUrl($this->sReturnUrl)->initiate();
    }

    /**
     * @expectedException WirecardCEE_QMore_Exception_InvalidArgumentException
     */
    public function testReadForInvalidArgumentException()
    {
        $object                    = new MockClient();
        $oQMoreDataStorageResponse = $object->setOrderIdent($this->sOrderIdent)->setReturnUrl($this->sReturnUrl)->initiate();
        $object->unsetCustomerId();
        $oQMoreDataStorageRead = $object->read();
    }

    /**
     * @expectedException WirecardCEE_QMore_Exception_BadMethodCallException
     */
    public function testReadForBadMethodCallException()
    {
        $object                    = new MockClient();
        $oQMoreDataStorageResponse = $object->setOrderIdent($this->sOrderIdent)->setReturnUrl($this->sReturnUrl)->initiate();
        $object->unsetStorageId();
        $oQMoreDataStorageRead = $object->read();
    }

    public function testRead()
    {
        $oQMoreDataStorageResponse = $this->object->setOrderIdent($this->sOrderIdent)->setReturnUrl($this->sReturnUrl)->initiate();

        $oQMoreDataStorageRead = $this->object->read();

        $this->assertInstanceOf('WirecardCEE_QMore_DataStorage_Response_Read', $oQMoreDataStorageRead);
        $this->assertEquals($oQMoreDataStorageRead->getStatus(), 0);
        $this->assertEmpty($oQMoreDataStorageRead->getErrors());
    }

    public function testGetPaymentInformationWithRead()
    {
        $oQMoreDataStorageResponse = $this->object->setOrderIdent($this->sOrderIdent)->setReturnUrl($this->sReturnUrl)->initiate();
        $sStorageId                = $oQMoreDataStorageResponse->getStorageId();

        $oQMoreDataStorageRead = $this->object->read();


        $this->assertInstanceOf('WirecardCEE_QMore_DataStorage_Response_Read', $oQMoreDataStorageRead);
        $this->assertEquals($oQMoreDataStorageRead->getStatus(), 0);
        $this->assertEmpty($oQMoreDataStorageRead->getErrors());
        $this->assertEquals($oQMoreDataStorageRead->getStorageId(), $sStorageId);
    }

    public function testReaderResponseInitiation()
    {
        $oQMoreDataStorageResponse = $this->object->setOrderIdent($this->sOrderIdent)->setReturnUrl($this->sReturnUrl)->initiate();

        $this->assertInstanceOf('WirecardCEE_QMore_DataStorage_Response_Initiation', $oQMoreDataStorageResponse);
        $this->assertEquals($oQMoreDataStorageResponse->getStatus(), 0);
    }

    public function testSetStorageId()
    {
        $sStorageId = '10763469b2b8049f6619c914e57faa19';

        $oQMoreDataStorageResponse = $this->object->setOrderIdent($this->sOrderIdent)->setReturnUrl($this->sReturnUrl)->setStorageId($sStorageId)->initiate();

        $this->assertInstanceOf('WirecardCEE_QMore_DataStorage_Response_Initiation', $oQMoreDataStorageResponse);
        $this->assertEquals($oQMoreDataStorageResponse->getStatus(), 0);
        $this->assertEmpty($oQMoreDataStorageResponse->getErrors());
    }

    public function testDataStorageReader()
    {
        $oQMoreDataStorageResponse = $this->object->setOrderIdent($this->sOrderIdent)->setReturnUrl($this->sReturnUrl)->initiate();
        $oQMoreDataStorageRead     = $this->object->read();

        $this->assertInstanceOf('WirecardCEE_QMore_DataStorage_Response_Read', $oQMoreDataStorageRead);
        $this->assertEquals($oQMoreDataStorageRead->getStatus(), 0);
        $this->assertEmpty($oQMoreDataStorageRead->getErrors());
        $this->assertNotEmpty($oQMoreDataStorageRead->getStorageId());
        $this->assertEquals(Array(), $oQMoreDataStorageRead->getPaymentInformation());
    }

    /**
     * @expectedException Exception
     */
    public function testConstructorWithInvalidParam()
    {
        $this->object = null;

        try {
            $this->object = new WirecardCEE_QMore_DataStorageClient(array());
        } catch (Exception $e) {
            $this->assertStringStartsWith('CUSTOMER_ID passed', $e->getMessage());
            throw $e;
        }
    }

    /**
     * @dataProvider provider
     * @expectedException WirecardCEE_QMore_Exception_InvalidArgumentException
     */
    public function testConstructorWhenLanguageParamIsEmpty($aConfig)
    {
        $aConfig['WirecardCEEQMoreConfig']['LANGUAGE'] = null;

        try {
            $this->object = new WirecardCEE_QMore_DataStorageClient($aConfig);
        } catch (Exception $e) {
            $this->assertStringStartsWith('LANGUAGE passed to', $e->getMessage());
            throw $e;
        }
    }

    /**
     * @dataProvider provider
     * @expectedException WirecardCEE_QMore_Exception_InvalidArgumentException
     */
    public function testConstructorWhenSecretParamIsEmpty($aConfig)
    {
        $aConfig['WirecardCEEQMoreConfig']['SECRET'] = null;

        try {
            $this->object = new WirecardCEE_QMore_DataStorageClient($aConfig);
        } catch (Exception $e) {
            $this->assertStringStartsWith('SECRET passed to', $e->getMessage());
            throw $e;
        }
    }

    /**
     * @dataProvider provider
     * @expectedException WirecardCEE_QMore_Exception_InvalidArgumentException
     */
    public function testConstructorWhenCustomerIdParamIsEmpty($aConfig)
    {
        $aConfig['WirecardCEEQMoreConfig']['CUSTOMER_ID'] = null;

        try {
            $this->object = new WirecardCEE_QMore_DataStorageClient($aConfig);
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
                    'WirecardCEEQMoreConfig' => Array(
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