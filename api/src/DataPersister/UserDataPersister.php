<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\User;
use App\Repository\UserRepository;
use DateTime;
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

    public function supports($user, array $context = []): bool
    {
        return $user instanceof User;
    }

    /**
     * @param User $user
     * @param array $context
     * @return object|void
     */
    public function persist($user, array $context = [])
    {
        $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
        $this->userRepository->save($user);
        return $user;
    }

    /**
     * @param User $user
     * @param array $context
     */
    public function remove($user, array $context = [])
    {
        $user->setDeletedAt(new DateTime());
        $this->userRepository->save($user);
    }
}