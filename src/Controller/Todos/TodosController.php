<?php

namespace App\Controller\Todos;

use App\Data\SearchData;
use App\Entity\Todo;
use App\Events\AddTodoEvent;
use App\Events\SendEmailEvent;
use App\Form\SearchType;
use App\Form\TodoType;
use App\Repository\TodoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodosController extends AbstractController
{
    public function __construct(private EventDispatcherInterface $dispacher)
    {
    }
    #[Route('/todos/all', name: 'app_todos_all')]
    public function index(TodoRepository $todoRepo, Request $request): Response
    {
        $data = new SearchData();
        $form = $this->createForm(SearchType::class, $data);
        $form->handleRequest($request);

        //dd($data);
        if ($data->q || $data->statut || $data->network) {
            $todos = $todoRepo->findSearch($data);
        } else {

            $todos =  $todoRepo->findAll($data);
        };

        return $this->render('todos/todos/index.html.twig', [
            'todos' => $todos,
            "form" => $form->createView(),
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

            //create and dispache event

            $addTodoEvent = new AddTodoEvent($todo);
            $this->dispacher->dispatch($addTodoEvent, AddTodoEvent::ADD_TODO);

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

            //create and dispache event

            $sendEmailEvent = new SendEmailEvent($todo);
            $this->dispacher->dispatch($sendEmailEvent, SendEmailEvent::SEND_EMAIL);

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