<?php

namespace Jhonattan\BaseProjectFromEcommerce\Domain\Entities;

class Product
{
    private string $id;
    private string $name;
    private string $description;
    private float $price;
    private Group $group;

    public function __construct(
        string $id,
        string $name,
        string $description,
        float $price,
        Group $group
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->group = $group;
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
    public function getGroup(): Group
    {
        return $this->group;
    }
    public function getGroupName():string
    {
        return $this->group->getName();
        
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}
