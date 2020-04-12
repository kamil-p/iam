<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Resources\Authentication;
use DateTime;
use \Firebase\JWT\JWT;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class TokenService
{
    private const ALGORITHM = 'RS256';

    private string $privateKey;

    private string $publicKey;

    private UserRepository $userRepository;

    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(string $privateKey, string $publicKey, UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->privateKey = $privateKey;
        $this->publicKey = $publicKey;
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function createTokens(Authentication $authentication)
    {
        $user = $this->userRepository->findByEmail($authentication->getEmail());

        if(!$this->passwordEncoder->isPasswordValid($user, $authentication->getPassword())) {
            throw new BadRequestHttpException("Invalid password");
        }

        $token = $user->createNewToken();

        $authentication->setToken($this->createJWTTokenFromUser($user));
        $authentication->setRefreshToken($token->getRefreshToken());

        $this->userRepository->save($user);
    }

    public function createJWTTokenFromUser(User $user): string
    {
        $expiresAt = new DateTime();
        $expiresAt->modify('+1 hour');

        $payload = $user->toArray();
        $payload['expiresAt'] = $expiresAt->getTimestamp();

        return JWT::encode($payload, $this->privateKey, self::ALGORITHM);
    }
}