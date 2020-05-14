<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\User;
use App\Repository\UserRepository;
use Generator;

class GetUsersDataProvider implements CollectionDataProviderInterface, ItemDataProviderInterface, RestrictedDataProviderInterface
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return User::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null): Generator
    {
        $users = $this->userRepository->findALlIncludingDeleted();

        foreach ($users as $user) {
            yield $user;
        }
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?User
    {
        return $this->userRepository->findOneIncludingDeleted($id);
    }
}