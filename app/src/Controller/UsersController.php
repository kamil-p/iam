<?php

namespace App\Controller;

use App\DTO\UserDTO;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;


class UsersController extends AbstractController
{
    /**
     * @Rest\Post("/users", name="post_users")
     * @ParamConverter("userDTO", converter="fos_rest.request_body")
     */
    public function register(UserDTO $userDTO)
    {
        return $this->json($userDTO);
    }
}