<?php

namespace Jhonattan\BaseProjectFromEcommerce\Domain\Entities;

use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Customer;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Delivery;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\OrderItem;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Enums\OrderStatus;
use DomainException;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Enums\PaymentStatus;
use Jhonattan\BaseProjectFromEcommerce\Domain\Exceptions\InvalidOrderStatusTransitionException as OrderStatusException;
use Jhonattan\BaseProjectFromEcommerce\Domain\Exceptions\InvalidPaymentStatusTransitionException as PaymentStatusException;

class Order
{
    private string $id;

    private array $orderItems;
    private Payment $payment;
    private Customer $customer;
    private OrderStatus $status;
    private PaymentStatus $paymentStatus;
    private float $total;
    private Delivery $delivery;

    public function __construct(
        string $id,
        array $orderItems,
        Payment $payment,
        Customer $customer,
        Delivery $delivery
    ) {
        $this->validateId($id);
        $this->id = $id;
        $this->validateOrderItems($orderItems);
        $this->orderItems = $orderItems;
        $this->payment = $payment;
        $this->customer = $customer;
        $this->delivery = $delivery;
        $this->total = $this->calculateTotal();
    }
    private function calculateTotal(): float
    {
        $total = array_reduce($this->orderItems, function ($sum, OrderItem $item) {
            return $sum + $item->calculateTotalPriceItem();
        }, 0);

        return $total + $this->delivery->getPrice();
    }
    private function validateId($id): void
    {
        if ($id == null || $id == '') {
            throw new DomainException('Invalid Order ID');
        }
    }
    private function validateOrderItems(array $orderItems): void
    {
        if (empty($orderItems)) {
            throw new DomainException('Order Items cannot be empty');
        }
        foreach ($orderItems as $item) {
            if (!$item instanceof OrderItem) {
                throw new DomainException('Invalid Order Item');
            }
        }
    }
    public function changeOrderStatus(OrderStatus $newStatus): void
    {
        $this->validateChangeOrderStatus($newStatus);
        $this->status = $newStatus;
    }
    private function validateChangeOrderStatus(OrderStatus $newStatus): void
    {
        if ($this->status === $newStatus) {
            throw new OrderStatusException('Order status cannot be changed to the same status');
        }

        if ($this->status === OrderStatus::DELIVERED) {
            throw new OrderStatusException('Cannot change order status after being delivered');
        }

        if ($this->status === OrderStatus::CANCELLED) {
            throw new OrderStatusException('Cannot change status of a cancelled order');
        }

        if ($this->status === OrderStatus::REFUSED) {
            throw new OrderStatusException('Cannot change status of a Refused order');
        }

        if ($this->paymentStatus !== PaymentStatus::PAID) {
            throw new OrderStatusException('Cannot change order status before payment is made');
        }

        $validTransitions = [
            OrderStatus::PENDING->name => [OrderStatus::REFUSED, OrderStatus::CONFIRMED, OrderStatus::CANCELLED],
            OrderStatus::CONFIRMED->name => [OrderStatus::INDELIVERY, OrderStatus::CANCELLED],
            OrderStatus::INDELIVERY->name => [OrderStatus::DELIVERED, OrderStatus::CANCELLED],
        ];

        $transition = $validTransitions[$this->status->name] ?? [];
        if (!in_array($newStatus, $transition)) {
            throw new OrderStatusException(
                "Invalid transition from {$this->status->name}, to {$newStatus->name}"
            );
        }
    }
    public function changePaymentStatus(PaymentStatus $newStatus): void
    {
        if ($this->paymentStatus === $newStatus) {
            throw new PaymentStatusException('Payment status cannot be changed to the same status');
        }
        if ($this->paymentStatus === PaymentStatus::CANCELLED) {
            throw new PaymentStatusException('Cannot change payment status of a cancelled order');
        }

        if ($this->paymentStatus === PaymentStatus::PAID) {
            throw new PaymentStatusException('Cannot change payment status of a paid order');
        }
        $this->paymentStatus = $newStatus;
    }
}
