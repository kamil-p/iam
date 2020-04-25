<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class UserDataPersister implements ContextAwareDataPersisterInterface
{
    private UserRepository $userRepository;

    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof User;
    }

    /**
     * @param User $data
     * @param array $context
     * @return object|void
     */
    public function persist($data, array $context = [])
    {
        $data->setPassword($this->passwordEncoder->encodePassword($data, $data->getPassword()));
        $this->userRepository->save($data);
        return $data;
    }

    public function remove($data, array $context = [])
    {
        // call your persistence layer to delete $data
    }
}