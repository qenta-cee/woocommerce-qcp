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
        'ARZ|AAB'       => 'Austrian Anadi Bank AG',
        'BA-CA'         => 'Bank Austria Creditanstalt',
        'BB-Racon'      => 'Bank Burgenland',
        'ARZ|BD'        => 'bankdirekt.at AG',
        'ARZ|BAF'       => '&Auml;rztebank',
        'ARZ|BCS'       => 'Bankhaus Carl Sp&auml;ngler &amp; Co. AG',
        'ARZ|BSS'       => 'Bankhaus Schelhammer &amp; Schattera AG',
        'Bawag|B'       => 'BAWAG',
        'ARZ|VB'        => 'Die &ouml;sterreichischen Volksbanken',
        'Bawag|E'       => 'easybank',
        'Spardat|EBS'   => 'Erste Bank und Sparkassen',
        'ARZ|GB'        => 'G&auml;rtnerbank',
        'ARZ|HAA'       => 'Hypo Alpe-Adria-Bank AG, HYPO Alpe-Adria-Bank International AG',
        'ARZ|HI'        => 'Hypo Investmentbank AG',
        'ARZ|HTB'       => 'Hypo Tirol Bank AG',
        'ARZ|IB'        => 'Immo-Bank',
        'ARZ|IKB'       => 'Investkredit Bank AG',
        'ARZ|NLH'       => 'Nieder&ouml;sterreichische Landes-Hypothekenbank AG',
        'ARZ|AB'        => '&Ouml;sterreichische Apothekerbank',
        'ARZ|PB'        => 'PRIVAT BANK AG',
        'Bawag|P'       => 'PSK Bank',
        'Racon'         => 'Raiffeisen Bank',
        'ARZ|SB'        => 'Schoellerbank AG',
        'Bawag|S'       => 'Sparda Bank',
        'ARZ|SBL'       => 'Sparda-Bank Linz',
        'ARZ|SBVI'      => 'Sparda-Bank Villach/Innsbruck',
        'ARZ|VLH'       => 'Vorarlberger Landes- und Hypothekerbank AG',
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
        'ABNAMROBANK' => 'ABN AMRO Bank',
        'ASNBANK'     => 'ASN Bank',
        'INGBANK'     => 'ING',
        'KNAB'        => 'Knab',
        'RABOBANK'    => 'Rabobank',
        'SNSBANK'     => 'SNS Bank',
        'REGIOBANK'   => 'Regio Bank',
        'TRIODOSBANK' => 'Triodos Bank',
        'VANLANSCHOT' => 'Van Lanschot Bankiers'
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
