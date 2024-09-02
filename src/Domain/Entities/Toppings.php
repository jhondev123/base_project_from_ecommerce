<?php

namespace Jhonattan\BaseProjectFromEcommerce\Domain\Entities;

class Toppings
{
    private string $id;
    private string $name;
    private string $description;
    private float $price;


    public function getPrice(): float
    {
        return $this->price;
    }
}
