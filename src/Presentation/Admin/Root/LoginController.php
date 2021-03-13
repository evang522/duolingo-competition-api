<?php

declare(strict_types=1);

namespace App\Presentation\Admin\Root;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    public function loginAction(AuthenticationUtils $authUtils): Response
    {
        $data = [
            'csrf_token_intention' => 'authenticate_admin',
            'last_username' => $authUtils->getLastUsername(),
            'error' => $authUtils->getLastAuthenticationError(),
        ];

        return $this->render('@EasyAdmin/page/login.html.twig', $data);
    }
}
