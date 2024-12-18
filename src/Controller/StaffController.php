<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/staff', name: 'staff_dashboard')]
class StaffController extends AbstractController
{
    public function dashboard(): Response
    {
        return $this->render('staff/dashboard.html.twig');
    }
}
