<?php

namespace App\Swagger;


use App\Resources\Authentication;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class SwaggerDecorator implements NormalizerInterface
{
    private NormalizerInterface $decorated;

    public function __construct(NormalizerInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function supportsNormalization($data, $format = null): bool
    {
        return $this->decorated->supportsNormalization($data, $format);
    }

    public function normalize($object, $format = null, array $context = [])
    {
        $docs = $this->decorated->normalize($object, $format, $context);

        $customSchemas = Authentication::getSwaggerSchemas();

        foreach ($customSchemas as $schemaName => $schemaAttributes) {
            $docs['components']['schemas'][$schemaName] = $schemaAttributes;
        }

        $customPaths = [];
        $customPaths = array_merge($customPaths, Authentication::getSwaggerPath());

        $documentation = [];
        foreach ($customPaths as $path => $pathAttributes) {
            $documentation['paths'][$path] = $pathAttributes;
        }


        return array_merge_recursive($docs, $documentation);
    }
}