<?php

namespace App\Security;

use Firebase\JWT\JWT as JWTFirebase;

class JWT
{
    private const ALGORITHM = 'RS256';

    private string $privateKey;

    private string $publicKey;

    public function __construct(string $privateKey, string $publicKey)
    {
        $this->privateKey = $privateKey;
        $this->publicKey = $publicKey;
    }

    public function encode(array $payload): string
    {
        return JWTFirebase::encode($payload, $this->privateKey, self::ALGORITHM);
    }

    public function decode(string $token): object
    {
        return JWTFirebase::decode($token, $this->publicKey, [self::ALGORITHM]);
    }
}