<?php

namespace App\Normalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class copied from http://thinktocode.com/2018/05/10/symfony-validator-with-fos-rest/
 */
final class ConstraintViolationListNormalizer implements NormalizerInterface
{
    /**
     * @inheritDoc
     */
    public function normalize($object, $format = null, array $context = array()): array
    {
        [$messages, $violations] = $this->getMessagesAndViolations($object);
        return [
            'title' => $context['title'] ?? 'An error occurred',
            'detail' => $messages ? implode("\n", $messages) : '',
            'violations' => $violations,
        ];
    }

    private function getMessagesAndViolations(ConstraintViolationListInterface $constraintViolationList): array
    {
        $violations = $messages = [];
        /** @var ConstraintViolation $violation */
        foreach ($constraintViolationList as $violation) {
            $violations[] = [
                'propertyPath' => $violation->getPropertyPath(),
                'message' => $violation->getMessage(),
                'code' => $violation->getCode(),
            ];
            $propertyPath = $violation->getPropertyPath();
            $messages[] = ($propertyPath ? $propertyPath.': ' : '').$violation->getMessage();
        }
        return [$messages, $violations];
    }

    /**
     * @inheritDoc
     */
    public function supportsNormalization($data, $format = null): bool
    {
        return $data instanceof ConstraintViolationListInterface;
    }
}