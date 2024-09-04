<?php

namespace Jhonattan\BaseProjectFromEcommerce\Application\UseCases\Encripter;

use Jhonattan\BaseProjectFromEcommerce\Domain\Interfaces\Encrypter;

class EncryptPasswordUseCase
{
    public function __construct(private Encrypter $encrypter) {}
    public function execute(string $password): string
    {
        return $this->encrypter->encrypt($password);
    }
}
