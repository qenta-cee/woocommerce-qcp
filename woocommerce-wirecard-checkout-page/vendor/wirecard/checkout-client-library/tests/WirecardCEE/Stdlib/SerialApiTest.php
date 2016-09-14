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
class WirecardCEE_Stdlib_SerialApiTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider oneLevelProvider
     */
    public function testEncodeOneLevel($data, $expected)
    {
        $serializedString = WirecardCEE_Stdlib_SerialApi::encode($data);
        $this->assertEquals($expected, $serializedString,
            'SerialApi encode failed. Result: ' . $serializedString . ' Expected Value: ' . $expected);
    }

    /**
     * @dataProvider oneLevelProvider
     */
    public function testDecodeOneLevel($expected, $data)
    {
        foreach ($expected as $key => $value) {
            $expected[(string) $key] = (string) $value;
        }

        $unserialized = WirecardCEE_Stdlib_SerialApi::decode($data);
        $this->assertEquals($expected, $unserialized, 'SerialApi decode failed. Data: ' . $data);
    }

    /**
     * @dataProvider multiLevelProvider
     */
    public function testEncodeMultiLevel($data, $expected)
    {

        $serializedString = WirecardCEE_Stdlib_SerialApi::encode($data);
        $this->assertEquals($expected, $serializedString,
            'SerialApi encode failed. Result: ' . $serializedString . ' Expected Value: ' . $expected);
    }

    /**
     * @dataProvider multiLevelProvider
     */
    public function testDecodeMultiLevel($expected, $data)
    {
        $unserialized = WirecardCEE_Stdlib_SerialApi::decode($data);
        $this->assertEquals($expected, $unserialized, 'SerialApi decode failed.');
    }

    /**
     * @expectedException WirecardCEE_Stdlib_Exception_InvalidTypeException
     */
    public function testInvalidEncodeValue()
    {
        try {
            WirecardCEE_Stdlib_SerialApi::encode('stringValue');
        } catch (WirecardCEE_Stdlib_Exception_InvalidTypeException $e) {
            $this->assertEquals('Invalid type for WirecardCEE_Stdlib_SerialApi::encode. Array must be given.',
                $e->getMessage());
            throw $e;
        }
    }

    /**
     * @expectedException WirecardCEE_Stdlib_Exception_InvalidFormatException
     */
    public function testinvalidDecodeFormat()
    {
        try {
            WirecardCEE_Stdlib_SerialApi::decode('test=test=test');
        } catch (WirecardCEE_Stdlib_Exception_InvalidFormatException $e) {
            $this->assertEquals('Invalid format for WirecardCEE_Stdlib_SerialApi::decode. Expecting key=value pairs',
                $e->getMessage());
            throw $e;
        }
    }

    public function oneLevelProvider()
    {
        $testObj = new SerialApiTestClass();

        return Array(
            Array(
                'decoded' => Array(
                    'testKey' => 'testValue'
                ),
                'encoded' => 'testKey=testValue'
            ),
            Array(
                'decoded' => Array(
                    'testKey1' => 'testValue1',
                    'testKey2' => 'testValue2'
                ),
                'encoded' => 'testKey1=testValue1&testKey2=testValue2'
            ),
            Array(
                'decoded' => Array(
                    'testKey1' => $testObj,
                    'testing'  => 1
                ),
                'encoded' => 'testKey1=' . (string) $testObj . '&testing=1'
            ),
            Array(
                'decoded' => Array(
                    'a',
                    'b',
                    'c'
                ),
                'encoded' => '1=a&2=b&3=c'
            ),
            Array(
                'decoded' => Array(
                    'testKeyÄncode' => 'äö +ü#'
                ),
                'encoded' => urlencode('testKeyÄncode') . '=' . urlencode('äö +ü#')
            ),
            Array(
                'decoded' => Array(),
                'encoded' => ''
            )
        );
    }

    public function multiLevelProvider()
    {
        $testObj = new SerialApiTestClass();

        return Array(
            Array(
                'decoded' => Array(
                    'testArr' => Array(
                        'testKey1' => 'testValue1'
                    )
                ),
                'encoded' => 'testArr.testKey1=testValue1'
            ),
            Array(
                'decoded' => Array(
                    'orders'   => Array(
                        'orderNumber' => 1234,
                        'paymentType' => 'CCARD'
                    ),
                    'payments' => Array(
                        Array(
                            'paymentNumber'     => 1234,
                            'orderNumber'       => 1234,
                            'paymentType'       => 'CCARD',
                            'operationsAllowed' => Array(
                                'none',
                                'none1',
                                'none2'
                            )
                        ),
                        Array(
                            'paymentNumber' => 4321,
                            'orderNumber'   => 1234,
                            'paymentType'   => 'CCARD'
                        )
                    )
                ),
                'encoded' => 'orders.orderNumber=1234&orders.paymentType=CCARD&payments.1.paymentNumber=1234&payments.1.orderNumber=1234&payments.1.paymentType=CCARD&payments.1.operationsAllowed=none,none1,none2&payments.2.paymentNumber=4321&payments.2.orderNumber=1234&payments.2.paymentType=CCARD'
            ),
            Array(
                'decoded' => Array(
                    'testArr' => Array(
                        Array(
                            Array(
                                Array(
                                    'entry',
                                    'entry2' => 'value'
                                )
                            )
                        )
                    )
                ),
                'encoded' => 'testArr.1.1.1.1=entry&testArr.1.1.1.entry2=value'
            ),
            Array(
                'decoded' => Array(
                    'test'
                ),
                'encoded' => '1=test'
            ),
            Array(
                'decoded' => Array(
                    'test' => 'test'
                ),
                'encoded' => 'test=test'
            ),
            Array(
                'decoded' => Array(
                    'testKey' => Array(
                        'a',
                        'b',
                        'c'
                    )
                ),
                'encoded' => 'testKey=a,b,c'
            ),
            Array(
                'decoded' => Array(
                    'testKey'  => Array(
                        'a',
                        'b',
                        'c'
                    ),
                    'testKey1' => Array(
                        'b',
                        'c',
                        'd'
                    ),
                    'testKey2' => 'testValue'
                ),
                'encoded' => 'testKey=a,b,c&testKey1=b,c,d&testKey2=testValue'
            ),
            Array(
                'decoded' => Array(
                    'testKey'  => Array(
                        'a',
                        'b',
                        'c'
                    ),
                    'testKey1' => Array(
                        'b',
                        'c',
                        'd'
                    ),
                    'testKey2' => Array(
                        'key1' => 'value1',
                        'key2' => 'value2'
                    )
                ),
                'encoded' => 'testKey=a,b,c&testKey1=b,c,d&testKey2.key1=value1&testKey2.key2=value2'
            ),
            Array(
                'decoded' => Array(
                    'testKey'  => Array(
                        'a',
                        'b',
                        'c' => 'c'
                    ),
                    'testKey1' => Array(
                        'b',
                        'c',
                        'd'
                    ),
                    'testKey2' => Array(
                        'key1' => 'value1',
                        'key2' => 'value2'
                    )
                ),
                'encoded' => 'testKey=a,b&testKey.c=c&testKey1=b,c,d&testKey2.key1=value1&testKey2.key2=value2'
            ),
            Array(
                'decoded' => Array(
                    'testKey'  => Array(
                        'a',
                        'b',
                        'c' => Array(
                            'z',
                            'y',
                            'x'
                        )
                    ),
                    'testKey1' => Array(
                        'b',
                        'c',
                        'd'
                    ),
                    'testKey2' => Array(
                        'key1' => 'value1',
                        'key2' => 'value2'
                    )
                ),
                'encoded' => 'testKey=a,b&testKey.c=z,y,x&testKey1=b,c,d&testKey2.key1=value1&testKey2.key2=value2'
            ),
            Array(
                'decoded' => Array(
                    'testKey' => Array(
                        Array(
                            Array(
                                'bla'  => 'blub',
                                'bla1' => 'blub1',
                                'bla2'
                            )
                        )
                    )
                ),
                'encoded' => 'testKey.1.1.bla=blub&testKey.1.1.bla1=blub1&testKey.1.1.1=bla2'
            )
        );
    }
}

class SerialApiTestClass
{

    public function __toString()
    {
        return 'testString';
    }
}
