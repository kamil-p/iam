<?php

namespace App\Resources;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

class Authentication
{
    private const SCHEMA_AUTHENTICATION = 'Authentication';
    private const SCHEMA_IDENTITY = 'Identity';
    private const SCHEMA_REFRESH_TOKEN = 'RefreshToken';

    /**
     * @Assert\Email(groups={"authentication"})
     * @Assert\NotBlank(groups={"authentication"})
     * @var string
     */
    private string $email;

    /**
     * @Assert\NotBlank(groups={"authentication"})
     * @var string
     */
    private string $password;

    /**
     * @Groups("read")
     */
    private string $token = 'token';

    /**
     * @Assert\NotBlank(groups={"refresh_token"})
     * @Groups("read")
     * @SerializedName("refresh_token")
     */
    private string $refreshToken = 'refreshToken';

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    public function setRefreshToken(string $refreshToken): void
    {
        $this->refreshToken = $refreshToken;
    }

    public static function getSwaggerSchemas(): array
    {
        return [
            self::SCHEMA_AUTHENTICATION => [
                'type' => 'object',
                'properties' => [
                    'email' => [
                        'type' => 'string',
                        'example' => 'test@test.com',
                    ],
                    'password' => [
                        'type' => 'string',
                        'example' => 'password1234',
                    ],
                ]
            ],
            self::SCHEMA_IDENTITY => [
                'type' => 'object',
                'properties' => [
                    'token' => [
                        'type' => 'string',
                        'readOnly' => true,
                    ],
                    'refresh_token' => [
                        'type' => 'string',
                        'readOnly' => true,
                    ],
                ],
            ],
            self::SCHEMA_REFRESH_TOKEN => [
                'type' => 'object',
                'properties' => [
                    'refresh_token' => [
                        'type' => 'string',
                        'example' => 'b7c19d63674fe362dea840e784b661ce8b42169e285ea1530bd477c783bd0f57ef8fc84efcbde0bddd082b87c95a04475be7',
                    ],
                ]
            ],
        ];
    }

    public static function getSwaggerPath(): array
    {
        return [
            '/api/authentication' => [
                'post' => [
                    'tags' => [self::SCHEMA_AUTHENTICATION],
                    'operationId' => 'postAuthenticationItem',
                    'summary' => 'Get JWT token to login.',
                    'requestBody' => [
                        'description' => 'Create new JWT Token',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    '$ref' => '#/components/schemas/'.self::SCHEMA_AUTHENTICATION,
                                ],
                            ],
                        ],
                    ],
                    'responses' => [
                        Response::HTTP_OK => [
                            'description' => 'Get JWT token',
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        '$ref' => '#/components/schemas/'.self::SCHEMA_IDENTITY,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            '/api/refresh_token' => [
                'post' => [
                    'tags' => [Authentication::SCHEMA_AUTHENTICATION],
                    'operationId' => 'postRefreshToken',
                    'summary' => 'Refresh JWT token.',
                    'requestBody' => [
                        'description' => 'Refresh JWT Token',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    '$ref' => '#/components/schemas/'.self::SCHEMA_REFRESH_TOKEN,
                                ],
                            ],
                        ],
                    ],
                    'responses' => [
                        Response::HTTP_OK => [
                            'description' => 'Get JWT token',
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        '$ref' => '#/components/schemas/'.Authentication::SCHEMA_IDENTITY,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}