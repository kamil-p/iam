<?php

namespace App\Controller;

use App\Resources\Authentication;
use App\Service\TokenService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @Route("/api")
 */
class AuthenticationController extends AbstractController
{
    private TokenService $tokenService;

    public function __construct(TokenService $jwtService)
    {
        $this->tokenService = $jwtService;
    }

    /**
     * @Rest\Post("/authentication", name="api_post_authentication")
     * @ParamConverter("authentication", converter="fos_rest.request_body", options={"validator"={"groups"={"authentication"}}})
     */
    public function authenticate(Authentication $authentication, ConstraintViolationListInterface $validationErrors)
    {
        if ($validationErrors->count() > 0) {
            return $this->json($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        return $this->json(
            $this->tokenService->createTokens($authentication),
            Response::HTTP_OK,
            [],
            ['groups' => 'read']
        );
    }

    /**
     * @Rest\Post("/refresh_token", name="api_post_refresh_token")
     * @ParamConverter("authentication", converter="fos_rest.request_body", options={"validator"={"groups"={"refresh_token"}}})
     */
    public function refreshToken(Authentication $authentication, ConstraintViolationListInterface $validationErrors)
    {
        if ($validationErrors->count() > 0) {
            return $this->json($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        return $this->json(
            $this->tokenService->refreshToken($authentication),
            Response::HTTP_OK,
            [],
            ['groups' => 'read']
        );
    }
}