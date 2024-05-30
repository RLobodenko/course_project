<?php

namespace App\Controller;
use App\Entity\Comment;
use App\Entity\Item;
use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class CommentController extends AbstractController
{
    #[Route('/items/{id}/comments', name: 'app_comment')]
    public function index(Item $item): Response
    {

        
        return $this->render('comment/index.html.twig', [
            'comments' => $item->getComments(),
            'item' => $item
        ]);
    }
    
    #[Route('/item/{id}/comment/new', name: 'new_comment')]
    public function newComment(Request $request, Item $item, EntityManagerInterface $em): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $comment->setItem($item);
            $comment->setUser($this->getUser());
            $comment->setCreateAt(new \DateTime());
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('app_comment', ['id'=>$item->getId()]);
        }
        
        return $this->render('comment/new.html.twig', [
            'form' => $form,
            'item' => $item
        ]);
    }
}
