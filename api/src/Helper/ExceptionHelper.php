<?php

namespace App\Helper;

use Throwable;

class ExceptionHelper
{
    public static function toLoggerContext(Throwable $e)
    {
        return [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ];
    }
}