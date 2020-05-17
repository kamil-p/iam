<?php

namespace App\Normalizer;

use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer as APIPlatformDateTimeNormalizer;

class DateTimeNormalizer extends APIPlatformDateTimeNormalizer
{
    public function denormalize($data, $type, $format = null, array $context = [])
    {
        if (null === $data) {
            return null;
        }

        parent::denormalize($data, $type, $format, $context);
    }
}