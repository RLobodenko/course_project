<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    #[Route('/admin/users', name: 'app_admin_users')]
    public function listUsers(Request $request,EntityManagerInterface $em)
    {
        $users = $em->getRepository(User::class)->findAll();
        return $this->render('admin/index.html.twig', [
            'users' => $users,
        ]);
    }
    //admin/block/7/block
     #[Route('/admin/user/{id}/block', name: 'app_user_block')]
    public function blockUser(Request $request,EntityManagerInterface $em, User $user)
    {
        $user->setIsBlocked(true);
        $em->flush();
        return $this->redirectToRoute('app_admin_users');
    }
    
}
