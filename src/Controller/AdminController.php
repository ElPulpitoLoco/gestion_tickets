<?php

namespace App\Controller; //chemin du fichier

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_dashboard')]
class AdminController extends AbstractController
{
    public function dashboard(): Response //le dashboard de admin 
    {
        return $this->render('admin/dashboard.html.twig'); //le rendu de la vue
    }
}
