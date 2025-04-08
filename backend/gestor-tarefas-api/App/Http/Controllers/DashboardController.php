<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            'kanban_workspaces' => route('workspace.kanban.index'),
            'todo_workspaces' => route('workspace.todo.index')
        ]);
    }
}
