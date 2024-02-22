<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;


use App\Entity\Student;
use App\Repository\StudentRepository;

use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Form\StudentType;



class StudentController extends AbstractController
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }



    #[Route('/student/new', name: 'student_new_form', methods: ["POST", "GET"])]
    public function new(Request $request)
    {
        $student = new Student();

        $form = $this->createForm(StudentType::class, $student);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->create($student);
        }

        $template = 'student/new.html.twig';
        $argsArray = [
            'form' => $form->createView(),
        ];

        return $this->render($template, $argsArray);
    }




    public function create(Student $student): Response
    {
        $em = $this->doctrine->getManager();
        $em->persist($student);
        $em->flush();

        return $this->redirectToRoute('student_list');
    }

    #[Route('/student', name: 'student_list')]
    public function index(StudentRepository $studentRepository): Response
    {
        $students = $studentRepository->findAll();

        $template = 'student/index.html.twig';
        $args = [
            'students' => $students
        ];
        return $this->render($template, $args);
    }

    #[Route('/student/update/{id}/{newFirstName}/{newSurname}', name: 'student_update')]
    public function update(Student $student, string $newFirstName, string $newSurname, ManagerRegistry $doctrine)
    {
        $student->setFirstName($newFirstName);
        $student->setSurname($newSurname);

        $em = $doctrine->getManager();
        $em->flush();

        return $this->redirectToRoute('student_show', [
            'id' => $student->getId()
        ]);
    }

    #[Route('/student/{id}', name: 'student_show')]
    public function show(Student $student): Response
    {
        $template = 'student/show.html.twig';
        $args = [
            'student' => $student
        ];

        return $this->render($template, $args);
    }

    #[Route('/student/delete/{id}', name: 'student_delete')]
    public function delete(Student $student, ManagerRegistry $doctrine)
    {
        $id = $student->getId();

        // tells Doctrine you want to (eventually) delete the Student (no queries yet)
        $em = $doctrine->getManager();
        $em->remove($student);

        // actually executes the queries (i.e. the DELETE query)
        $em->flush();

        return new Response('Deleted student with id '.$id);
    }

}
