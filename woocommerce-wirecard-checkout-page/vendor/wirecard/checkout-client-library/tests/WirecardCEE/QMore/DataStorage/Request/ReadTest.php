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
 * WirecardCEE_QMore_DataStorage_Request_Read test case.
 */
class WirecardCEE_QMore_DataStorage_Request_ReadTest extends PHPUnit_Framework_TestCase
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
     * @var WirecardCEE_QMore_DataStorage_Request_Read
     */
    private $object;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->object = new WirecardCEE_QMore_DataStorage_Request_Read();

    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->object = null;
        parent::tearDown();
    }

    public function testRead()
    {
        $oClient                   = new WirecardCEE_QMore_DataStorageClient();
        $oQMoreDataStorageResponse = $oClient->setOrderIdent($this->sOrderIdent)->setReturnUrl($this->sReturnUrl)->initiate();
        $sStorageId                = $oQMoreDataStorageResponse->getStorageId();
        $oQMoreDataStorageRead     = $this->object->read($sStorageId);

        $this->assertInstanceOf('WirecardCEE_QMore_DataStorage_Response_Read', $oQMoreDataStorageRead);
        $this->assertEquals($oQMoreDataStorageRead->getStatus(), 0);
        $this->assertEquals($oQMoreDataStorageRead->getStorageId(), $sStorageId);
        $this->assertEmpty($oQMoreDataStorageRead->getErrors());
    }

    /**
     * @expectedException WirecardCEE_QMore_DataStorage_Exception_InvalidArgumentException
     */
    public function testWithNoCustomerId()
    {
        $this->object = new WirecardCEE_QMore_DataStorage_Request_Read(Array(
            'WirecardCEEQMoreConfig' => Array(
                'CUSTOMER_ID' => '',
                'SHOP_ID'     => '',
                'SECRET'      => 'B8AKTPWBRMNBV455FG6M2DANE99WU2',
                'LANGUAGE'    => 'en'
            )
        ));
    }

    /**
     * @expectedException WirecardCEE_QMore_DataStorage_Exception_InvalidArgumentException
     */
    public function testWithNoSecret()
    {
        $this->object = new WirecardCEE_QMore_DataStorage_Request_Read(Array(
            'WirecardCEEQMoreConfig' => Array(
                'CUSTOMER_ID' => 'D200001',
                'SHOP_ID'     => '',
                'SECRET'      => '',
                'LANGUAGE'    => 'en'
            )
        ));
    }

    /**
     * @expectedException WirecardCEE_QMore_DataStorage_Exception_InvalidArgumentException
     */
    public function testWithNoLanguage()
    {
        $this->object = new WirecardCEE_QMore_DataStorage_Request_Read(Array(
            'WirecardCEEQMoreConfig' => Array(
                'CUSTOMER_ID' => 'D200001',
                'SHOP_ID'     => '',
                'SECRET'      => 'B8AKTPWBRMNBV455FG6M2DANE99WU2',
                'LANGUAGE'    => ''
            )
        ));
    }

}

