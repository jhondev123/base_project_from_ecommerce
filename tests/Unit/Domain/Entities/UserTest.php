<?php

namespace Jhonattan\BaseProjectFromEcommerce\Tests\Unit\Domain\Entities;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\User;
use Jhonattan\BaseProjectFromEcommerce\Domain\ValueObjects\Email;
use Jhonattan\BaseProjectFromEcommerce\Domain\ValueObjects\Phone;
use Jhonattan\BaseProjectFromEcommerce\Domain\ValueObjects\Address;

class UserTest extends TestCase
{
    public static function generateUserWithOneAddress()
    {
        $address = new Address('Street 1', 'City 1', 'State 1', 'Country 1', 'District 1', '123', 'Apt 1', '12345-678');
        $email = new Email('john.doe@example.com');
        $phone = new Phone('11999999999');
        $user = new User(
            '123',
            'John Doe',
            $address,
            $email,
            $phone,
            false,
            'password123'
        );
        return [
            [$user]
        ];
    }
    public static function generateUserWithTwoAddress()
    {
        $addresses = [];
        $address1 = new Address('Street 1', 'City 1', 'State 1', 'Country 1', 'District 1', '123', 'Apt 1', '12345-678');
        $address2 = new Address('Street 2', 'City 2', 'State 2', 'Country 2', 'District 2', '456', 'Apt 2', '12345-678');
        array_push($addresses, $address1, $address2);
        $email = new Email('john.doe@example.com');
        $phone = new Phone('11999999999');
        $user = new User(
            '123',
            'John Doe',
            $addresses,
            $email,
            $phone,
            false,
            'password123'
        );
        return [
            [$user]
        ];
    }
    public function testCreateUserWithOneAddress()
    {
        $address = new Address('Street 1', 'City 1', 'State 1', 'Country 1', 'District 1', '123', 'Apt 1', '12345-678');
        $email = new Email('john.doe@example.com');
        $phone = new Phone('11999999999');
        $user = new User(
            '123',
            'John Doe',
            $address,
            $email,
            $phone,
            false,
            'password123'
        );
        $this->assertEquals('John Doe', $user->getName());
        $this->assertEquals([$address], $user->getAddresses());
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($phone, $user->getPhoneNumber());
        $this->assertFalse($user->isAdmin());
        $this->assertEquals('password123', $user->getPassword());
    }
    #[DataProvider('generateUserWithOneAddress')]
    public function testCreateUserWithTwoAddresses($user)
    {
        $newAddress = new Address('Street 1', 'City 1', 'State 1', 'Country 1', 'District 1', '123', 'Apt 1', '12345-678');
        $user->addAddress($newAddress);
        $this->assertCount(2, $user->getAddresses());
        $this->assertEquals($newAddress->getStreet(), $user->getAddresses()[1]->getStreet());
        $this->assertEquals($newAddress->getCity(), $user->getAddresses()[1]->getCity());
        $this->assertEquals($newAddress->getState(), $user->getAddresses()[1]->getState());
        $this->assertEquals($newAddress->getCountry(), $user->getAddresses()[1]->getCountry());
        $this->assertEquals($newAddress->getDistrict(), $user->getAddresses()[1]->getDistrict());
        $this->assertEquals($newAddress->getZipCode(), $user->getAddresses()[1]->getZipCode());
    }
    #[DataProvider('generateUserWithTwoAddress')]
    public function testCreateUserStartingTwoAddresses($user)
    {
        $newAddress = new Address('Street 1', 'City 1', 'State 1', 'Country 1', 'District 1', '123', 'Apt 1', '12345-678');
        $user->addAddress($newAddress);
        $this->assertCount(3, $user->getAddresses());

    }
}
