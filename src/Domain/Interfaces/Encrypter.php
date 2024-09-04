<?php

namespace Jhonattan\BaseProjectFromEcommerce\Domain\Interfaces;

interface Encrypter
{
    public function encrypt(string $value): string;
}
