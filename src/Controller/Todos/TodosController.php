<?php

namespace App\Controller\Todos;

use App\Entity\Todo;
use App\Form\TodoType;
use App\Repository\TodoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodosController extends AbstractController
{
    #[Route('/todos/all', name: 'app_todos_all')]
    public function index(TodoRepository $todoRepo): Response
    {
        $todos =  $todoRepo->findAll();
        return $this->render('todos/todos/index.html.twig', [
            'todos' => $todos,
        ]);
    }

    #[Route('/todos/add', name: 'app_todos_add')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $todo = new Todo();
        $form = $this->createForm(
            TodoType::class,
            $todo,
            ['action' => $this->generateUrl('app_todos_add')]
        );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($todo);
            $em->flush();
            return $this->redirectToRoute("app_todos_all");
        }
        return $this->render('todos/todos/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/todos/{id<\d+>}/edit', name: 'app_todos_edit')]
    public function edit(Request $request, EntityManagerInterface $em, Todo $todo): Response
    {
        $form = $this->createForm(
            TodoType::class,
            $todo,
            ['action' => $this->generateUrl(
                'app_todos_edit',
                ["id" => $todo->getId()]
            )]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute("app_todos_all");
        }
        return $this->render('todos/todos/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/todos/{id<\d+>}/delete', name: 'app_todos_delete')]
    public function delete(Todo $todo, EntityManagerInterface $em): Response
    {
        $em->remove($todo);
        $em->flush();
        return $this->redirectToRoute("app_todos_all");
    }
}
