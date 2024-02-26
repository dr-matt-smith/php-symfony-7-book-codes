<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_default')]
    public function index(): Response
    {
        $template = 'default/index.html.twig';
        $args = [];
        return $this->render($template, $args);
    }

    #[Route('/about', name: 'app_default_about')]
    public function about(): Response
    {
        $template = 'default/about.html.twig';
        $args = [];
        return $this->render($template, $args);
    }
}
