<?php

namespace Jhonattan\BaseProjectFromEcommerce\Tests\Unit\Domain\Entities\Order;

use DateTime;
use PHPUnit\Framework\TestCase;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\User;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Group;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Driver;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Product;
use Jhonattan\BaseProjectFromEcommerce\Domain\ValueObjects\Email;
use Jhonattan\BaseProjectFromEcommerce\Domain\ValueObjects\Phone;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Order\Order;
use Jhonattan\BaseProjectFromEcommerce\Domain\ValueObjects\Address;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Order\Delivery;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Order\OrderItem;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Enums\OrderStatus;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Order\OrderPayment;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Enums\PaymentMethod;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Enums\PaymentStatus;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Topping;
use Jhonattan\BaseProjectFromEcommerce\Domain\Exceptions\InvalidOrderStatusTransitionException;

class OrderTest extends TestCase
{
    private User $user;
    private OrderPayment $payment;
    private Delivery $delivery;
    private Product $product;
    private OrderItem $orderItem;

    protected function setUp(): void
    {
        $address = new Address('Street', '123', 'City', 'State', 'Country', '12345', 'Apt', '85806252');
        $driver = new Driver('1', 'jhonattan');
        $email = new Email('johndoe@example.com');
        $phone = new Phone('45999338406');

        $this->user = new User('1', 'John Doe', $address, $email, $phone, true, '1234');
        $this->payment = new OrderPayment('123', PaymentMethod::CREDIT_CARD, PaymentStatus::PAID);
        $this->delivery = new Delivery('456', 10.0, $driver, $address, new DateTime());
        $this->product = new Product('1', 'Product 1', 'description', 10.0, new Group('1', 'Group 1'));
        $this->orderItem = new OrderItem($this->product, 1);
    }

    public function testOrderCreation()
    {
        $order = new Order('789', [$this->orderItem], $this->payment, $this->user, $this->delivery, OrderStatus::CONFIRMED);

        $this->assertEquals(OrderStatus::CONFIRMED, $order->getStatus());
        $this->assertEquals(20.0, $order->getTotal()); // 10.0 (product) + 10.0 (delivery)
    }

    public function testOrderCreationWithToppings()
    {
        $topping = new Topping('1', 'ninho', '', 5.0);
        $this->orderItem->addTopping($topping);

        $order = new Order('789', [$this->orderItem], $this->payment, $this->user, $this->delivery, OrderStatus::CONFIRMED);

        $this->assertEquals(25.0, $order->getTotal()); // 10.0 (product) + 5.0 (topping) + 10.0 (delivery)
    }

    public function testChangeOrderStatus()
    {
        $order = new Order('789', [$this->orderItem], $this->payment, $this->user, $this->delivery, OrderStatus::CONFIRMED);

        $order->changeOrderStatus(OrderStatus::INDELIVERY);
        $this->assertEquals(OrderStatus::INDELIVERY, $order->getStatus());
    }

    public function testChangeOrderStatusToSameStatus()
    {
        $order = new Order('789', [$this->orderItem], $this->payment, $this->user, $this->delivery, OrderStatus::CONFIRMED);

        $this->expectException(InvalidOrderStatusTransitionException::class);
        $order->changeOrderStatus(OrderStatus::CONFIRMED);
    }

    public function testChangeOrderStatusAfterDelivery()
    {
        $order = new Order('789', [$this->orderItem], $this->payment, $this->user, $this->delivery, OrderStatus::DELIVERED);

        $this->expectException(InvalidOrderStatusTransitionException::class);
        $order->changeOrderStatus(OrderStatus::CANCELLED);
    }

    public function testChangeOrderStatusOfCancelledOrder()
    {
        $order = new Order('789', [$this->orderItem], $this->payment, $this->user, $this->delivery, OrderStatus::CANCELLED);

        $this->expectException(InvalidOrderStatusTransitionException::class);
        $order->changeOrderStatus(OrderStatus::CONFIRMED);
    }

    public function testChangeOrderStatusOfRefusedOrder()
    {
        $order = new Order('789', [$this->orderItem], $this->payment, $this->user, $this->delivery, OrderStatus::REFUSED);

        $this->expectException(InvalidOrderStatusTransitionException::class);
        $order->changeOrderStatus(OrderStatus::CONFIRMED);
    }

    public function testChangeOrderStatusBeforePayment()
    {
        $unpaidPayment = new OrderPayment('123', PaymentMethod::CREDIT_CARD, PaymentStatus::PENDING);
        $order = new Order('789', [$this->orderItem], $unpaidPayment, $this->user, $this->delivery, OrderStatus::PENDING);

        $this->expectException(InvalidOrderStatusTransitionException::class);
        $order->changeOrderStatus(OrderStatus::CONFIRMED);
    }

    public function testInvalidOrderStatusTransition()
    {
        $order = new Order('789', [$this->orderItem], $this->payment, $this->user, $this->delivery, OrderStatus::PENDING);

        $this->expectException(InvalidOrderStatusTransitionException::class);
        $order->changeOrderStatus(OrderStatus::DELIVERED);
    }

    public function testAddOrderItem()
    {
        $order = new Order('789', [$this->orderItem], $this->payment, $this->user, $this->delivery, OrderStatus::CONFIRMED);
        $initialTotal = $order->getTotal();

        $newProduct = new Product('2', 'Product 2', 'description', 15.0, new Group('1', 'Group 1'));
        $newOrderItem = new OrderItem($newProduct, 1);
        $order->addOrderItem($newOrderItem);

        $this->assertEquals($initialTotal + 15.0, $order->getTotal());
    }

    public function testOrderCreationWithEmptyOrderItems()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Order Items cannot be empty');

        new Order('789', [], $this->payment, $this->user, $this->delivery, OrderStatus::CONFIRMED);
    }

    public function testOrderCreationWithInvalidOrderItem()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Invalid Order Item');

        new Order('789', [$this->orderItem, 'invalid item'], $this->payment, $this->user, $this->delivery, OrderStatus::CONFIRMED);
    }

    public function testOrderCreationWithEmptyId()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Invalid Order ID');

        new Order('', [$this->orderItem], $this->payment, $this->user, $this->delivery, OrderStatus::CONFIRMED);
    }
}
