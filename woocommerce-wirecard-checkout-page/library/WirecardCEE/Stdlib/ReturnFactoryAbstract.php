<?php
/*
 * Die vorliegende Software ist Eigentum von Wirecard CEE und daher vertraulich
 * zu behandeln. Jegliche Weitergabe an dritte, in welcher Form auch immer, ist
 * unzulaessig. Software & Service Copyright (C) by Wirecard Central Eastern
 * Europe GmbH, FB-Nr: FN 195599 x, http://www.wirecard.at
 */
/**
 * Factory method for returned params validators
 *
 * @name WirecardCEE_Stdlib_ReturnFactoryAbstract
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 * @subpackage Return
 * @version 3.0.0
 * @abstract
 */
abstract class WirecardCEE_Stdlib_ReturnFactoryAbstract {
    /**
     * Success
     * @var string
     */
    const STATE_SUCCESS = 'SUCCESS';

    /**
     * Cancel
     * @var string
     */
    const STATE_CANCEL = 'CANCEL';

    /**
     * Failure
     * @var string
     */
    const STATE_FAILURE = 'FAILURE';

    /**
     * Pending
     * @var string
     */
    const STATE_PENDING = 'PENDING';


    /**
     * generator for qpay confirm response strings.
     * the response-string must be returned to QPAY in confirmation process.
     *
     * @param string $messages
     * @param bool $inCommentTag
     * @return string
     */
    public static function generateConfirmResponseString($messages = null, $inCommentTag = false) {
        $template = '<QPAY-CONFIRMATION-RESPONSE %message% result="%status%" />';
        if (empty($messages)) {
            $returnValue = str_replace('%status%', 'OK', $template);
            $returnValue = str_replace('%message% ', '', $returnValue);
        }
        else {
            $returnValue = str_replace('%status%', 'NOK', $template);
            $returnValue = str_replace('%message%', 'message="' . strval($messages) . '"', $returnValue);
        }
        if ($inCommentTag) {
            $returnValue = '<!--' . $returnValue . '-->';
        }
        return $returnValue;
    }
}