<?php

namespace App\Controller\Todos;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/todos/home', name: 'app_todos_home')]
    public function index(): Response
    {
        return $this->render('todos/home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
