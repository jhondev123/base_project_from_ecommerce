<?php

namespace Jhonattan\BaseProjectFromEcommerce\Domain\Entities;

class Group
{

    public function __construct(private string $id, private string $name) {}
    public function getId(): string
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
}
