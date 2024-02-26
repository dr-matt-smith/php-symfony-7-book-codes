<?php

namespace App\Controller;

use App\Entity\Lecturer;
use App\Form\LecturerType;
use App\Repository\LecturerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/lecturer')]
class LecturerController extends AbstractController
{
    #[Route('/', name: 'app_lecturer_index', methods: ['GET'])]
    public function index(LecturerRepository $lecturerRepository): Response
    {
        return $this->render('lecturer/index.html.twig', [
            'lecturers' => $lecturerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_lecturer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $lecturer = new Lecturer();
        $form = $this->createForm(LecturerType::class, $lecturer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($lecturer);
            $entityManager->flush();

            return $this->redirectToRoute('app_lecturer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('lecturer/new.html.twig', [
            'lecturer' => $lecturer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_lecturer_show', methods: ['GET'])]
    public function show(Lecturer $lecturer): Response
    {
        return $this->render('lecturer/show.html.twig', [
            'lecturer' => $lecturer,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_lecturer_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Lecturer $lecturer, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LecturerType::class, $lecturer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_lecturer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('lecturer/edit.html.twig', [
            'lecturer' => $lecturer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_lecturer_delete', methods: ['POST'])]
    public function delete(Request $request, Lecturer $lecturer, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lecturer->getId(), $request->request->get('_token'))) {
            $entityManager->remove($lecturer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_lecturer_index', [], Response::HTTP_SEE_OTHER);
    }
}
