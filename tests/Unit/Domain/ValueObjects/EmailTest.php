<?php

namespace Jhonattan\BaseProjectFromEcommerce\Tests\Unit\Domain\ValueObjects;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Jhonattan\BaseProjectFromEcommerce\Domain\ValueObjects\Email;

class EmailTest extends TestCase
{
    public static function generateValidEmail()
    {
        return [
            "Valid Emails" => [
                'john.doe@example.com',
                'john.doetest@example.com',
                'johndoe@example.com',
                'johndoe@example.co.uk'
            ]
        ];
    }
    public static function generateInvalidEmail()
    {
        return [
            "Invalid Emails" => [
                'invalid_email',
                'johndoe@example',
                'johndoe@.com',
                'johndoe@example..com',
                'johndoe@example@com',
                'johndoe@example.com.',
                'johndoe@example.com@com',
            ]
        ];
    }
    #[DataProvider('generateValidEmail')]
    public function testValidEmails(string $email)
    {
        $email = new Email($email);
        self::assertEquals($email->getEmail(), $email);
    }
    #[DataProvider('generateInvalidEmail')]
    public function testInvalidEmailsExpectsException(string $email)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid email address');
        new Email($email);
    }
}
