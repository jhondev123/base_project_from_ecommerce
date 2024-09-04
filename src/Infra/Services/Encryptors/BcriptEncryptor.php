<?php

namespace Jhonattan\BaseProjectFromEcommerce\Infra\Services\Encryptors;

use Jhonattan\BaseProjectFromEcommerce\Domain\Interfaces\Encrypter;

class BcriptEncryptor implements Encrypter
{
    public function encrypt(string $value): string
    {
        return password_hash($value, PASSWORD_BCRYPT);
    }
}
