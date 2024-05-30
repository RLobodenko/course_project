<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ItemRepository;
use App\Repository\CollectionnRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ItemRepository $it, CollectionnRepository $coll): Response
    {
        $items = $it->findBy([], ['id'=>'DESC'], 10);
        $collections = $coll->findLargestCollections(5);
       
        return $this->render('home/index.html.twig', [
            'items' => $items,
            'collections' => $collections
        ]);
    }
}
