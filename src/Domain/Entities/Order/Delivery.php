<?php

namespace Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Order;

use Jhonattan\BaseProjectFromEcommerce\Domain\ValueObjects\Address;

class Delivery
{
    private float $price;
    private Address $address;
    private \DateTimeInterface $deliveryForeCast;
    public function getPrice(): float
    {
        return $this->price;
    }
}
