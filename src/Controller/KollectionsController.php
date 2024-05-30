<?php

namespace App\Controller;

use App\Entity\Kollections;
use App\Form\KollectionsType;
use App\Repository\KollectionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/kollections')]
class KollectionsController extends AbstractController
{
    #[Route('/', name: 'app_kollections_index', methods: ['GET'])]
    public function index(KollectionsRepository $kollectionsRepository): Response
    {
        return $this->render('kollections/index.html.twig', [
            'kollections' => $kollectionsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_kollections_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $kollection = new Kollections();
        $form = $this->createForm(KollectionsType::class, $kollection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($kollection);
            $entityManager->flush();

            return $this->redirectToRoute('app_kollections_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('kollections/new.html.twig', [
            'kollection' => $kollection,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_kollections_show', methods: ['GET'])]
    public function show(Kollections $kollection): Response
    {
        return $this->render('kollections/show.html.twig', [
            'kollection' => $kollection,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_kollections_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Kollections $kollection, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(KollectionsType::class, $kollection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_kollections_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('kollections/edit.html.twig', [
            'kollection' => $kollection,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_kollections_delete', methods: ['POST'])]
    public function delete(Request $request, Kollections $kollection, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$kollection->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($kollection);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_kollections_index', [], Response::HTTP_SEE_OTHER);
    }
}
