<?php

namespace Jhonattan\BaseProjectFromEcommerce\Tests\Unit\Domain\ValueObjects;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Jhonattan\BaseProjectFromEcommerce\Domain\ValueObjects\Phone;

use function PHPUnit\Framework\assertEquals;

class PhoneTest extends TestCase
{
    public static function generateValidPhone()
    {
        return [
            "Valid Phones" => [
                '45999881234'
            ]
        ];
    }
    public static function generateInvalidPhone()
    {
        return [
            "Invalid Phones" => [
                'invalid_phone',
                '1234567890',
                '12345678901234567890',
                '+5512345678a90',
            ]
        ];
    }

    #[DataProvider('generateValidPhone')]
    public function testValidPhones(string $phoneNumber)
    {
        $phone = new Phone($phoneNumber);
        self::assertEquals($phoneNumber, $phone->getPhone());
    }
    #[DataProvider('generateInvalidPhone')]
    public function testInvalidPhonesExpectsException(string $phone)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid phone number format.');
        new Phone($phone);
    }
}
