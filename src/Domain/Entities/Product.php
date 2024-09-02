<?php

namespace Jhonattan\BaseProjectFromEcommerce\Domain\Entities;

class Product
{
    private string $id;
    private string $name;
    private float $price;

    public function getPrice():float
    {
        return $this->price;
        
    }

}
