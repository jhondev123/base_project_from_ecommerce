<?php

namespace Jhonattan\BaseProjectFromEcommerce\Tests\Unit\Domain\Entities\Order;

use PHPUnit\Framework\TestCase;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Group;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Product;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Topping;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Order\OrderItem;

class OrderItemTest extends TestCase
{

    public function testInstanceOrderItem()
    {
        $orderItem = new OrderItem(new Product(
            '1',
            'acai',
            'this acai is good',
            20,
            new Group('1', 'acais')
        ), 2);
        $this->assertEquals(2, $orderItem->getQuantity());
        $this->assertEquals('acai', $orderItem->getProduct()->getName());
        $this->assertEquals(20, $orderItem->getProduct()->getPrice());
        $this->assertEquals('acais', $orderItem->getProduct()->getGroupName());
        $this->assertEquals(40, $orderItem->calculateTotalPriceItem());
    }
    public function testCalculateTotalProductAndToppings()
    {
        $orderItem = new OrderItem(new Product(
            '1',
            'acai',
            'this acai is good',
            20,
            new Group('1', 'acais')
        ), 2);
        $orderItem->addTopping(
            new Topping(
                '1',
                'topping 1',
                'this is topping 1',
                10
            )
        );
        $orderItem->addTopping(
            new Topping(
                '2',
                'topping 2',
                'this is topping 2',
                10
            )
        );
        $this->assertEquals(80, $orderItem->calculateTotalPriceItem());
        $this->assertCount(2, $orderItem->getToppings());
    }
    public function testCreateOrderItemWithQuantityLessThen1()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Quantity must be greater than 0');
        new OrderItem(new Product('1', 'acai', 'this acai is good', 20, new Group('1', 'acais')), 0);
    }
    public function testCreateOrderItemWithPriceInOrderItem()
    {
        $orderItem = new OrderItem(new Product('1', 'acai', 'this acai is good', 20, new Group('1', 'acais')), 2);
        $orderItem->setPrice(15);
        $this->assertEquals(30, $orderItem->calculateTotalPriceItem());
    }
    public function testCreateOrderItemWithPriceInOrderItemAndAdittionalTopping()
    {
        $orderItem = new OrderItem(new Product('1', 'acai', 'this acai is good', 20, new Group('1', 'acais')), 2);
        $orderItem->setPrice(15);
        $orderItem->addTopping(
            new Topping(
                '1',
                'topping 1',
                'this is topping 1',
                10
            )
        );
        $this->assertEquals(50, $orderItem->calculateTotalPriceItem());
    }
}
