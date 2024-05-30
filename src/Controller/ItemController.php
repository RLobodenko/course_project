<?php

namespace App\Controller;
use App\Entity\Collectionn;
use App\Entity\Item;
use App\Form\ItemType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class ItemController extends AbstractController
{
    #[Route('/collection/{id}/items', name: 'item_index')]
    public function index(EntityManagerInterface $em, $id): Response
    {
        $collection = $em->getRepository(Collectionn::class)->find($id);
        $items = $em->getRepository(Item::class)->findBy(['collection'=>$collection]);
        
        return $this->render('item/index.html.twig', [
            'collection' => $collection,
            'items' => $items,
        ]);
    }
    
     #[Route('/collection/{id}/item/create', name: 'item_create')]
    public function create(Request $request, EntityManagerInterface $em, $id): Response
    {
        $item = new Item();
        $collection = $em->getRepository(Collectionn::class)->find($id);
        $item->setCollection($collection);
        
        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($item);
            $em->flush();
            return $this->redirectToRoute('item_index', ['id' => $id]);
        }
        
        return $this->render('item/create.html.twig', [
            'form' => $form->createView(),
            'collection' => $collection
        ]);
    }
    
     #[Route('/collection/{idcollection}/item/{id}/delete', name: 'item_delte')]
    public function delete(Request $request, EntityManagerInterface $em, Item $item, $idcollection): Response
    {
       
       
        $em->remove($item);
        $em->flush();
        return $this->redirectToRoute('item_index', ['id' => $idcollection]);
    }
    #[Route('/collection/{id_col}/item/{id}/edit', name: 'item_edit')]
     public function edit(Request $request, EntityManagerInterface $entityManager, Item $item, $id_col): Response
    {
        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('item_index', ['id' => $id_col]);
        }

        return $this->render('item/edit.html.twig', [
            'item' => $item,
            'form' => $form,
        ]);
    }
    
}
