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
use PHPUnit\Framework\TestCase;

class QentaBasket extends QentaCEE_Stdlib_Basket
{

    public function getCurrency()
    {
        return $this->_currency;
    }

    public function getItems()
    {
        return $this->_items;
    }

    public function getItem($mArticleNumber)
    {
        return isset( $this->_items[md5($mArticleNumber)] ) ? $this->_items[md5($mArticleNumber)] : false;
    }

    public function getItemQuantity($mArticleNumber)
    {
        return $this->_getItemQuantity($mArticleNumber);
    }

    public function increaseQuantity($mArticleNumber, $iQuantity)
    {
        return $this->_increaseQuantity($mArticleNumber, $iQuantity);
    }
}

class QentaCEE_Stdlib_BasketTest extends TestCase
{

    protected $object;

    public function setUp(): void
    {
        $this->object = new QentaBasket();

        for ($i = 0; $i < 10; $i ++) {
            $_item = new QentaCEE_Stdlib_Basket_Item("QentaCEE_{$i}");
            $_item->setUnitGrossAmount(( $i + 1 ) * 10)
                  ->setUnitNetAmount(( $i + 1 ) * 8)
                  ->setUnitTaxAmount(( $i + 1 ) * 2)
                  ->setUnitTaxRate(20.0)
                  ->setDescription("UnitTesting Description {$i}")
                  ->setName("UnitTesting Name {$i}")
                  ->setImageUrl("http://example.com/picture.png");
            $this->object->addItem($_item);
        }
    }

    public function testAddNewItem()
    {
        $this->assertIsArray($this->object->getItems());
        $this->assertEquals(10, count($this->object->getItems()));
    }


    public function testIncreaseQuantity()
    {
        $oItem = $this->object->getItem('QentaCEE_0');
        $this->object->addItem($oItem['instance']);
        $this->assertEquals(2, $this->object->getItemQuantity('QentaCEE_0'));
    }

    public function testGetData()
    {
        $array = $this->object->getData();
        $this->assertIsArray($array);
        $this->assertEquals(count($this->object->getItems()), $array[QentaCEE_Stdlib_Basket::BASKET_ITEMS]);
    }

    public function testIncreaseQuantityForException()
    {
        $this -> expectException(Exception::class);
        $this->object->increaseQuantity('not_existing', 1);
    }

    public function tearDown(): void
    {
        $this->object = null;
        parent::tearDown();
    }
}