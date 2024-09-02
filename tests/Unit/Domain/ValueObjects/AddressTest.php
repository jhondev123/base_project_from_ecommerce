<?php

namespace Jhonattan\BaseProjectFromEcommerce\Tests\Unit\Domain\ValueObjects;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Jhonattan\BaseProjectFromEcommerce\Domain\ValueObjects\Address;
use InvalidArgumentException;

class AddressTest extends TestCase
{
    public static function generateValidAddress(): array
    {
        return [
            "valid addresses" => [
                [
                    [
                        'Rua Teste, 123',
                        'Cidade Teste',
                        'UF Teste',
                        'País Teste',
                        'Bairro Teste',
                        '123',
                        'Complemento Teste',
                        '85806-252'
                    ]
                ]
            ]
        ];
    }

    public static function generateInvalidAddress(): array
    {
        return [
            "invalid addresses" => [
                [
                    'Rua Teste, 123',
                    'Cidade Teste',
                    'UF Teste',
                    'País Teste',
                    'Bairro Teste',
                    '123',
                    'Complemento Teste',
                    '85806-2521'
                ]
            ]
        ];
    }
    public static function generateValidZipCodes()
    {
        return [
            'valid zip codes' => [
                '85806-252',
                '85806252',
                '85806252-1',
                '858062521',
                '8580625212',
                '85806252-12',
            ]
        ];
    }
    public static function generateInValidZipCodes()
    {
        return [

            'invalid zip codes' => [
                '85806-2521',
                '85806252-1',
                '858062521',
                '8580625212',
                '85806252-12',
                '85806252123'

            ]

        ];
    }

    #[DataProvider('generateValidAddress')]
    public function testValidAddresses(array $addresses): void
    {
        foreach ($addresses as $address) {
            $addressObject = new Address(
                $address[0],
                $address[1],
                $address[2],
                $address[3],
                $address[4],
                $address[5],
                $address[6],
                $address[7]
            );

            self::assertEquals($address[0], $addressObject->getStreet());
            self::assertEquals($address[1], $addressObject->getCity());
            self::assertEquals($address[2], $addressObject->getState());
            self::assertEquals($address[3], $addressObject->getCountry());
            self::assertEquals($address[4], $addressObject->getDistrict());
            self::assertEquals($address[5], $addressObject->getNumber());
            self::assertEquals($address[6], $addressObject->getComplement());
            self::assertEquals($address[7], $addressObject->getZipCode());
        }
    }

    #[DataProvider('generateInvalidAddress')]
    public function testInvalidAddresses(array $address): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Address(
            $address[0],
            $address[1],
            $address[2],
            $address[3],
            $address[4],
            $address[5],
            $address[6],
            $address[7]
        );
    }
    #[DataProvider('generateValidZipCodes')]
    public function testValidZipCodes(string $zipCode)
    {

        Address::validateZipCode($zipCode);
        $this->assertTrue(true);
    }
    #[DataProvider('generateInValidZipCodes')]
    public function testInvalidZipCodes(string $zipCode)
    {
        $this->expectException(InvalidArgumentException::class);

        Address::validateZipCode($zipCode);
    }
}
