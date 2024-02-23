<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\Student;
use App\Repository\StudentRepository;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'student_list')]
    public function index(): Response
    {
        $studentRepository = new StudentRepository();
        $students = $studentRepository->findAll();

        $template = 'student/index.html.twig';
        $args = [
            'students' => $students
        ];
        return $this->render($template, $args);
    }

    #[Route('/student/{id}', name: 'student_show')]
    public function show(int $id): Response
    {
        $studentRepository = new StudentRepository();
        $student = $studentRepository->find($id);

        // we are assuming $student is not NULL....
        $template = 'student/show.html.twig';
        $args = [
            'student' => $student
        ];

        if (!$student) {
                $template = 'error/404.html.twig';

//            throw $this->createNotFoundException(
//                'No product found for id '.$id
//            );
        }


        return $this->render($template, $args);
    }
}
