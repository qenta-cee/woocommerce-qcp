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
class WirecardCEE_Stdlib_FingerprintTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        // set default value
        WirecardCEE_Stdlib_Fingerprint::stripSlashes(false);
    }

    public function testSetStripSlashes()
    {
        WirecardCEE_Stdlib_Fingerprint::stripSlashes(true);
    }

    /**
     * @dataProvider fingerprintProvider
     */
    public function testGenerate($values, $fingerprintOrder, $hash)
    {
        WirecardCEE_Stdlib_Fingerprint::setHashAlgorithm(WirecardCEE_Stdlib_Fingerprint::HASH_ALGORITHM_HMAC_SHA512);
        $this->assertEquals($hash, WirecardCEE_Stdlib_Fingerprint::generate($values,
            new WirecardCEE_Stdlib_FingerprintOrder($fingerprintOrder)));
    }

    /**
     * @dataProvider fingerprintProvider
     */
    public function testGenerateStripSlashes($values, $fingerprintOrder, $hash)
    {
        WirecardCEE_Stdlib_Fingerprint::stripSlashes(true);
        $this->assertEquals($hash, WirecardCEE_Stdlib_Fingerprint::generate($values,
            new WirecardCEE_Stdlib_FingerprintOrder($fingerprintOrder)));
    }

    /**
     * @dataProvider fingerprintProvider
     * @expectedException WirecardCEE_Stdlib_Exception_InvalidValueException
     */
    public function testGenerateException($values, $fingerprintOrder, $hash)
    {
        $fingerprintOrder[] = 'FailKey';
        try {
            WirecardCEE_Stdlib_Fingerprint::generate($values,
                new WirecardCEE_Stdlib_FingerprintOrder($fingerprintOrder));
        } catch (WirecardCEE_Stdlib_Exception_InvalidValueException $e) {
            $this->assertEquals('Value for key FAILKEY not found in values array.', $e->getMessage());
            throw $e;
        }
    }

    /**
     * @dataProvider fingerprintProvider
     */
    public function testCompare($values, $fingerprintOrder, $hash)
    {
        $this->assertTrue(WirecardCEE_Stdlib_Fingerprint::compare($values,
            new WirecardCEE_Stdlib_FingerprintOrder($fingerprintOrder), $hash));
    }

    /**
     * @dataProvider fingerprintProvider
     */
    public function testCompareStripSlashes($values, $fingerprintOrder, $hash)
    {
        WirecardCEE_Stdlib_Fingerprint::stripSlashes(true);
        $this->assertTrue(WirecardCEE_Stdlib_Fingerprint::compare($values,
            new WirecardCEE_Stdlib_FingerprintOrder($fingerprintOrder), $hash));
    }

    /**
     * @dataProvider fingerprintProvider
     */
    public function testFalseCompare($values, $fingerprintOrder, $hash)
    {
        $hash = md5($hash);
        $this->assertFalse(WirecardCEE_Stdlib_Fingerprint::compare($values,
            new WirecardCEE_Stdlib_FingerprintOrder($fingerprintOrder), $hash));
    }

    public static function fingerprintProvider()
    {
        return Array(
            Array(
                'values'           => Array(
                    'key1' => 'value1',
                    'key2' => 'value2',
                    'key3' => 'value3',
                    'key4' => 'value4'
                ),
                'fingerprintOrder' => Array(
                    'key1',
                    'key2',
                    'key3',
                    'key4'
                ),
                'hash'             => 'f764ead22e1dac1ba942b0b7476ea8d1e92d3dd0d17c43d5a6c79d844fb19a192d1008a92a7b06a783ca347c336ee8afd31eb693830e7a72e279b099ff5797e5'
            ),
            Array(
                'values'           => Array(
                    'key1' => 'äöü',
                    'key2' => '#+ü',
                    'key3' => '///',
                    'key4' => 'bla'
                ),
                'fingerprintOrder' => Array(
                    'key1',
                    'key2',
                    'key3',
                    'key4'
                ),
                'hash'             => '603182eb92d4b88c492eb66af2e66177a678a11f0687d036e0d496c934bbea1640e1ef78e36756fc488cdef8bf1ba0ad22a4aeb2f29dfdb035a1020c812d6d26'
            )
        );
    }
}