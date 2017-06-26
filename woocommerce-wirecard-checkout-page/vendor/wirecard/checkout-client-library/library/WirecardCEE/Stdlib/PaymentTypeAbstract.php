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
 * @name WirecardCEE_Stdlib_PaymentTypeAbstract
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 * @abstract
 */
abstract class WirecardCEE_Stdlib_PaymentTypeAbstract
{
    const BMC = 'BANCONTACT_MISTERCASH';
    const CCARD = 'CCARD';
    const CCARD_MOTO = 'CCARD-MOTO';
    const EKONTO = 'EKONTO';
    const EPAYBG = 'EPAY_BG';
    const EPS = 'EPS';
    const GIROPAY = 'GIROPAY';
    const IDL = 'IDL';
    const INSTALLMENT = 'INSTALLMENT';
    const INVOICE = 'INVOICE';
    const MAESTRO = 'MAESTRO';
    const MASTERPASS = 'MASTERPASS';
    const MONETA = 'MONETA';
    const MPASS = 'MPASS';
    const P24 = 'PRZELEWY24';
    const PAYPAL = 'PAYPAL';
    const PBX = 'PBX';
    const POLI = 'POLI';
    const PSC = 'PSC';
    const QUICK = 'QUICK';
    const SEPADD = 'SEPA-DD';
    const ELV = 'ELV';
    const SKRILLDIRECT = 'SKRILLDIRECT';
    const SKRILLWALLET = 'SKRILLWALLET';
    const SOFORTUEBERWEISUNG = 'SOFORTUEBERWEISUNG';
    const TATRAPAY = 'TATRAPAY';
    const TRUSTLY = 'TRUSTLY';
    const TRUSTPAY = 'TRUSTPAY';
    const VOUCHER = 'VOUCHER';

    /**
     * array of eps financial institutions
     * keep this sort order
     *
     * @var string[]
     *
     * @todo would be nice to get this values directly from the server so the data is in sync
     */
    protected static $_eps_financial_institutions = Array(
        'ARZ|AB'        => 'Apothekerbank',
        'ARZ|AAB'       => 'Austrian Anadi Bank AG',
        'ARZ|BAF'       => '&Auml;rztebank',
        'BA-CA'         => 'Bank Austria',
        'ARZ|BCS'       => 'Bankhaus Carl Sp&auml;ngler & Co. AG',
        'ARZ|BSS'       => 'Bankhaus Schelhammer & Schattera AG',
        'Bawag|BG'       => 'BAWAG P.S.K. AG',
        'ARZ|BKS'       => 'BKS Bank AG',
        'ARZ|BKB'       => 'Br&uuml;ll Kallmus Bank AG',
        'ARZ|BTV'       => 'BTV VIER L&Auml;NDER BANK',
        'ARZ|CBGG'      => 'Capital Bank Grawe Gruppe AG',
        'ARZ|VB'        => 'Volksbank Gruppe',
        'ARZ|DB'        => 'Dolomitenbank',
        'Bawag|EB'       => 'Easybank AG',
        'Spardat|EBS'   => 'Erste Bank und Sparkassen',
        'ARZ|HAA'       => 'Hypo Alpe-Adria-Bank International AG',
        'ARZ|VLH'       => 'Hypo Landesbank Vorarlberg',
        'ARZ|HI'        => 'HYPO NOE Gruppe Bank AG',
        'ARZ|NLH'       => 'HYPO NOE Landesbank AG',
        'Hypo-Racon|O'  => 'Hypo Ober&ouml;sterreich',
        'Hypo-Racon|S'  => 'Hypo Salzburg',
        'Hypo-Racon|St' => 'Hypo Steiermark',
        'ARZ|HTB'       => 'Hypo Tirol Bank AG',
        'BB-Racon'      => 'HYPO-BANK BURGENLAND Aktiengesellschaft',
        'ARZ|IB'        => 'Immo-Bank',
        'ARZ|OB'        => 'Oberbank AG',
        'Racon'         => 'Raiffeisen Bankengruppe &Ouml;sterreich',
        'ARZ|SB'        => 'Schoellerbank AG',
        'Bawag|SBW'       => 'Sparda Bank Wien',
        'ARZ|SBA'       => 'SPARDA-BANK AUSTRIA',
        'ARZ|VKB'       => 'Volkskreditbank AG',
        'ARZ|VRB'       => 'VR-Bank Braunau'
    );

    /**
     * array of iDEAL financial institutions
     *
     * @var string[]
     *
     * @todo would be nice to get this values directly from the server so the data is in sync
     */
    protected static $_idl_financial_institutions = Array(
        'ABNAMROBANK' =>'ABN AMRO Bank',
        'ASNBANK'     =>'ASN Bank',
        'BUNQ'        =>'Bunq Bank',
        'INGBANK'     =>'ING',
        'KNAB'        =>'knab',
        'RABOBANK'    =>'Rabobank',
        'SNSBANK'     =>'SNS Bank',
        'REGIOBANK'   =>'RegioBank',
        'TRIODOSBANK' =>'Triodos Bank',
        'VANLANSCHOT' =>'Van Lanschot Bankiers'
    );


    /**
     * check if the given paymenttype has financial institions
     *
     * @param string $paymentType
     *
     * @return bool
     */
    public static function hasFinancialInstitutions($paymentType)
    {
        return (bool) ( $paymentType == self::EPS || $paymentType == self::IDL );
    }

    /**
     * the an array of financial institutions for the given paymenttype.
     *
     * @param string $paymentType
     *
     * @return string[]
     */
    public static function getFinancialInstitutions($paymentType)
    {
        switch ($paymentType) {
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
     *
     * @return string
     */
    public static function getFinancialInstitutionFullName($sFinancialInstitutionShortCode)
    {
        if (array_key_exists($sFinancialInstitutionShortCode, self::$_eps_financial_institutions)) {
            return self::$_eps_financial_institutions[$sFinancialInstitutionShortCode];
        }

        if (array_key_exists($sFinancialInstitutionShortCode, self::$_idl_financial_institutions)) {
            return self::$_idl_financial_institutions[$sFinancialInstitutionShortCode];
        }

        return "";
    }
}
