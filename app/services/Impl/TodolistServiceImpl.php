<?php

namespace App\services\Impl;

use App\services\TodolistService;
use Illuminate\Support\Facades\Session;

class TodolistServiceImpl implements TodolistService
{
    public function saveTodo(string $id, string $todo): void
    {
        if (!Session::exists('todolist')) {
            Session::put('todolist', []);
        }

        Session::push('todolist', [
            "id" => $id,
            "todo" => $todo
        ]);
    }

    public function getTodolist(): array
    {
        return Session::get('todolist', []);
    }

    public function removeTodo(string $todoid)
    {
        $todolist = Session::get('todolist');

        foreach ($todolist as $key => $todo) {
            if ($todo['id'] == $todoid) {
                unset($todolist[$key]);
                break;
            }
        }

        Session::put('todolist', $todolist);
    }
}
