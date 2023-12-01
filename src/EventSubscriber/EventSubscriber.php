<?php

namespace App\EventSubscriber;

use App\Events\AddTodoEvent;
use App\Events\SendEmailEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class EventSubscriber implements EventSubscriberInterface
{
    public function __construct()
    {
    }

    public function onKernelController(RequestEvent $event): void
    {
    }

    public function addTodo(AddTodoEvent $event)
    {
        $event->getTodo();
    }

    public function sendEmail(SendEmailEvent $event)
    {
        $event->sendEmail();
    }

    public static function getSubscribedEvents(): array
    {
        return [
            //KernelEvents::REQUEST => 'onKernelController',
            AddTodoEvent::ADD_TODO => 'addTodo',
            SendEmailEvent::SEND_EMAIL => 'sendEmail',
        ];
    }
}
