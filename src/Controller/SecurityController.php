<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        //obtenir l'erreur de connexion si il y a
        $error = $authenticationUtils->getLastAuthenticationError();
        
        //obtenir le dernier username ou mail saisi
        $lastEmail = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_email' => $lastEmail,
            'error'      => $error,
        ]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout()
    {
        // Symfony deco auto
    }
}
