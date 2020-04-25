<?php

namespace App\Service;

use App\Entity\User;
use App\Exception\Token\InvalidJWTException;
use App\Exception\Token\TokenExpiredException;
use App\Helper\ExceptionHelper;
use App\Repository\TokenRepository;
use App\Repository\UserRepository;
use App\Resources\Authentication;
use App\Security\JWT;
use DateTime;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Throwable;

class TokenService
{
    const PROPERTY_EXPIRES_AT = 'expiresAt';

    private JWT $jwt;

    private UserRepository $userRepository;

    private TokenRepository $tokenRepository;

    private UserPasswordEncoderInterface $passwordEncoder;

    private LoggerInterface $logger;

    public function __construct(JWT $jwt, UserRepository $userRepository, TokenRepository $tokenRepository, UserPasswordEncoderInterface $passwordEncoder, LoggerInterface $logger)
    {
        $this->jwt = $jwt;
        $this->userRepository = $userRepository;
        $this->tokenRepository = $tokenRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->logger = $logger;
    }

    public function createTokens(Authentication $authentication): Authentication
    {
        $user = $this->userRepository->findByEmail($authentication->getEmail());

        if(!$this->passwordEncoder->isPasswordValid($user, $authentication->getPassword())) {
            throw new BadRequestHttpException("Invalid password");
        }

        $this->tokenRepository->deleteExpiredTokens($user);
        $token = $user->getValidToken();

        $authentication->setToken($this->createJWTTokenFromUser($user));
        $authentication->setRefreshToken($token->getRefreshToken());

        $this->userRepository->save($user);

        return $authentication;
    }

    public function refreshToken(Authentication $authentication): Authentication
    {
        $token = $this->tokenRepository->findByRefreshToken($authentication->getRefreshToken());

        if(!$token) {
            throw new BadRequestHttpException("Invalid password");
        }

        $authentication->setToken($this->createJWTTokenFromUser($token->getUser()));
        $authentication->setRefreshToken($token->getRefreshToken());
        $token->updateExpiresAt();

        $this->tokenRepository->save($token);

        return $authentication;
    }

    private function createJWTTokenFromUser(User $user): string
    {
        $expiresAt = new DateTime();
        $expiresAt->modify('+1 hour');

        $payload = $user->toArray();
        $payload[self::PROPERTY_EXPIRES_AT] = $expiresAt->getTimestamp();

        return $this->jwt->encode($payload);
    }

    public function getUserFromToken(string $token): User
    {
        try {
            $object = $this->jwt->decode(str_replace('Bearer ', '', $token));
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage(), ExceptionHelper::toLoggerContext($e));
            throw new InvalidJWTException();
        }

        $now = new DateTime();
        $expiresAt = (new DateTime())->setTimestamp($object->{self::PROPERTY_EXPIRES_AT});

        if ($now > $expiresAt) {
            throw new TokenExpiredException();
        }

        return $this->userRepository->find($object->id);
    }
}