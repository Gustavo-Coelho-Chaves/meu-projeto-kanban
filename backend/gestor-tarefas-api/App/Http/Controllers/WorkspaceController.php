<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Workspace;

class WorkspaceController extends Controller
{
    public function indexKanban()
    {
        return Workspace::where('type', 'kanban')
            ->where('user_id', auth()->id())
            ->get();
    }

    public function indexTodo()
    {
        return Workspace::where('type', 'todo')
            ->where('user_id', auth()->id())
            ->get();
    }

    public function storeKanban(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'due_date' => 'nullable|date',
            'category' => 'nullable|string|max:100',
            'priority' => 'nullable|string|max:20',
        ]);

        $workspace = Workspace::create([
            'user_id'   => auth()->id(),
            'name'      => $request->name,
            'type'      => 'kanban',
            'due_date'  => $request->due_date,
            'category'  => $request->category,
            'priority'  => $request->priority,
        ]);

        return response()->json($workspace, 201);
    }

    public function storeTodo(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'due_date' => 'nullable|date',
            'category' => 'nullable|string|max:100',
            'priority' => 'nullable|string|max:20',
        ]);

        $workspace = Workspace::create([
            'user_id'   => auth()->id(),
            'name'      => $request->name,
            'type'      => 'todo',
            'due_date'  => $request->due_date,
            'category'  => $request->category,
            'priority'  => $request->priority,
        ]);

        return response()->json($workspace, 201);
    }

    public function updateKanban(Request $request, $id)
    {
        $workspace = Workspace::where('id', $id)
            ->where('type', 'kanban')
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'due_date' => 'nullable|date',
            'category' => 'nullable|string|max:100',
            'priority' => 'nullable|string|max:20',
        ]);

        $workspace->update($request->only('name', 'due_date', 'category', 'priority'));

        return response()->json($workspace);
    }

    public function updateTodo(Request $request, $id)
    {
        $workspace = Workspace::where('id', $id)
            ->where('type', 'todo')
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'due_date' => 'nullable|date',
            'category' => 'nullable|string|max:100',
            'priority' => 'nullable|string|max:20',
        ]);

        $workspace->update($request->only('name', 'due_date', 'category', 'priority'));

        return response()->json($workspace);
    }

    public function destroyKanban($id)
    {
        $workspace = Workspace::where('id', $id)
            ->where('type', 'kanban')
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $workspace->delete();

        return response()->json(['message' => 'Workspace Kanban deletado.']);
    }

    public function destroyTodo($id)
    {
        $workspace = Workspace::where('id', $id)
            ->where('type', 'todo')
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $workspace->delete();

        return response()->json(['message' => 'Workspace ToDo deletado.']);
    }
}
