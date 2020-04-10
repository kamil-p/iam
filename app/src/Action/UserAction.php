<?php

namespace App\Action;

use ApiPlatform\Core\Api\Entrypoint;
use ApiPlatform\Core\Metadata\Resource\Factory\ResourceNameCollectionFactoryInterface;

class UserAction
{
    private $resourceNameCollectionFactory;

    public function __construct(ResourceNameCollectionFactoryInterface $resourceNameCollectionFactory)
    {
        $this->resourceNameCollectionFactory = $resourceNameCollectionFactory;
    }

    public function __invoke(): Entrypoint
    {
        return new Entrypoint($this->resourceNameCollectionFactory->create());
    }
}