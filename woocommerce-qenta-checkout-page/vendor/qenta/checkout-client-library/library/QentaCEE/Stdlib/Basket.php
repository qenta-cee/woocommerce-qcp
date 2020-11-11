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
 * @name QentaCEE_Stdlib_Basket
 * @category QentaCEE
 * @package QentaCEE_Stdlib
 * @subpackage Basket
 */
class QentaCEE_Stdlib_Basket
{

    /**
     * Constants - text holders
     *
     * @var string
     */
    const BASKET_ITEMS = 'basketItems';
    const BASKET_ITEM_PREFIX = 'basketItem';
    const QUANTITY = 'quantity';

    /**
     * Items holder
     *
     * @var array
     */
    protected $_items = Array();

    /**
     * Basket data
     *
     * @var array
     */
    protected $_basket = Array();

    /**
     * Constructor
     */
    public function __construct()
    {
        // constructor body
    }

    /**
     * Adds item to the basket
     *
     * @param QentaCEE_Stdlib_Basket_Item $oItem
     * @param int $iQuantity
     *
     * @return QentaCEE_Stdlib_Basket
     */
    public function addItem(QentaCEE_Stdlib_Basket_Item $oItem, $iQuantity = 1)
    {
        $_mArticleNumber = $oItem->getArticleNumber();
        $_quantity       = $this->_getItemQuantity($_mArticleNumber);

        if (!$_quantity) {
            $this->_items[md5($_mArticleNumber)] = Array(
                'instance'     => $oItem,
                self::QUANTITY => $iQuantity
            );
        } else {
            $this->_increaseQuantity($_mArticleNumber, $iQuantity);
        }

        return $this;
    }

    /**
     * Returns the basket as pre-defined array (defined by QentaCEE)
     *
     * @return Array
     */
    public function getData()
    {
        $_basketItems = $this->_items;
        $_counter     = 1;

        $this->_basket[self::BASKET_ITEMS]    = count($_basketItems);

        foreach ($_basketItems as $oItem) {
            $mArticleNumber = $oItem['instance']->getArticleNumber();
            $oItem          = $oItem['instance'];

            $this->_basket[self::BASKET_ITEM_PREFIX . $_counter . QentaCEE_Stdlib_Basket_Item::ITEM_ARTICLE_NUMBER]    = $mArticleNumber;
            $this->_basket[self::BASKET_ITEM_PREFIX . $_counter . self::QUANTITY]                                         = $this->_getItemQuantity($mArticleNumber);
            $this->_basket[self::BASKET_ITEM_PREFIX . $_counter . QentaCEE_Stdlib_Basket_Item::ITEM_UNIT_GROSS_AMOUNT] = $oItem->getUnitGrossAmount();
            $this->_basket[self::BASKET_ITEM_PREFIX . $_counter . QentaCEE_Stdlib_Basket_Item::ITEM_UNIT_NET_AMOUNT]   = $oItem->getUnitNetAmount();
            $this->_basket[self::BASKET_ITEM_PREFIX . $_counter . QentaCEE_Stdlib_Basket_Item::ITEM_UNIT_TAX_AMOUNT]   = $oItem->getUnitTaxAmount();
            $this->_basket[self::BASKET_ITEM_PREFIX . $_counter . QentaCEE_Stdlib_Basket_Item::ITEM_UNIT_TAX_RATE]     = $oItem->getUnitTaxRate();
            $this->_basket[self::BASKET_ITEM_PREFIX . $_counter . QentaCEE_Stdlib_Basket_Item::ITEM_DESCRIPTION]       = $oItem->getDescription();
            $this->_basket[self::BASKET_ITEM_PREFIX . $_counter . QentaCEE_Stdlib_Basket_Item::ITEM_NAME]              = $oItem->getName();
            $this->_basket[self::BASKET_ITEM_PREFIX . $_counter . QentaCEE_Stdlib_Basket_Item::ITEM_IMAGE_URL]         = $oItem->getImageUrl();

            $_counter ++;
        }

        return $this->_basket;
    }

    /***************************************
     *         PROTECTED METHODS           *
     ***************************************/

    /**
     * Updates the quantity for an item already in basket
     *
     * @param mixed(integer|string) $mArticleNumber
     * @param int $iQuantity
     */
    protected function _increaseQuantity($mArticleNumber, $iQuantity)
    {
        if (!isset( $this->_items[md5($mArticleNumber)] )) {
            throw new Exception(sprintf("There is no item in the basket with article number '%s'. Thrown in %s.",
                $mArticleNumber, __METHOD__));
        }

        $this->_items[md5($mArticleNumber)][self::QUANTITY] += $iQuantity;

        return true;
    }

    /**
     * Returns the quantity of item in basket
     *
     * @param mixed(integer|string) $mArticleNumber
     *
     * @return integer
     */
    protected function _getItemQuantity($mArticleNumber)
    {
        return (int) isset( $this->_items[md5($mArticleNumber)] ) ? $this->_items[md5($mArticleNumber)][self::QUANTITY] : 0;
    }
}