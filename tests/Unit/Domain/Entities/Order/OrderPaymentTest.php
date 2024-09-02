<?php

namespace Jhonattan\BaseProjectFromEcommerce\Tests\Unit\Domain\Entities\Order;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Order\OrderPayment;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Enums\PaymentMethod;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Enums\PaymentStatus;
use Jhonattan\BaseProjectFromEcommerce\Domain\Exceptions\InvalidPaymentStatusTransitionException as PaymentStatusException;

class OrderPaymentTest extends TestCase
{
    public function testCreateOrderPayment()
    {
        $orderPayment = new OrderPayment(
            '123',
            PaymentMethod::CREDIT_CARD,
            PaymentStatus::PAID
        );
        $this->assertEquals(PaymentMethod::CREDIT_CARD, $orderPayment->getMethod());
        $this->assertEquals(PaymentStatus::PAID, $orderPayment->getStatus());
    }
    public function testCreateOrderPaymentWithInvalidMethod()
    {
        $this->expectException(\ValueError::class);
        $this->expectExceptionMessage('"INVALID_METHOD" is not a valid backing value for enum');

        $orderPayment = new OrderPayment(
            '123',
            PaymentMethod::from('INVALID_METHOD'),
            PaymentStatus::PAID
        );
    }
    public function testCreateOrderPaymentWithInvalidStatus()
    {
        $this->expectException(\ValueError::class);
        $this->expectExceptionMessage('"INVALID_STATUS" is not a valid backing value for enum');

        $orderPayment = new OrderPayment(
            '123',
            PaymentMethod::CREDIT_CARD,
            PaymentStatus::from('INVALID_STATUS')
        );
    }
    public function testChangePaymentStatusValid()
    {
        $orderPayment = new OrderPayment(
            '123',
            PaymentMethod::CREDIT_CARD,
            PaymentStatus::PENDING
        );
        $orderPayment->changePaymentStatus(PaymentStatus::PAID);
        $this->assertEquals(PaymentStatus::PAID, $orderPayment->getStatus());
    }
    public function testChangePaymentStatusFromCancelledToPaid()
    {
        $this->expectException(PaymentStatusException::class);
        $this->expectExceptionMessage('Cannot change payment status of a cancelled order');
        $orderPayment = new OrderPayment(
            '123',
            PaymentMethod::CREDIT_CARD,
            PaymentStatus::CANCELLED
        );
        $orderPayment->changePaymentStatus(PaymentStatus::PAID);
    }
    public function testChangePaymentStatusFromPaidToCancelled()
    {
        $this->expectException(PaymentStatusException::class);
        $this->expectExceptionMessage('Cannot change payment status of a paid order');
        $orderPayment = new OrderPayment(
            '123',
            PaymentMethod::CREDIT_CARD,
            PaymentStatus::PAID
        );
        $orderPayment->changePaymentStatus(PaymentStatus::CANCELLED);
    }
    public function testChangePaymentStatusForTheSameCurrent()
    {
        $this->expectException(PaymentStatusException::class);
        $this->expectExceptionMessage('Payment status cannot be changed to the same status');
        $orderPayment = new OrderPayment(
            '123',
            PaymentMethod::CREDIT_CARD,
            PaymentStatus::PAID
        );
        $orderPayment->changePaymentStatus(PaymentStatus::PAID);
    }
}
