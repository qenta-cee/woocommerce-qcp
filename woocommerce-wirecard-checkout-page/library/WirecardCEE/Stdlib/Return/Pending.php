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
 * @name WirecardCEE_Stdlib_Return_Pending
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 * @subpackage Return
 * @version 3.0.0
 * @abstract
 */
abstract class WirecardCEE_Stdlib_Return_Pending extends WirecardCEE_Stdlib_Return_ReturnAbstract {

    /**
     * Secret
     * @var string
     * @internal
     */
    protected static $SECRET = 'secret';
    /**
     * State: Pending
     * @var string
     * @internal
     */
    protected $_state = 'PENDING';

    /**
     * Fingerprintorder field
     * @var string
     * @internal
     */
    protected static $FINGERPRINT_ORDER_FIELD = 'fingerprintOrderField';

    /**
     * Constructor for PENDING state - we need the fingeprint validator so we add it after the
     * parent::__construct($returnData)
     *
     * @param array $returnData
     */
    public function __construct($returnData, $secret) {
        //@see WirecardCEE_Stdlib_Return_ReturnAbstract::__construct($returnData)
        parent::__construct($returnData);

        $oFingerprintValidator = new WirecardCEE_Stdlib_Validate_Fingerprint(Array(
                self::$SECRET => $secret,
                self::$FINGERPRINT_ORDER_FIELD => 'responseFingerprintOrder',
        ));

        $oFingerprintValidator->setHashAlgorithm(WirecardCEE_Stdlib_Fingerprint::HASH_ALGORITHM_MD5);
        $oFingerprintValidator->setOrderType(WirecardCEE_Stdlib_Validate_Fingerprint::TYPE_DYNAMIC);

        $this->addValidator($oFingerprintValidator, 'responseFingerprint');
    }
}