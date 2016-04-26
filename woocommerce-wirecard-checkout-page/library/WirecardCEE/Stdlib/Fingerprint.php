<?php
/*
* Die vorliegende Software ist Eigentum von Wirecard CEE und daher vertraulich
* zu behandeln. Jegliche Weitergabe an dritte, in welcher Form auch immer, ist
* unzulaessig.
*
* Software & Service Copyright (C) by
* Wirecard Central Eastern Europe GmbH,
* FB-Nr: FN 195599 x, http://www.wirecard.at
*/

/**
 * @name WirecardCEE_Stdlib_Fingerprint
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 * @version 3.0.0
 */
class WirecardCEE_Stdlib_Fingerprint {
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
     * Hash algorithm
     * @staticvar string
     * @internal
     */
    protected static $_HASH_ALGORITHM = self::HASH_ALGORITHM_SHA512;

    /**
     * Hash algorithm
     * @staticvar boolean
     * @internal
     */
    protected static $_STRIP_SLASHES = false;


    /**
     * use stripslashes for fingerprint generate methods
     *
     * @param boolean $strip
     */
    public static function stripSlashes($strip) {
        self::$_STRIP_SLASHES = filter_var($strip, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Sets the hash algorithm
     * @param string $hashAlgorithm
     */
    public static function setHashAlgorithm($sHashAlgorithm) {
        self::$_HASH_ALGORITHM = (string) $sHashAlgorithm;
    }

    /**
     * generates an Fingerprint-string
     *
     * @param array $aValues
     * @param array $oFingerprintOrder
     */
    public static function generate(Array $aValues, WirecardCEE_Stdlib_FingerprintOrder $oFingerprintOrder) {
        $hash = hash_init(self::$_HASH_ALGORITHM);
        foreach($oFingerprintOrder as $key) {
            $key = (string) $key;

            if (array_key_exists($key, $aValues)) {
                hash_update($hash, (self::$_STRIP_SLASHES) ? stripslashes($aValues[$key]) : $aValues[$key]);
            }
            else {
                throw new WirecardCEE_Stdlib_Exception_InvalidValueException('Value for key ' . strtoupper($key) . ' not found in values array.');
            }
        }

        return hash_final($hash);
    }

    /**
     *
     * @param array $aValues
     * @param array $oFingerprintOrder
     * @param string $sCompareFingerprint
     * @return boolean
     */
    public static function compare(Array $aValues, WirecardCEE_Stdlib_FingerprintOrder $oFingerprintOrder, $sCompareFingerprint) {
        $sCalcFingerprint = self::generate($aValues, $oFingerprintOrder);
        return (bool) (strcasecmp($sCalcFingerprint, $sCompareFingerprint) == 0);
    }
}