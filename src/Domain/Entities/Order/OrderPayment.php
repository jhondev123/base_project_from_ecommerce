<?php

namespace Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Order;

use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Enums\PaymentMethod;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Enums\PaymentStatus;
use Jhonattan\BaseProjectFromEcommerce\Domain\Exceptions\InvalidPaymentStatusTransitionException as PaymentStatusException;

class OrderPayment
{
    public function __construct(private string $id, private PaymentMethod $method, private PaymentStatus $status) {}
    public function getMethod(): PaymentMethod
    {
        return $this->method;
    }
    public function getStatus(): PaymentStatus
    {
        return $this->status;
    }

    public function changePaymentStatus(PaymentStatus $newStatus): void
    {
        if ($this->status === $newStatus) {
            throw new PaymentStatusException('Payment status cannot be changed to the same status');
        }
        if ($this->status === PaymentStatus::CANCELLED) {
            throw new PaymentStatusException('Cannot change payment status of a cancelled order');
        }

        if ($this->status === PaymentStatus::PAID) {
            throw new PaymentStatusException('Cannot change payment status of a paid order');
        }
        $this->status = $newStatus;
    }
}
