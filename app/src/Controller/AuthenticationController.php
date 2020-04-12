<?php

namespace App\Controller;

use App\Resources\Authentication;
use App\Service\TokenService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @ParamConverter("authentication", converter="fos_rest.request_body")
     */
    public function authenticate(Authentication $authentication)
    {
        $this->tokenService->createTokens($authentication);
        return $this->json($authentication, Response::HTTP_OK, [], ['groups' => 'read']);
    }
}