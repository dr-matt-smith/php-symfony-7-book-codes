<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\HttpFoundation\Request;
use App\Util\Calculator;

class CalculatorController extends AbstractController
{
    #[Route('/calculator', name: 'app_calculator', methods: ['POST','GET'])]
    public function index(Request $request): Response
    {
        $isSubmitted = $request->isMethod('POST');

        // process submitted form data
        if($isSubmitted){
            $n1 = $request->request->get('num1');
            $n2 = $request->request->get('num2');
            $operator = $request->request->get('operator');

            // redirect to calculator processing route
            return $this->redirectToRoute('app_calculator_process', [
                'n1' => $n1,
                'n2' => $n2,
                'operator' => $operator
            ]);
        }

        // if we get here, it was a GET requerst, so just display form
        $template = 'calculator/index.html.twig';
        $args = [];
        return $this->render($template, $args);
    }

    #[Route('/calculator/process/{n1}/{n2}/{operator}', name: 'app_calculator_process')]
    public function process(int $n1, int $n2, string $operator): Response
    {
        // extract name values from POST data
        $calc = new Calculator();
        $answer = $calc->process($n1, $n2, $operator);
        $template = 'calculator/result.html.twig';
        $args =  [
            'n1' => $n1,
            'n2' => $n2,
            'operator' => $operator,
            'answer' => $answer
        ];
        return $this->render($template, $args);
    }


}
