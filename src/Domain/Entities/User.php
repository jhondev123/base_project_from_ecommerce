<?php

namespace Jhonattan\BaseProjectFromEcommerce\Domain\Entities;

use Jhonattan\BaseProjectFromEcommerce\Domain\ValueObjects\Email;
use Jhonattan\BaseProjectFromEcommerce\Domain\ValueObjects\Phone;
use Jhonattan\BaseProjectFromEcommerce\Domain\ValueObjects\Address;

class User
{
    private string $id;
    private string $name;
    private array $address;
    private Email $email;
    private Phone $phoneNumber;
    private bool $isAdmin;
    private string $password;
    public function __construct(
        string $id,
        string $name,
        Address|array $address,
        Email $email,
        Phone $phoneNumber,
        bool $isAdmin,
        string $password
    ) {
        $this->id = $id;
        $this->name = $name;
        if ($address instanceof Address) {
            array_push($this->address, $address);
        } else {
            $this->validateAddressesArray($address);
            $this->address = $address;
        }
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->isAdmin = $isAdmin;
        $this->password = $password;
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function getAddresses(): array
    {
        return $this->address;
    }
    public function getEmail(): Email
    {
        return $this->email;
    }
    public function getPhoneNumber(): Phone
    {
        return $this->phoneNumber;
    }
    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }
    public function addAddress(Address $address): void
    {
        array_push($this->address, $address);
    }
    public function validateAddressesArray(array $addresses): void
    {
        if (empty($addresses)) {
            throw new \InvalidArgumentException("Addresses array cannot be empty.");
        }
    }
}
