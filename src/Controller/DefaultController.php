<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function admin(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    #[Route('/frontend', name: 'frontend')]
    public function frontend(): Response
    {
        return $this->render('frontend/index.html.twig');
    }
}
