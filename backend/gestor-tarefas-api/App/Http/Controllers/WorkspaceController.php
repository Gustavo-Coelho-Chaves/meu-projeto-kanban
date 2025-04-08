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
        ]);

        $workspace = Workspace::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'type' => 'kanban',
        ]);

        return response()->json($workspace, 201);
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
