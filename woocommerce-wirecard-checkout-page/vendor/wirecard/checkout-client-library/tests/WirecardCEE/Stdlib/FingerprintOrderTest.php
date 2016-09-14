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
class WirecardCEE_Stdlib_FingerprintOrderTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var WirecardCEE_Stdlib_FingerprintOrder
     */
    protected $object;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        $this->object = new WirecardCEE_Stdlib_FingerprintOrder();
        parent::setUp();
    }

    /**
     * @expectedException WirecardCEE_Stdlib_Exception_InvalidArgumentException
     */
    public function testContructorForException()
    {
        $object = new WirecardCEE_Stdlib_FingerprintOrder(new stdClass());
    }

    public function testSetOrderWithString()
    {
        $sData = "first,second,third";
        $this->assertTrue($this->object->setOrder($sData));
        $this->assertEquals(3, count($this->object));
    }

    public function testSetOrderWithArray()
    {
        $sData = Array("first", "second", "third");
        $this->assertTrue($this->object->setOrder($sData));
        $this->assertEquals(3, count($this->object));
    }

    public function testToString()
    {
        $sData        = "first,second,third";
        $this->object = new WirecardCEE_Stdlib_FingerprintOrder($sData);
        $this->assertEquals($sData, (string) $this->object);
    }

    public function testOffsetSet()
    {
        $this->object['foo'] = 'bar';
        $this->assertEquals('bar', $this->object->offsetGet('foo'));
    }

    public function testOffsetSetWithoutOffset()
    {
        $this->object[] = 'bar';
        $this->assertEquals('bar', $this->object->offsetGet(0));
    }

    public function testOffsetExists()
    {
        $this->object['foo'] = 'bar';
        $this->assertTrue($this->object->offsetExists('foo'));
    }

    public function testOffsetUnset()
    {
        $this->object['foo'] = 'bar';
        $this->object->offsetUnset('foo');
        $this->assertArrayNotHasKey('foo', (Array) $this->object);
    }

}

