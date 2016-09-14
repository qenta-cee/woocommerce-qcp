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
class TestClient extends WirecardCEE_Stdlib_Client_ClientAbstract
{
    public function __construct($aConfig = null)
    {
        $this->oClientConfig = $aConfig;
    }

    public function setField($name, $value)
    {
        parent::_setField($name, $value);
    }

    public function _getUserAgent()
    {
        return __CLASS__;
    }

    public function _getRequestUrl()
    {
        return "http://www.google.at";
    }

    public function getHttpClient()
    {
        return $this->_getHttpClient();
    }
}

class WirecardCEE_Stdlib_Client_ClientAbstractTest extends PHPUnit_Framework_TestCase
{

    protected $object;

    public function setUp()
    {
        $this->object = new TestClient(WirecardCEE_Stdlib_Module::getClientConfig());
    }

    public function testSetZendHttpClient()
    {
        $this->object->setHttpClient(new GuzzleHttp\Client());
        $this->assertInstanceOf('GuzzleHttp\Client', $this->object->getHttpClient());
    }

    public function testClientConfig()
    {
        $_oClientConfig = $this->object->getClientConfig();
        $this->assertArrayHasKey('MODULE_NAME', $_oClientConfig);
        $this->assertArrayHasKey('MODULE_VERSION', $_oClientConfig);
        $this->assertArrayHasKey('DEPENDENCIES', $_oClientConfig);
    }

    public function testUserAgentString()
    {
        $sUserAgent = $this->object->getUserAgentString();
        $this->assertContains(get_class($this->object), $sUserAgent);
        $this->assertContains('WirecardCEE_Stdlib', $sUserAgent);
    }

    public function testGetRequestData()
    {
        $this->object->setField('field1', 'value1');
        $this->object->setField('field2', 'value2');
        $this->object->setField('field3', 'value3');

        $this->assertInternalType('array', $this->object->getRequestData());
        $this->assertEquals(3, count($this->object->getRequestData()));
    }

    public function tearDown()
    {
        unset( $this->object );
    }

}