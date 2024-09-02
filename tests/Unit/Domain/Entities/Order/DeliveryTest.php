<?php

namespace Jhonattan\BaseProjectFromEcommerce\Tests\Unit\Domain\Entities\Order;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Driver;
use Jhonattan\BaseProjectFromEcommerce\Domain\ValueObjects\Address;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Order\Delivery;

class DeliveryTest extends TestCase
{
    public function testInstanceDelivery()
    {
        $delivery = new Delivery(
            '1',
            10.0,
            new Driver('1', 'John Doe'),
            new Address('123 Main St', 'Anytown', 'CA', '90210', 'USA', '123', 'John Doe@example.com', '85806-252'),
            new \DateTime('2022-01-01')
        );
        $this->assertEquals(10.0, $delivery->getPrice());
        $this->assertEquals('John Doe', $delivery->getDriver()->getName());
        $this->assertEquals('123 Main St', $delivery->getAddress()->getStreet());
        $this->assertInstanceOf(\DateTimeInterface::class, $delivery->getDeliveryForeCast());
    }
}
