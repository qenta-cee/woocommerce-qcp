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
    const ITEM_ARTICLE_NUMBER    = 'articleNumber';
    const ITEM_QUANTITY          = 'quantity';
    const ITEM_UNIT_GROSS_AMOUNT = 'unitGrossAmount';
    const ITEM_UNIT_NET_AMOUNT   = 'unitNetAmount';
    const ITEM_DESCRIPTION       = 'description';
    const ITEM_NAME              = 'name';
    const ITEM_IMAGE_URL         = 'imageUrl';
    const ITEM_UNIT_TAX_AMOUNT   = 'unitTaxAmount';
    const ITEM_UNIT_TAX_RATE     = 'unitTaxRate';

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
     * Sets the item tax amount
     *
     * @param mixed(integer|float) $fTaxAmount
     * @return WirecardCEE_Stdlib_Basket_Item
     */
    public function setUnitTaxAmount($fTaxAmount)
    {
        $this->_setField(self::ITEM_UNIT_TAX_AMOUNT, $fTaxAmount);
        return $this;
    }

    /**
     * Returns the tax amount
     *
     * @return mixed(integer|float)
     */
    public function getUnitTaxAmount()
    {
        return $this->_itemData[self::ITEM_UNIT_TAX_AMOUNT];
    }

    /**
     * Sets the item tax rate
     *
     * @param mixed(integer|float) $fTaxRate
     * @return WirecardCEE_Stdlib_Basket_Item
     */
    public function setUnitTaxRate($fTaxRate)
    {
        $this->_setField(self::ITEM_UNIT_TAX_RATE, $fTaxRate);
        return $this;
    }

    /**
     * Returns the tax rate
     *
     * @return mixed(integer|float)
     */
    public function getUnitTaxRate()
    {
        return $this->_itemData[self::ITEM_UNIT_TAX_RATE];
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
     * Sets the gross amount for a unit
     *
     * @param mixed(integer|float) $fAmount
     * @return WirecardCEE_Stdlib_Basket_Item
     */
    public function setUnitGrossAmount($fAmount)
    {
        $this->_setField(self::ITEM_UNIT_GROSS_AMOUNT, $fAmount);
        return $this;
    }

    /**
     * Returns the gross amount for a unit
     *
     * @return mixed(integer|float)
     */
    public function getUnitGrossAmount()
    {
        return $this->_itemData[self::ITEM_UNIT_GROSS_AMOUNT];
    }

    /**
     * Sets the net amount for a unit
     *
     * @param mixed(integer|float) $fAmount
     * @return WirecardCEE_Stdlib_Basket_Item
     */
    public function setUnitNetAmount($fAmount)
    {
        $this->_setField(self::ITEM_UNIT_NET_AMOUNT, $fAmount);
        return $this;
    }

    /**
     * Returns the net amount for a unit
     *
     * @return mixed(integer|float)
     */
    public function getUnitNetAmount()
    {
        return $this->_itemData[self::ITEM_UNIT_NET_AMOUNT];
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
     * Returns the item description
     *
     * @return string
     */
    public function getDescription()
    {
        if(array_key_exists(self::ITEM_DESCRIPTION, $this->_itemData)) {
            return (string) $this->_itemData[self::ITEM_DESCRIPTION];
        }
        return null;
    }

    /**
     * Sets the item name
     *
     * @param string $sName
     * @return WirecardCEE_Stdlib_Basket_Item
     */
    public function setName($sName) {
        $this->_setField(self::ITEM_NAME, (string) $sName);
        return $this;
    }

    /**
     * Returns the item name
     *
     * @return string
     */
    public function getName()
    {
        return (string) $this->_itemData[self::ITEM_NAME];
    }


    /**
     * Sets the item image url
     *
     * @param string $sImageUrl
     * @return WirecardCEE_Stdlib_Basket_Item
     */
    public function setImageUrl($sImageUrl) {
        $this->_setField(self::ITEM_IMAGE_URL, (string) $sImageUrl);
        return $this;
    }

    /**
     * Returns the item image url
     *
     * @return string
     */
    public function getImageUrl()
    {
        if(array_key_exists(self::ITEM_IMAGE_URL, $this->_itemData)) {
            return (string) $this->_itemData[self::ITEM_IMAGE_URL];
        }
        return null;
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