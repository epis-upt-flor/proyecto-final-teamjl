<?php
    declare(strict_types=1);

    use PHPUnit\Framework\TestCase;
    use App\Utils\EmailValidator;

    final class EmailValidatorTest extends TestCase
    {
        public function testValidEmail(): void
        {
            $this->assertTrue(EmailValidator::isValid('jorge@castaneda.com'));
        }

        public function testMissingAtSign(): void
        {
            $this->assertFalse(EmailValidator::isValid('jorge.castaneda.com'));
        }

        public function testInvalidDomain(): void
        {
            $this->assertFalse(EmailValidator::isValid('jorge@.com'));
        }
    }
?>