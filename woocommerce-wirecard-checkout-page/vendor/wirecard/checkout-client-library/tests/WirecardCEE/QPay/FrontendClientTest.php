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
 * WirecardCEE_QPayFrontendClient test case.
 */
class WirecardCEE_QPay_FrontendClientTest extends PHPUnit_Framework_TestCase
{
    /**
     *
     * @var array
     */
    protected $aUserConfig;

    /**
     *
     * @var array
     */
    protected $aClientConfig;

    /**
     *
     * @var WirecardCEE_QPay_FrontendClient
     */
    private $object;

    /**
     * @var array
     */
    protected $aExpectedRequestData;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->object               = new WirecardCEE_QPay_FrontendClient();
        $this->aUserConfig          = WirecardCEE_QPay_Module::getConfig();
        $this->aClientConfig        = WirecardCEE_QPay_Module::getClientConfig();
        $this->aExpectedRequestData = array(
            WirecardCEE_QPay_FrontendClient::CUSTOMER_ID => $this->aUserConfig['WirecardCEEQPayConfig']['CUSTOMER_ID'],
            WirecardCEE_QPay_FrontendClient::SHOP_ID => $this->aUserConfig['WirecardCEEQPayConfig']['SHOP_ID'],
            WirecardCEE_QPay_FrontendClient::LANGUAGE => $this->aUserConfig['WirecardCEEQPayConfig']['LANGUAGE'],
        );
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

    /**
     * @dataProvider provider
     */
    public function testConstructorArrayParam($aConfig)
    {
        $this->object = new WirecardCEE_QPay_FrontendClient($aConfig);
        $this->assertEquals($this->aUserConfig['WirecardCEEQPayConfig']['CUSTOMER_ID'],
            $this->object->getUserConfig()->get('CUSTOMER_ID'));
        $this->assertEquals($this->aUserConfig['WirecardCEEQPayConfig']['SHOP_ID'],
            $this->object->getUserConfig()->get('SHOP_ID'));
        $this->assertEquals($this->aUserConfig['WirecardCEEQPayConfig']['LANGUAGE'],
            $this->object->getUserConfig()->get('LANGUAGE'));
        $this->assertEquals($this->aUserConfig['WirecardCEEQPayConfig']['SECRET'],
            $this->object->getUserConfig()->get('SECRET'));
    }

    /**
     * Tests WirecardCEE_QPay_FrontendClient->setConfirmUrl()
     */
    public function testSetConfirmUrl()
    {
        $confirmUrl = 'http://foo.bar.com/tests/confirm.php';
        $this->object->setConfirmUrl($confirmUrl);

        $expected = array_merge($this->aExpectedRequestData, array(
            WirecardCEE_QPay_FrontendClient::CONFIRM_URL => $confirmUrl));
        $this->assertAttributeEquals($expected, '_requestData', $this->object);
    }

    /**
     * Tests WirecardCEE_QPay_FrontendClient->setWindowName()
     */
    public function testSetWindowName()
    {
        $windowName = 'phpUnitWindow';
        $this->object->setWindowName($windowName);

        $expected = array_merge($this->aExpectedRequestData, array(
            WirecardCEE_QPay_FrontendClient::WINDOW_NAME => $windowName));
        $this->assertAttributeEquals($expected, '_requestData', $this->object);
    }

    /**
     * Tests WirecardCEE_QPay_FrontendClient->setDuplicateRequestCheck()
     */
    public function testSetDuplicateRequestCheck()
    {
        $duplicateRequestCheck = 'yes';
        $this->object->setDuplicateRequestCheck($duplicateRequestCheck);

        $expected = array_merge($this->aExpectedRequestData, array(
            WirecardCEE_QPay_FrontendClient::DUPLICATE_REQUEST_CHECK => $duplicateRequestCheck));
        $this->assertAttributeEquals($expected, '_requestData', $this->object);
    }

    /**
     * Tests WirecardCEE_QPay_FrontendClient->setCustomerStatement()
     */
    public function testSetCustomerStatement()
    {
        $customerStatement = 'cStatement';
        $this->object->setCustomerStatement($customerStatement);

        $expected = array_merge($this->aExpectedRequestData, array(
            WirecardCEE_QPay_FrontendClient::CUSTOMER_STATEMENT => $customerStatement));
        $this->assertAttributeEquals($expected, '_requestData', $this->object);
    }

    /**
     * Tests WirecardCEE_QPay_FrontendClient->setOrderReference()
     */
    public function testSetOrderReference()
    {
        $orderReference = '123333';
        $this->object->setOrderReference($orderReference);

        $expected = array_merge($this->aExpectedRequestData, array(
            WirecardCEE_QPay_FrontendClient::ORDER_REFERENCE => $orderReference));
        $this->assertAttributeEquals($expected, '_requestData', $this->object);
    }

    /**
     * Tests WirecardCEE_QPay_FrontendClient->setAutoDeposit()
     */
    public function testSetAutoDeposit()
    {
        $autoDeposit = 'yes';
        $this->object->setAutoDeposit($autoDeposit);

        $expected = array_merge($this->aExpectedRequestData, array(
            WirecardCEE_QPay_FrontendClient::AUTO_DEPOSIT => $autoDeposit));
        $this->assertAttributeEquals($expected, '_requestData', $this->object);
    }

