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
 * @name WirecardCEE_Stdlib_PaymentTypeAbstract
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 * @version 3.0.0
 * @abstract
 */
abstract class WirecardCEE_Stdlib_PaymentTypeAbstract {
    const CCARD = 'CCARD';
    const CCARD_MOTO = 'CCARD-MOTO';
    const MAESTRO = 'MAESTRO';
    const PBX = 'PBX';
    const PSC = 'PSC';
    const EPS = 'EPS';
    const ELV = 'ELV';
    const QUICK = 'QUICK';
    const IDL = 'IDL';
    const GIROPAY = 'GIROPAY';
    const PAYPAL = 'PAYPAL';
    const SOFORTUEBERWEISUNG = 'SOFORTUEBERWEISUNG';
    const C2P = 'C2P';
    const BMC = 'BANCONTACT_MISTERCASH';
    const INVOICE = 'INVOICE';
    const P24 = 'PRZELEWY24';
    const MONETA = 'MONETA';
    const POLI = 'POLI';
    const EKONTO = 'EKONTO';
    const INSTANTBANK = 'INSTANTBANK';
    const INSTALLMENT = 'INSTALLMENT';
    const MPASS = 'MPASS';
    const SKRILLDIRECT = 'SKRILLDIRECT';
    const SKRILLWALLET = 'SKRILLWALLET';

    /**
     * array of eps financial institutions
     *
     * @var string[]
     *
     * @todo would be nice to get this values directly from the server so the data is in sync
     */
    protected static $_eps_financial_institutions = Array(
            'BA-CA' => 'Bank Austria Creditanstalt',
            'BB-Racon' => 'Bank Burgenland',
            'ARZ|BAF' => 'Ärztebank',
            'ARZ|BCS' => 'Bankhaus Carl Sp&auml;ngler &amp; Co. AG',
            'ARZ|BSS' => 'Bankhaus Schelhammer &amp; Schattera AG',
            'Bawag|B' => 'BAWAG',
            'ARZ|VB' => 'Die &ouml;stereischischen Volksbanken',
            'Bawag|E' => 'easybank',
            'Spardat|EBS' => 'Erste Bank und Sparkassen',
            'ARZ|GB' => 'G&auml;rtnerbank',
            'ARZ|HAA' => 'Hypo Alpe-Adria-Bank AG, HYPO Alpe-Adria-Bank International AG',
            'ARZ|HI' => 'Hypo Investmentbank AG',
            'ARZ|HTB' => 'Hypo Tirol Bank AG',
            'ARZ|IB' => 'Immo-Bank',
            'ARZ|IKB' => 'Investkredit Bank AG',
            'ARZ|NLH' => 'Niester&ouml;sterreichische Landes-Hypothekenbank AG',
            'ARZ|AB' => '&Ouml;sterreichische Apothekerbank',
            'Bawag|P' => 'PSK Bank',
            'Racon' => 'Raiffeisen Bank',
            'ARZ|SB' => 'Schoellerbank AG',
            'Bawag|S' => 'Sparda Bank',
            'ARZ|SBL' => 'Sparda-Bank Linz',
            'ARZ|SBVI' => 'Sparda-Bank Villach/Innsbruck',
            'ARZ|VLH' => 'Vorarlberger Landes- und Hypothekerbank AG',
            'ARZ|VRB' => 'VR-Bank Braunau'
    );

    /**
     * array of iDEAL financial institutions
     *
     * @var string[]
     *
     * @todo would be nice to get this values directly from the server so the data is in sync
     */
    protected static $_idl_financial_institutions = Array(
            'ABNAMROBANK' => 'ABN AMRO Bank',
            'ASNBANK' => 'ASN Bank',
            'FRIESLANDBANK' => 'Friesland Bank',
            'INGBANK' => 'ING',
            'KNAB' => 'knab',
            'RABOBANK' => 'Rabobank',
            'SNSBANK' => 'SNS Bank',
            'REGIOBANK' => 'RegioBank',
            'TRIODOSBANK' => 'Triodos Bank',
            'VANLANSCHOT' => 'Van Lanschot Bankiers'
    );

    /**
     * check if the given paymenttype has financial institions
     *
     * @param string $paymentType
     * @return bool
     */
    public static function hasFinancialInstitutions($paymentType) {
        return (bool) ($paymentType == self::EPS || $paymentType == self::IDL);
    }

    /**
     * the an array of financial institutions for the given paymenttype.
     *
     * @param string $paymentType
     * @return string[]
     */
    public static function getFinancialInstitutions($paymentType) {
        switch($paymentType) {
            case self::EPS:
                return self::$_eps_financial_institutions;
                break;
            case self::IDL:
                return self::$_idl_financial_institutions;
                break;
            default:
                return Array();
                break;
        }
    }

    /**
     * Returns full name of the financial institution
     * Used in dd_wirecard_order.php (function: getPayment())
     *
     * @param string $sFinancialInstitutionShortCode
     * @return string
     */
    public static function getFinancialInstitutionFullName($sFinancialInstitutionShortCode) {
        if (array_key_exists($sFinancialInstitutionShortCode, self::$_eps_financial_institutions)) {
            return self::$_eps_financial_institutions[$sFinancialInstitutionShortCode];
        }

        if (array_key_exists($sFinancialInstitutionShortCode, self::$_idl_financial_institutions)) {
            return self::$_idl_financial_institutions[$sFinancialInstitutionShortCode];
        }

        return "";
    }
}