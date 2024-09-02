<?php

namespace Jhonattan\BaseProjectFromEcommerce\Domain\Entities;

class Driver
{
    private string $id;
    private string $name;
    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
    public function getName(): string
    {
        return $this->name;
    }
}
