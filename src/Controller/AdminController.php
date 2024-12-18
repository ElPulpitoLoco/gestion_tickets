<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_dashboard')]
class AdminController extends AbstractController
{
    public function dashboard(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }
}
