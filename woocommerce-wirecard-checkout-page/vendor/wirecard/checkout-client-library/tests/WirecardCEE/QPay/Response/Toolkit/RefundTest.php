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
 * object test case.
 */
class WirecardCEE_QPay_Response_Toolkit_RefundTest extends PHPUnit_Framework_TestCase
{
    protected $_secret = 'B8AKTPWBRMNBV455FG6M2DANE99WU2';
    protected $_customerId = 'D200001';
    protected $_shopId = '';
    protected $_language = 'en';
    protected $_toolkitPassword = 'jcv45z';
    protected $_orderNumber = 123456;
    protected $_amount = '1.2';
    protected $_currency = 'USD';

    /**
     * @var WirecardCEE_QPay_Response_Toolkit_Refund
     */
    private $object;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->object = new WirecardCEE_QPay_ToolkitClient(Array(
            'CUSTOMER_ID'      => $this->_customerId,
            'SHOP_ID'          => $this->_shopId,
            'SECRET'           => $this->_secret,
            'LANGUAGE'         => $this->_language,
            'TOOLKIT_PASSWORD' => $this->_toolkitPassword
        ));
    }

    /**
     * Test getStatus()
     */
    public function testGetStatus()
    {
        $response = $this->object->refund($this->_orderNumber, $this->_amount, $this->_currency);
        $this->assertEquals($response->getStatus(), 0);
    }

    /**
     * Test getErrors()
     */
    public function testGetErrors()
    {
        $response = $this->object->refund($this->_orderNumber, $this->_amount, $this->_currency);
        $this->assertEmpty($response->getError());
    }

    /**
     * Test getCreditNumber()
     */
    public function testGetCreditNumber()
    {
        $response = $this->object->refund($this->_orderNumber, $this->_amount, $this->_currency);
        $this->assertInternalType('string', $response->getCreditNumber());
        $this->assertNotEquals('', $response->getCreditNumber());
    }

    /**
     * Test basket data
     */
    public function testWithBasketData()
    {
        $response = $this->object->refund($this->_orderNumber, $this->_amount, $this->_currency, $this->getValidBasket());
        $this->assertInternalType('string', $response->getCreditNumber());
        $this->assertNotEquals('', $response->getCreditNumber());
    }

    /**
     * Test hasFailed()
     */
    public function testHasNotFailed()
    {
        $response = $this->object->refund($this->_orderNumber, $this->_amount, $this->_currency);
        $this->assertFalse($response->hasFailed());
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->object = null;
        parent::tearDown();
    }

    /**
     * Creates a valid shopping basket.
     *
     * @return WirecardCEE_Stdlib_Basket
     */
    private function getValidBasket()
    {
        $basketItem = new WirecardCEE_Stdlib_Basket_Item('WirecardCEETestItem');
        $basketItem->setUnitGrossAmount(10)
            ->setUnitNetAmount(8)
            ->setUnitTaxAmount(2)
            ->setUnitTaxRate(20.0)
            ->setDescription('unittest description')
            ->setName('unittest name')
            ->setImageUrl('http://example.com/picture.png');

        $basket = new WirecardCEE_Stdlib_Basket();
        $basket->addItem($basketItem);

        return $basket;
    }
}

