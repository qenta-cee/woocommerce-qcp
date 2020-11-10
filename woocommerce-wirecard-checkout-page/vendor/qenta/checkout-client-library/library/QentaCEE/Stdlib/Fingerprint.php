<?php
/**
 * Shop System Plugins - Terms of Use
 *
 * The plugins offered are provided free of charge by Qenta Payment CEE GmbH
 * (abbreviated to Qenta CEE) and are explicitly not part of the Qenta CEE range of
 * products and services.
 *
 * They have been tested and approved for full functionality in the standard configuration
 * (status on delivery) of the corresponding shop system. They are under General Public
 * License Version 2 (GPLv2) and can be used, developed and passed on to third parties under
 * the same terms.
 *
 * However, Qenta CEE does not provide any guarantee or accept any liability for any errors
 * occurring when used in an enhanced, customized shop system configuration.
 *
 * Operation in an enhanced, customized configuration is at your own risk and requires a
 * comprehensive test phase by the user of the plugin.
 *
 * Customers use the plugins at their own risk. Qenta CEE does not guarantee their full
 * functionality neither does Qenta CEE assume liability for any disadvantages related to
 * the use of the plugins. Additionally, Qenta CEE does not guarantee the full functionality
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
 * @name QentaCEE_Stdlib_Fingerprint
 * @category QentaCEE
 * @package QentaCEE_Stdlib
 */
class QentaCEE_Stdlib_Fingerprint
{
    /**
     *
     * @var string
     */
    const HASH_ALGORITHM_MD5 = 'md5';

    /**
     *
     * @var string
     */
    const HASH_ALGORITHM_SHA512 = 'sha512';

    /**
     *
     * @var string
     */
    const HASH_ALGORITHM_HMAC_SHA512 = 'hmac_sha512';

    /**
     * Hash algorithm
     *
     * @staticvar string
     * @internal
     */
    protected static $_HASH_ALGORITHM = self::HASH_ALGORITHM_HMAC_SHA512;

    /**
     * Hash algorithm
     *
     * @staticvar boolean
     * @internal
     */
    protected static $_STRIP_SLASHES = false;


    /**
     * use stripslashes for fingerprint generate methods
     *
     * @param boolean $strip
     */
    public static function stripSlashes($strip)
    {
        self::$_STRIP_SLASHES = filter_var($strip, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Sets the hash algorithm
     *
     * @param string $hashAlgorithm
     */
    public static function setHashAlgorithm($sHashAlgorithm)
    {
        self::$_HASH_ALGORITHM = (string) $sHashAlgorithm;
    }

    /**
     * generates an Fingerprint-string
     *
     * @param array $aValues
     * @param QentaCEE_Stdlib_FingerprintOrder $oFingerprintOrder
     */
    public static function generate(Array $aValues, QentaCEE_Stdlib_FingerprintOrder $oFingerprintOrder)
    {
        if (self::$_HASH_ALGORITHM == self::HASH_ALGORITHM_HMAC_SHA512) {
            $secret = isset( $aValues['secret'] ) && !empty( $aValues['secret'] ) ? $aValues['secret'] : '';
            if (empty($secret)) {
                throw new QentaCEE_Stdlib_Exception_UnexpectedValueException();
            }
            $hash   = hash_init(self::HASH_ALGORITHM_SHA512, HASH_HMAC, $secret);
        } else {
            $hash = hash_init(self::$_HASH_ALGORITHM);
        }
        foreach ($oFingerprintOrder as $key) {
            $key = (string) $key;

            if (array_key_exists($key, $aValues)) {
                hash_update($hash, ( self::$_STRIP_SLASHES ) ? stripslashes($aValues[$key]) : $aValues[$key]);
            } else {
                throw new QentaCEE_Stdlib_Exception_InvalidValueException('Value for key ' . strtoupper($key) . ' not found in values array.');
            }
        }

        return hash_final($hash);
    }

    /**
     *
     * @param array $aValues
     * @param QentaCEE_Stdlib_FingerprintOrder $oFingerprintOrder
     * @param string $sCompareFingerprint
     *
     * @return boolean
     */
    public static function compare(
        Array $aValues,
        QentaCEE_Stdlib_FingerprintOrder $oFingerprintOrder,
        $sCompareFingerprint
    ) {
        $sCalcFingerprint = self::generate($aValues, $oFingerprintOrder);

        return strcasecmp($sCalcFingerprint, $sCompareFingerprint) == 0;
    }
}