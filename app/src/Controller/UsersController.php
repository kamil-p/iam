<?php

namespace App\Controller;

use App\Model\User as UserModel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;


class UsersController extends AbstractController
{
    /**
     * @Rest\Post("/users", name="post_users")
     * @ParamConverter("userModel", converter="fos_rest.request_body")
     */
    public function register(UserModel $userModel)
    {
        return $this->json($userModel);
    }
}