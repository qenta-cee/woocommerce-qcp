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

class WirecardCEE_QPay_MobileDetectTest extends PHPUnit_Framework_TestCase
{
    public function testClientConfig()
    {
        $detect = new WirecardCEE_QPay_MobileDetect();
        $this->assertFalse($detect->isMobile('Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Win64; x64; Trident/6.0; Touch; MDDCJS; WebView/1.0)'));
        $this->assertFalse($detect->isTablet('Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Win64; x64; Trident/6.0; Touch; MDDCJS; WebView/1.0)'));

        $this->assertTrue($detect->isTablet('Mozilla/5.0 (Linux; Android 4.4.2; SM-T700 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.517 Safari/537.36'));
        $this->assertTrue($detect->isMobile('Mozilla/5.0 (Linux; Android 4.4.2; SM-T700 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.517 Safari/537.36'));

        $this->assertFalse($detect->isTablet('Mozilla/5.0 (Linux; U; Android 4.0.4; en-us; SHV-E160K/VI10.1802 Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30'));
        $this->assertTrue($detect->isMobile('Mozilla/5.0 (Linux; U; Android 4.0.4; en-us; SHV-E160K/VI10.1802 Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30'));
    }
}
