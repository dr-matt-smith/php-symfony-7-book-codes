<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
//        return new Response('Hello there!');

        $template = 'default/index.html.twig';
        $args = [];
        return $this->render($template, $args);

    }
}
