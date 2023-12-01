<?php

namespace App\Events;

use App\Entity\Todo;
use Symfony\Contracts\EventDispatcher\Event;

class AddTodoEvent extends Event
{
    const ADD_TODO = "todo.add";

    public function __construct(private Todo $todo)
    {
    }

    public function getTodo(): Todo
    {
        return $this->todo;
    }
}