<?php
namespace App\Utils;

class EmailValidator
{
    public static function isValid(string $email): bool
    {
        if (strpos($email, '@') === false) {
            return false;
        }
        
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}
?>