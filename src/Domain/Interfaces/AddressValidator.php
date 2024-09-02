<?php

namespace Jhonattan\BaseProjectFromEcommerce\Domain\Interfaces;

interface AddressValidator
{
    public function validate(string $zipCode): bool;
}
