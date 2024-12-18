<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface //redir apres autentification
{
    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): RedirectResponse
    {
        $user = $token->getUser(); //recup le user, admin ou staff ou visiteur

        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            return new RedirectResponse($this->router->generate('admin_dashboard')); //redirige vers dashboard admin
        }

         if (in_array('ROLE_STAFF', $user->getRoles())) {
        return new RedirectResponse($this->router->generate('staff_dashboard')); //redirige vers staff dashboard
    }

    //en cas de user sans role redirige vers une page generale
    return new RedirectResponse($this->router->generate('categorie_index'));
    }
}
