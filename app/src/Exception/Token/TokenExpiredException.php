<?php

namespace App\Exception\Token;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

class TokenExpiredException extends AuthenticationException
{
    /**
     * {@inheritdoc}
     */
    public function getMessageKey()
    {
        return 'Token expired.';
    }
}