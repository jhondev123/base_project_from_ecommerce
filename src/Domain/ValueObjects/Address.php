<?php

namespace Jhonattan\BaseProjectFromEcommerce\Domain\ValueObjects;

class Address
{
    private readonly string $street;
    private readonly string $city;
    private readonly string $state;
    private readonly string $country;
    private readonly string $district;
    private readonly int $number;
    private readonly string $complement;
    private readonly string $zipCode;
    public function __construct(
        string $street,
        string $city,
        string $state,
        string $country,
        string $district,
        string $number,
        string $complement,
        string $zipCode
    ) {
        $this->validateZipCode($zipCode);
        $this->street = $street;
        $this->city = $city;
        $this->state = $state;
        $this->country = $country;
        $this->district = $district;
        $this->number = $number;
        $this->complement = $complement;
        $this->zipCode = $zipCode;
    }
    public function validateZipCode(string $zipCode): void
    {
        if (!preg_match("/^[0-9]{5}-?[0-9]{3}$/", $zipCode)) {
            throw new \InvalidArgumentException("Invalid zip code format.");
        }
    }
}
