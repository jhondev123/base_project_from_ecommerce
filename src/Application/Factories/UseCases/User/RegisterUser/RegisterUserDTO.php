<?php

namespace Jhonattan\BaseProjectFromEcommerce\Application\Factories\UseCases\User\RegisterUser;

use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\User;
use Jhonattan\BaseProjectFromEcommerce\Domain\ValueObjects\Email;
use Jhonattan\BaseProjectFromEcommerce\Domain\ValueObjects\Phone;

class RegisterUserDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public array $address = [],
        public string $email,
        public string $phoneNumber,
        public bool $isAdmin,
        public string $password,


    ) {}
    public function toEntity()
    {
        return new User(
            $this->id,
            $this->name,
            $this->address,
            new Email($this->email),
            new Phone($this->phoneNumber),
            $this->isAdmin,
            $this->password,
        );
    }
}
