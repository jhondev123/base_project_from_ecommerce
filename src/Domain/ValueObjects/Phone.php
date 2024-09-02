<?php

namespace Jhonattan\BaseProjectFromEcommerce\Domain\ValueObjects;

class Phone
{

    private string $phoneNumber;
    public function __construct(string $phoneNumber)
    {
        $this->validatePhoneNumber($phoneNumber);
        $this->phoneNumber = $phoneNumber;
    }
    private function validatePhoneNumber(string $phone): void
    {
        $pattern = '/^(?:(?:\+|00)?(55)\s?)?(?:\(?([1-9][0-9])\)?\s?)?(?:((?:9\d|[2-9])\d{3})-?(\d{4}))$/';
        if (!preg_match($pattern, $phone)) {
            throw new \InvalidArgumentException("Invalid phone number format.");
        }
    }
    public function getPhone(): string
    {
        return $this->phoneNumber;
    }
    public function __toString(): string
    {
        return $this->phoneNumber;
    }
}
