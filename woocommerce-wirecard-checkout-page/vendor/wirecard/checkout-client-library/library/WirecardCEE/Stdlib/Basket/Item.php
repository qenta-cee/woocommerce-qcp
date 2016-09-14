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
 * @name WirecardCEE_Stdlib_Basket_Item
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 * @subpackage Basket
 */
class WirecardCEE_Stdlib_Basket_Item
{

    /**
     * Constants - text holders
     *
     * @var string
     */
    const ITEM_ARTICLE_NUMBER = 'articleNumber';
    const ITEM_UNIT_PRICE = 'unitPrice';
    const ITEM_DESCRIPTION = 'description';
    const ITEM_TAX = 'tax';

    /**
     * Data holder
     *
     * @var Array
     */
    protected $_itemData;

    /**
     * Constructor
     *
     * @param mixed(string|integer) optional $mArticleNumber
     */
    public function __construct($mArticleNumber = null)
    {
        if (!is_null($mArticleNumber)) {
            $this->setArticleNumber($mArticleNumber);
        }
    }

    /**
     * Sets the item tax (amount not percentage!)
     *
     * @param integer /float
     */
    public function setTax($fTax)
    {
        $this->_setField(self::ITEM_TAX, $fTax);

        return $this;
    }

    /**
     * Returns the tax
     *
     * @return multitype:
     */
    public function getTax()
    {
        return $this->_itemData[self::ITEM_TAX];
    }

    /**
     * Sets the article number for an item
     *
     * @param mixed(string|integer) $mArticleNumber
     *
     * @return WirecardCEE_Stdlib_Basket_Item
     */
    public function setArticleNumber($mArticleNumber)
    {
        $this->_setField(self::ITEM_ARTICLE_NUMBER, $mArticleNumber);

        return $this;
    }

    /**
     * Returns the article number of an item
     *
     * @return mixed(string|integer)
     */
    public function getArticleNumber()
    {
        return $this->_itemData[self::ITEM_ARTICLE_NUMBER];
    }

    /**
     * Sets the price for a unit
     *
     * @param mixed(integer|float) $fPrice
     *
     * @return WirecardCEE_Stdlib_Basket_Item
     */
    public function setUnitPrice($fPrice)
    {
        $this->_setField(self::ITEM_UNIT_PRICE, $fPrice);

        return $this;
    }

    /**
     * Returns the price for a unit
     *
     * @return mixed(integer|float)
     */
    public function getUnitPrice()
    {
        return $this->_itemData[self::ITEM_UNIT_PRICE];
    }

    /**
     * Sets the item description
     *
     * @param string $sDescription
     *
     * @return WirecardCEE_Stdlib_Basket_Item
     */
    public function setDescription($sDescription)
    {
        $this->_setField(self::ITEM_DESCRIPTION, (string) $sDescription);

        return $this;
    }

    /**
     * Retuns the item description
     *
     * @return string
     */
    public function getDescription()
    {
        return (string) $this->_itemData[self::ITEM_DESCRIPTION];
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        unset( $this );
    }

    /***************************************
     *         PROTECTED METHODS           *
     ***************************************/

    /**
     * Field setter
     *
     * @param string $sName
     * @param mixed $mValue
     */
    protected function _setField($sName, $mValue)
    {
        $this->_itemData[$sName] = $mValue;
    }
}