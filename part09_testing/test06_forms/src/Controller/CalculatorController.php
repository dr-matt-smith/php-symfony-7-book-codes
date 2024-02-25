<?php

namespace App\Controller;

use Psr\Log\LogLevel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Psr\Log\LoggerInterface;

use Symfony\Component\HttpFoundation\Request;
use App\Util\Calculator;

class CalculatorController extends AbstractController
{
    #[Route('/calculator', name: 'app_calculator', methods: ['POST','GET'])]
    public function index(): Response
    {
        $template = 'calculator/index.html.twig';
        $args = [];
        return $this->render($template, $args);
    }

    #[Route('/calculator/result', name: 'app_calculator_result')]
    public function process(Request $request, LoggerInterface $logger): Response
    {
        // default is GET - show form
        $template = 'calculator/index.html.twig';
        $args = [];

        $isSubmitted = $request->isMethod('POST');

        // process submitted form data
        if($isSubmitted){
            $n1 = $request->request->get('num1');
            $n2 = $request->request->get('num2');
            $operator = $request->request->get('operator');

            $calc = new Calculator();
            $answer = $calc->process($n1, $n2, $operator);

            $template = 'calculator/result.html.twig';
            $args =  [
                'n1' => $n1,
                'n2' => $n2,
                'operator' => $operator,
                'answer' => $answer
            ];
        }

        return $this->render($template, $args);
    }


}
