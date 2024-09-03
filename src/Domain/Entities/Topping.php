<?php

namespace Jhonattan\BaseProjectFromEcommerce\Domain\Entities;

class Topping
{
    private string $id;
    private string $name;
    private string $description;
    private float $price;

    public function __construct(string $id, string $name, string $description, float $price)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
    
}
