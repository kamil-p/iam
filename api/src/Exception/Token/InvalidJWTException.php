<?php

namespace App\Exception\Token;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

class InvalidJWTException extends AuthenticationException
{
    /**
     * {@inheritdoc}
     */
    public function getMessageKey()
    {
        return 'Invalid JWT.';
    }
}