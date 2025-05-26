<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function indexKanban(): JsonResponse
    {
        $tasks = Task::whereHas('flow', function ($q) {
            $q->where('type', 'kanban');
        })->get();

        return response()->json($tasks);
    }

    public function updateKanban(Request $request, $id)
{
    $request->validate([
        'title' => 'sometimes|string|max:255',
        'description' => 'nullable|string',
        'priority' => 'nullable|in:alta,media,baixa',
        'due_date' => 'nullable|date',
        'repeat_interval' => 'nullable|in:none,daily,biweekly,monthly',
    ]);

    $task = Task::where('id', $id)->where('type', 'kanban')->firstOrFail();
    $task->update($request->all());

    return response()->json($task);
}

public function updateTodo(Request $request, $id)
{
    $request->validate([
        'title' => 'sometimes|string|max:255',
        'description' => 'nullable|string',
        'priority' => 'nullable|in:alta,media,baixa',
        'due_date' => 'nullable|date',
        'repeat_interval' => 'nullable|in:none,daily,biweekly,monthly',
    ]);

    $task = Task::where('id', $id)->where('type', 'todo')->firstOrFail();
    $task->update($request->all());

    return response()->json($task);
}


    public function indexTodo(): JsonResponse
    {
        $tasks = Task::whereHas('flow', function ($q) {
            $q->where('type', 'todo');
        })->get();

        return response()->json($tasks);
    }

    public function destroyTodo($id)
    {
        $task = Task::where('id', $id)->where('type', 'todo')->firstOrFail();
        $task->delete();

        return response()->json(['message' => 'Tarefa ToDo deletada.']);
    }

    public function destroyKanban($id)
    {
        $task = Task::where('id', $id)->where('type', 'kanban')->firstOrFail();
        $task->delete();

        return response()->json(['message' => 'Tarefa Kanban deletada.']);
    }
    public function storeTodo(Request $request)
{
    $request->validate([
        'flow_id' => 'required|exists:flows,id',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'priority' => 'nullable|string',
        'due_date' => 'nullable|date',
        'repeat_interval' => 'nullable|in:none,daily,biweekly,monthly',
    ]);

    $task = Task::create([
        'flow_id'         => $request->flow_id,
        'title'           => $request->title,
        'description'     => $request->description,
        'priority'        => $request->priority,
        'due_date'        => $request->due_date,
        'repeat_interval' => $request->repeat_interval ?? 'none',
        'type'            => 'todo',
    ]);

    return response()->json($task, 201);
    }
       public function storeKanban(Request $request)
    {
        $request->validate([
            'flow_id'         => 'required|exists:flows,id',
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string',
            'priority'        => 'nullable|string',
            'due_date'        => 'nullable|date',
            'repeat_interval' => 'nullable|in:none,daily,biweekly,monthly',
        ]);

        $task = Task::create([
            'flow_id'         => $request->flow_id,
            'title'           => $request->title,
            'description'     => $request->description,
            'priority'        => $request->priority,
            'due_date'        => $request->due_date,
            'type'            => 'kanban',
            'repeat_interval' => $request->repeat_interval ?? 'none',
        ]);

        return response()->json($task, 201);
    }
}
