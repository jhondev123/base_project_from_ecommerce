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

class OrderTest extends TestCase
{
    public function testInstanceOrder()
    {
        $address = new Address(
            'Street',
            '123',
            'City',
            'State',
            'Country',
            '12345',
            'Apt',
            '85806252'
        );
        $driver = new Driver('1', 'jhonattan');
        $email = new Email('johndoe@example.com');
        $phone = new Phone('45999338406');

        $user = new User('1', 'John Doe', $address, $email, $phone, true, '1234');
        $payment = new OrderPayment('123', PaymentMethod::CREDIT_CARD, PaymentStatus::PAID);

        $delivery = new Delivery('456', 10.0, $driver, $address, new DateTime());
        $product = new Product('1', 'Product 1', 'description', 10.0, new Group('1', 'Group 1'));
        $orderItems = [(new OrderItem($product, 1))->addTopping(new Topping('1', 'ninho', '', 10))];

        $order = new Order('789', $orderItems, $payment, $user, $delivery, OrderStatus::CONFIRMED);

        $this->assertEquals(OrderStatus::CONFIRMED, $order->getStatus());
        $this->assertEquals(30.0, $order->getTotal());
    }
}
