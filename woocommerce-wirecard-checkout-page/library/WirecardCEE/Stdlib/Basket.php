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
 * @name WirecardCEE_Stdlib_Basket
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 * @subpackage Basket
 * @version 3.0.0
 */
class WirecardCEE_Stdlib_Basket {

    /**
     * Constants - text holders
     *
     * @var string
     */
    const BASKET_AMOUNT             = 'basketAmount';
    const BASKET_CURRENCY         = 'basketCurrency';
    const BASKET_ITEMS             = 'basketItems';
    const BASKET_ITEM_PREFIX     = 'basketItem';
    const QUANTITY                 = 'quantity';

    /**
     * Amount
     *
     * @var float
     */
    protected $_amount = 0.0;

    /**
     * Currency (default = EUR)
     *
     * @var string
     */
    protected $_currency;

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
    public function __construct() {
        // constructor body
    }

    /**
     * Adds item to the basket
     *
     * @param WirecardCEE_Stdlib_Basket_Item $oItem
     * @param int $iQuantity
     * @return WirecardCEE_Stdlib_Basket
     */
    public function addItem(WirecardCEE_Stdlib_Basket_Item $oItem, $iQuantity = 1) {
        $_mArticleNumber = $oItem->getArticleNumber();
        $_quantity = $this->_getItemQuantity($_mArticleNumber);

        if (!$_quantity) {
            $this->_items[md5($_mArticleNumber)] = Array(
                    'instance' => $oItem,
                    self::QUANTITY => $iQuantity
            );
        }
        else {
            $this->_increaseQuantity($_mArticleNumber, $iQuantity);
        }

        return $this;
    }

    /**
     * Returns the basket total amount
     *
     * @return float
     */
    public function getAmount() {
        $total = 0.0;

        foreach($this->_items as $oItem) {
            $total += $oItem['instance']->getUnitPrice() * $this->_getItemQuantity($oItem['instance']->getArticleNumber());
        }

        return $total;
    }

    /**
     * Returns the basket as pre-defined array (defined by WirecardCEE)
     *
     * @return Array
     */
    public function __toArray() {
        $_basketItems = $this->_items;
        $_counter = 1;

        $this->_basket[self::BASKET_AMOUNT] = $this->getAmount();
        $this->_basket[self::BASKET_CURRENCY] = $this->_currency;
        $this->_basket[self::BASKET_ITEMS] = count($_basketItems);

        foreach($_basketItems as $oItem) {
            $mArticleNumber = $oItem['instance']->getArticleNumber();
            $oItem = $oItem['instance'];

            $this->_basket[self::BASKET_ITEM_PREFIX . $_counter . WirecardCEE_Stdlib_Basket_Item::ITEM_ARTICLE_NUMBER] = $mArticleNumber;
            $this->_basket[self::BASKET_ITEM_PREFIX . $_counter . self::QUANTITY] = $this->_getItemQuantity($mArticleNumber);
            $this->_basket[self::BASKET_ITEM_PREFIX . $_counter . WirecardCEE_Stdlib_Basket_Item::ITEM_UNIT_PRICE] = $oItem->getUnitPrice();
            $this->_basket[self::BASKET_ITEM_PREFIX . $_counter . WirecardCEE_Stdlib_Basket_Item::ITEM_TAX] = $oItem->getTax();
            $this->_basket[self::BASKET_ITEM_PREFIX . $_counter . WirecardCEE_Stdlib_Basket_Item::ITEM_DESCRIPTION] = $oItem->getDescription();

            $_counter++;
        }

        return $this->_basket;
    }

    /**
     * Sets the basket currency
     *
     * @param string $sCurrency
     * @return WirecardCEE_Stdlib_Basket
     */
    public function setCurrency($sCurrency) {
        $this->_currency = $sCurrency;
        return $this;
    }

    /**
     * Destructor
     */
    public function __destruct() {
        unset($this);
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
    protected function _increaseQuantity($mArticleNumber, $iQuantity) {
        if(!isset($this->_items[md5($mArticleNumber)])) {
            throw new Exception(sprintf("There is no item in the basket with article number '%s'. Thrown in %s.", $mArticleNumber, __METHOD__));
        }

        $this->_items[md5($mArticleNumber)][self::QUANTITY] += $iQuantity;
        return true;
    }

    /**
     * Returns the quantity of item in basket
     *
     * @param mixed(integer|string) $mArticleNumber
     * @return integer
     */
    protected function _getItemQuantity($mArticleNumber) {
        return (int) isset($this->_items[md5($mArticleNumber)]) ? $this->_items[md5($mArticleNumber)][self::QUANTITY] : 0;
    }
}