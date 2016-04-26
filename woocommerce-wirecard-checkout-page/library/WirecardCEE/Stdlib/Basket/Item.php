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
 * @name WirecardCEE_Stdlib_Basket_Item
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 * @subpackage Basket
 * @version 3.0.0
 */
class WirecardCEE_Stdlib_Basket_Item {

    /**
     * Constants - text holders
     * @var string
     */
    const ITEM_ARTICLE_NUMBER     = 'articleNumber';
    const ITEM_UNIT_PRICE         = 'unitPrice';
    const ITEM_DESCRIPTION         = 'description';
    const ITEM_TAX                = 'tax';

    /**
     * Data holder
     *
     * @var Array
     */
    protected $_itemData;

    /**
     * Constructor
     * @param mixed(string|integer) optional $mArticleNumber
     */
    public function __construct($mArticleNumber = null) {
        if(!is_null($mArticleNumber)) {
            $this->setArticleNumber($mArticleNumber);
        }
    }

    /**
     * Sets the item tax (amount not percentage!)
     *
     * @param integer/float
     */
    public function setTax($fTax) {
        $this->_setField(self::ITEM_TAX, $fTax);
        return $this;
    }

    /**
     * Returns the tax
     *
     * @return multitype:
     */
    public function getTax() {
        return $this->_itemData[self::ITEM_TAX];
    }

    /**
     * Sets the article number for an item
     *
     * @param mixed(string|integer) $mArticleNumber
     * @return WirecardCEE_Stdlib_Basket_Item
     */
    public function setArticleNumber($mArticleNumber) {
        $this->_setField(self::ITEM_ARTICLE_NUMBER, $mArticleNumber);
        return $this;
    }

    /**
     * Returns the article number of an item
     *
     * @return mixed(string|integer)
     */
    public function getArticleNumber() {
        return $this->_itemData[self::ITEM_ARTICLE_NUMBER];
    }

    /**
     * Sets the price for a unit
     *
     * @param mixed(integer|float) $fPrice
     * @return WirecardCEE_Stdlib_Basket_Item
     */
    public function setUnitPrice($fPrice) {
        $this->_setField(self::ITEM_UNIT_PRICE, $fPrice);
        return $this;
    }

    /**
     * Returns the price for a unit
     *
     * @return mixed(integer|float)
     */
    public function getUnitPrice() {
        return $this->_itemData[self::ITEM_UNIT_PRICE];
    }

    /**
     * Sets the item description
     *
     * @param string $sDescription
     * @return WirecardCEE_Stdlib_Basket_Item
     */
    public function setDescription($sDescription) {
        $this->_setField(self::ITEM_DESCRIPTION, (string) $sDescription);
        return $this;
    }

    /**
     * Retuns the item description
     *
     * @return string
     */
    public function getDescription() {
        return (string) $this->_itemData[self::ITEM_DESCRIPTION];
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
     * Field setter
     *
     * @param string $sName
     * @param mixed $mValue
     */
    protected function _setField($sName, $mValue) {
        $this->_itemData[$sName] = $mValue;
    }
}