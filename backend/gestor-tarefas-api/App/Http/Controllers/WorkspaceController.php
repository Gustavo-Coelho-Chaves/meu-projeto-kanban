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


    public function storeKanban(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'due_date' => 'nullable|date',
        'category' => 'nullable|string|max:100',
    ]);

    $workspace = Workspace::create([
        'user_id' => auth()->id(),
        'name' => $request->name,
        'type' => 'kanban',
        'due_date' => $request->due_date,
        'category' => $request->category,
        'priority' => $request->priority,
    ]);

    return response()->json($workspace, 201);
}


public function destroyTodo($id)
{
    $workspace = Workspace::where('id', $id)->where('type', 'todo')->firstOrFail();
    $workspace->delete();

    return response()->json(['message' => 'Workspace ToDo deletado.']);
}

public function destroyKanban($id)
{
    $workspace = Workspace::where('id', $id)->where('type', 'kanban')->firstOrFail();
    $workspace->delete();

    return response()->json(['message' => 'Workspace Kanban deletado.']);
}


    public function indexTodo()
    {
        return Workspace::where('type', 'todo')->get();
    }

    public function storeTodo(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = auth()->user();

        if (!$user) {
            \Log::error('Usuário não autenticado.');
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $workspace = Workspace::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'type' => 'todo',
        ]);

        return response()->json($workspace, 201);
    }

}
