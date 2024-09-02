<?php

namespace Jhonattan\BaseProjectFromEcommerce\Domain\ValueObjects;

class Email
{
    private string $email;
    public function __construct(string $email)
    {
        $this->validateEmail($email);
        $this->email = $email;
    }
    private function validateEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email address');
        }
    }
    public function __toString(): string
    {
        return $this->email;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
}