    /**
     * Tests WirecardCEE_QPay_FrontendClient->setMaxRetries()
     */
    public function testSetMaxRetries()
    {
        $maxRetries = '12';
        $this->object->setMaxRetries($maxRetries);

        $expected = array_merge($this->aExpectedRequestData, array(
            WirecardCEE_QPay_FrontendClient::MAX_RETRIES => $maxRetries));
        $this->assertAttributeEquals($expected, '_requestData', $this->object);

    }

    /**
     * Tests WirecardCEE_QPay_FrontendClient->createConsumerMerchantCrmId()
     */
    public function testCreateConsumerMerchantCrmId()
    {
        $email = 'email@address.com';
        $this->object->createConsumerMerchantCrmId($email);

        $expected = array_merge($this->aExpectedRequestData, array(
            WirecardCEE_QPay_FrontendClient::CONSUMER_MERCHANT_CRM_ID => md5($email)));
        $this->assertAttributeEquals($expected, '_requestData', $this->object);
    }

    /**
     * Tests WirecardCEE_QPay_FrontendClient->createConsumerMerchantCrmId()
     */
    public function testSetShippingProfile()
    {
        $shippingProfile = 'SP_00001';
        $this->object->setShippingProfile($shippingProfile);

        $expected = array_merge($this->aExpectedRequestData, array(
            WirecardCEE_QPay_FrontendClient::SHIPPING_PROFILE => 'SP_00001'
        ));
        $this->assertAttributeEquals($expected, '_requestData', $this->object);
    }

    /**
     * Tests WirecardCEE_QPay_FrontendClient->setMaxRetries()
     */
    public function testSetOrderNumber()
    {
        $orderNumber = '123321';
        $this->object->setOrderNumber($orderNumber);

        $expected = array_merge($this->aExpectedRequestData, array(
            WirecardCEE_QPay_FrontendClient::ORDER_NUMBER => $orderNumber));
        $this->assertAttributeEquals($expected, '_requestData', $this->object);
    }

    /**
     * Tests WirecardCEE_QPay_FrontendClient->setConfirmMail()
     */
    public function testSetConfirmMail()
    {
        $confirmMail = 'test@example.com';
        $this->object->setConfirmMail($confirmMail);

        $expected = array_merge($this->aExpectedRequestData, array(
            WirecardCEE_QPay_FrontendClient::CONFIRM_MAIL => $confirmMail));
        $this->assertAttributeEquals($expected, '_requestData', $this->object);
    }

    /**
     * Tests WirecardCEE_QPay_FrontendClient->setBasket()
     */
    public function testSetBasket()
    {
        $mock = $this->getMockBuilder('WirecardCEE_Stdlib_Basket')
            ->getMock();

        $mock->expects($this->once())
            ->method('getData')
            ->will($this->returnValue(array()));

        $this->object->setBasket($mock);
    }

    /**
     * Tests WirecardCEE_QPay_FrontendClient->initiate()
     */
    public function testInitiate()
    {
        $consumerData = new WirecardCEE_Stdlib_ConsumerData();
        $consumerData->setIpAddress('10.1.0.11');
        $consumerData->setUserAgent('phpUnit');

        $oResponse = $this->object->setAmount(100)
                                  ->setCurrency('eur')
                                  ->setPaymentType(WirecardCEE_QPay_PaymentType::PAYPAL)
                                  ->setOrderDescription(__METHOD__)
                                  ->setSuccessUrl('http://foo.bar.com/tests/confirm.php')
                                  ->setCancelUrl('http://foo.bar.com/tests/confirm.php')
                                  ->setFailureUrl('http://foo.bar.com/tests/confirm.php')
                                  ->setServiceUrl('http://foo.bar.com/tests/confirm.php')
                                  ->setConfirmUrl('http://foo.bar.com/tests/confirm.php')
                                  ->setConsumerData($consumerData)
                                  ->initiate();

        $this->assertInstanceOf('WirecardCEE_QPay_Response_Initiation', $oResponse);
        $this->assertEquals($oResponse->getStatus(), 0);
        $this->assertFalse($oResponse->getError());
        $this->assertFalse($oResponse->hasFailed());
        $this->assertStringStartsWith('https://', $oResponse->getRedirectUrl());
    }

    /**
     * @expectedException WirecardCEE_Stdlib_Exception_InvalidResponseException
     */
    public function testClientFailedResponse()
    {
        $oResponse = new WirecardCEE_QPay_Response_Initiation(new stdClass());
    }

    /**
     * Tests WirecardCEE_QPay_FrontendClient->__construct()
     *
     * @dataProvider provider
     * @expectedException WirecardCEE_QPay_Exception_InvalidArgumentException
     *
     * @param string $aConfig
     */
    public function testMissingConfigValueInConfigArray($aConfig)
    {
        $aConfig['WirecardCEEQPayConfig']['CUSTOMER_ID'] = null;
        $this->object                                    = new WirecardCEE_QPay_FrontendClient($aConfig);

    }

