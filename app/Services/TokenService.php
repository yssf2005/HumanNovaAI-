<?php
namespace App\Services;

class TokenService
{
    public static function generateSelector(): string
    {
        return bin2hex(random_bytes(12)); // 24 hex chars
    }

    public static function generateValidator(): string
    {
        return bin2hex(random_bytes(32)); // 64 hex chars
    }

    public static function hashValidator(string $validator): string
    {
        $pepper = defined('TOKEN_PEPPER') ? constant('TOKEN_PEPPER') : '';
        return hash('sha256', $validator . $pepper);
    }

    public static function verifyValidator(string $validator, string $storedHash): bool
    {
        $check = self::hashValidator($validator);
        return hash_equals($storedHash, $check);
    }

    public static function createSelectorValidatorPair(): array
    {
        $selector = self::generateSelector();
        $validator = self::generateValidator();
        $validatorHash = self::hashValidator($validator);
        return ['selector' => $selector, 'validator' => $validator, 'validator_hash' => $validatorHash];
    }
}