<?php

namespace App\Controller;

use App\Entity\Fred;
use App\Form\FredType;
use App\Repository\FredRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/fred')]
class FredController extends AbstractController
{
    #[Route('/', name: 'app_fred_index', methods: ['GET'])]
    public function index(FredRepository $fredRepository): Response
    {
        return $this->render('fred/index.html.twig', [
            'freds' => $fredRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_fred_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $fred = new Fred();
        $form = $this->createForm(FredType::class, $fred);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($fred);
            $entityManager->flush();

            return $this->redirectToRoute('app_fred_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('fred/new.html.twig', [
            'fred' => $fred,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_fred_show', methods: ['GET'])]
    public function show(Fred $fred): Response
    {
        return $this->render('fred/show.html.twig', [
            'fred' => $fred,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_fred_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Fred $fred, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FredType::class, $fred);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_fred_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('fred/edit.html.twig', [
            'fred' => $fred,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_fred_delete', methods: ['POST'])]
    public function delete(Request $request, Fred $fred, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fred->getId(), $request->request->get('_token'))) {
            $entityManager->remove($fred);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_fred_index', [], Response::HTTP_SEE_OTHER);
    }
}
