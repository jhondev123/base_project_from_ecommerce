<?php

namespace Jhonattan\BaseProjectFromEcommerce\Application\Factories;

use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Order;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Payment;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Customer;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Delivery;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\OrderItem;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Enums\OrderStatus;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Enums\PaymentStatus;

final class OrderFactory
{
    private Order $order;
    public function createOrderComplete(
        string $id,
        array $orderItems,
        Payment $payment,
        PaymentStatus $paymentStatus,
        OrderStatus $status,
        Customer $customer,
        Delivery $delivery
    ): void {
        $this->order = new Order(
            $id,
            $orderItems,
            $payment,
            $customer,
            $delivery,
            $paymentStatus,
            $status
        );
    }
    public function addItem(OrderItem $item): void
    {
        $this->order->addOrderItem($item);
    }
}
