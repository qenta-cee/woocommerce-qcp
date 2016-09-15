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
class WirecardCEE_QPay_Return_ReturnAbstractTestObject extends WirecardCEE_Stdlib_Return_ReturnAbstract
{
    public function validate()
    {
        return true;
    }
}

/**
 * Test class for WirecardCEE_Client_QPay_Return_Abstract.
 */
class WirecardCEE_QPay_Return_ReturnAbstractTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var WirecardCEE_QPay_Return_ReturnAbstractTestObject
     */
    protected $object;

    protected $_returnData = Array(
        'paymentState' => 'CANCEL'
    );

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new WirecardCEE_QPay_Return_ReturnAbstractTestObject($this->_returnData);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() { }

    public function testMagicGetPaymentState()
    {
        $this->assertEquals('CANCEL', $this->object->paymentState);
    }

    public function testPaymentState()
    {
        $this->assertEquals('', $this->object->getPaymentState());
    }

    public function testMagicGetNotSet()
    {
        $this->assertEquals(null, $this->object->invalid);
    }

    public function testValidate()
    {
        $this->assertTrue($this->object->validate());
    }

    public function testGetReturned()
    {
        $this->assertEquals($this->_returnData, $this->object->getReturned());
    }

    public function testGetReturnedButUnsetArrayFields()
    {
        $returnData                             = Array();
        $returnData['paymentState']             = 'CANCEL';
        $returnData['responseFingerprintOrder'] = 'TEST';
        $returnData['responseFingerprint']      = 'TEST';

        $object = new WirecardCEE_QPay_Return_ReturnAbstractTestObject($returnData);
        $object->getReturned();

        $this->assertFalse(isset( $this->_returnData['responseFingerprintOrder'] ));
        $this->assertFalse(isset( $this->_returnData['responseFingerprint'] ));
    }
}