    /**
     *
     * @expectedException WirecardCEE_QPay_Exception_InvalidArgumentException
     */
    public function testFailedInitiate()
    {
        $oResponse = $this->object->initiate();
    }

    /**
     * @expectedException Exception
     */
    public function testGetReponseBeforeInitialize()
    {
        $oResponse = $this->object->getResponse();
    }

    /**
     * Tests WirecardCEE_QPay_FrontendClient->getResponse()
     */
    public function testGetResponse()
    {
        $consumerData = new WirecardCEE_Stdlib_ConsumerData();
        $consumerData->setIpAddress('10.1.0.11');
        $consumerData->setUserAgent('phpUnit');

        $oResponse = $this->object->setAmount(100)
                                  ->setCurrency('eur')
                                  ->setPaymentType(WirecardCEE_QPay_PaymentType::PAYPAL)
                                  ->setOrderDescription(__METHOD__)
                                  ->setSuccessUrl('http://foo.bar.com/tests/confirm.php')
                                  ->setCancelUrl('http://foo.bar.com/tests/confirm.php')
                                  ->setFailureUrl('http://foo.bar.com/tests/confirm.php')
                                  ->setServiceUrl('http://foo.bar.com/tests/confirm.php')
                                  ->setConfirmUrl('http://foo.bar.com/tests/confirm.php')
                                  ->setConsumerData($consumerData)
                                  ->initiate();

        $oResponse = $this->object->getResponse();

        $this->assertInstanceOf('WirecardCEE_QPay_Response_Initiation', $oResponse);
        $this->assertEquals($oResponse->getStatus(), 0);
        $this->assertFalse($oResponse->getError());
        $this->assertFalse($oResponse->hasFailed());
        $this->assertStringStartsWith('https://', $oResponse->getRedirectUrl());
    }

    /**
     * @expectedException Exception
     */
    public function testConstructorWithInvalidParam()
    {
        $this->object = null;

        try {
            $this->object = new WirecardCEE_QPay_FrontendClient(array());
        } catch (Exception $e) {
            $this->assertStringStartsWith('CUSTOMER_ID passed', $e->getMessage());
            throw $e;
        }
    }

    /**
     * @dataProvider provider
     * @expectedException WirecardCEE_QPay_Exception_InvalidArgumentException
     */
    public function testConstructorWhenLanguageParamIsEmpty($aConfig)
    {
        $aConfig['WirecardCEEQPayConfig']['LANGUAGE'] = null;

        try {
            $this->object = new WirecardCEE_QPay_FrontendClient($aConfig);
        } catch (WirecardCEE_QPay_Exception_InvalidArgumentException $e) {
            $this->assertStringStartsWith('LANGUAGE passed to', $e->getMessage());
            throw $e;
        }
    }

    /**
     * @dataProvider provider
     * @expectedException WirecardCEE_QPay_Exception_InvalidArgumentException
     */
    public function testConstructorWhenSecretParamIsEmpty($aConfig)
    {
        $aConfig['WirecardCEEQPayConfig']['SECRET'] = null;

        try {
            $this->object = new WirecardCEE_QPay_FrontendClient($aConfig);
        } catch (WirecardCEE_QPay_Exception_InvalidArgumentException $e) {
            $this->assertStringStartsWith('SECRET passed to', $e->getMessage());
            throw $e;
        }
    }

    /**
     * Tests WirecardCEE_QPay_FrontendClient->getResponse()
     */
    public function testSetPluginVersion()
    {
        $sPluginVersion = $this->object->generatePluginVersion('phpunit', '1.0.0', 'phpunit', '1.0.0',
            Array('phpunit' => '3.5.15'));
        $this->object->setPluginVersion($sPluginVersion);

        $expected = array_merge($this->aExpectedRequestData, array(
            WirecardCEE_QPay_FrontendClient::PLUGIN_VERSION => $sPluginVersion));
        $this->assertAttributeEquals($expected, '_requestData', $this->object);
    }

    public function testSetFinancialInstitution()
    {
        $sFinancialInstitution = 'BA-CA';
        $this->object->setFinancialInstitution($sFinancialInstitution);

        $expected = array_merge($this->aExpectedRequestData, array(
            WirecardCEE_QPay_FrontendClient::FINANCIAL_INSTITUTION => $sFinancialInstitution));
        $this->assertAttributeEquals($expected, '_requestData', $this->object);
    }

    public function testDisplayTextAndImageUrl()
    {
        $this->object->setDisplayText('display text')->setImageUrl('https://www.google.com/intl/en_ALL/images/logos/images_logo_lg.gif');
    }


    public function provider()
    {
        return Array(
            Array(
                Array(
                    'WirecardCEEQPayConfig' => Array(
                        'CUSTOMER_ID' => 'D200001',
                        'SHOP_ID'     => '',
                        'SECRET'      => 'B8AKTPWBRMNBV455FG6M2DANE99WU2',
                        'LANGUAGE'    => 'en'
                    )
                )
            )
        );
    }

}
