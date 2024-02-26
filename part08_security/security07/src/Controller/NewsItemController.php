<?php

namespace App\Controller;

use App\Entity\NewsItem;
use App\Form\NewsItemType;
use App\Repository\NewsItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[Route('/news/item')]
class NewsItemController extends AbstractController
{
    #[Route('/', name: 'app_news_item_index', methods: ['GET'])]
    public function index(NewsItemRepository $newsItemRepository): Response
    {
        return $this->render('news_item/index.html.twig', [
            'news_items' => $newsItemRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_news_item_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        $newsItem = new NewsItem();
        $newsItem->setAuthor($user);

        $form = $this->createForm(NewsItemType::class, $newsItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($newsItem);
            $entityManager->flush();

            return $this->redirectToRoute('app_news_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('news_item/new.html.twig', [
            'news_item' => $newsItem,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_news_item_show', methods: ['GET'])]
    public function show(NewsItem $newsItem): Response
    {
        return $this->render('news_item/show.html.twig', [
            'news_item' => $newsItem,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_news_item_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, NewsItem $newsItem, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NewsItemType::class, $newsItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_news_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('news_item/edit.html.twig', [
            'news_item' => $newsItem,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_news_item_delete', methods: ['POST'])]
    public function delete(Request $request, NewsItem $newsItem, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$newsItem->getId(), $request->request->get('_token'))) {
            $entityManager->remove($newsItem);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_news_item_index', [], Response::HTTP_SEE_OTHER);
    }
}
