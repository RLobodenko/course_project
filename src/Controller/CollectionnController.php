<?php

namespace App\Controller;

use App\Entity\Collectionn;
use App\Form\CollectionnType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class CollectionnController extends AbstractController
{
    #[Route('/collectionns', name: 'collection_index')]
    public function index(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $collections = $em->getRepository(Collectionn::class)->findBy(['user'=>$user]);
        return $this->render('collectionn/index.html.twig', [
            'collections' => $collections,
        ]);
    }
    
    #[Route('/collection/new', name: 'collection_new')]
    public function create(Request $request, EntityManagerInterface $em)
    {
        $collection = new Collectionn();
        $form = $this->createForm(CollectionnType::class, $collection);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $collection->setUser($this->getUser());
            $em->persist($collection);
            $em->flush();
            
            return $this->redirectToRoute('collection_index');
        }
        return $this->render('collectionn/create.html.twig', [
            'form' => $form,
        ]);
    }
    
    
}
