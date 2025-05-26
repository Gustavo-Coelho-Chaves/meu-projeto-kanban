<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flow;

class FlowController extends Controller
{
    public function indexKanban()
    {
        return Flow::where('type', 'kanban')->get();
    }

    public function storeKanban(Request $request)
{
    $request->validate([
        'workspace_id' => 'required|exists:workspaces,id',
        'title' => 'required|string'
    ]);

    return Flow::create([
        'workspace_id' => $request->workspace_id,
        'title' => $request->title,
        'type' => 'kanban'
    ]);
}

public function destroyTodo($id)
{
    $flow = Flow::where('id', $id)->where('type', 'todo')->firstOrFail();
    $flow->delete();

    return response()->json(['message' => 'Flow ToDo deletado.']);
}

public function destroyKanban($id)
{
    $flow = Flow::where('id', $id)->where('type', 'kanban')->firstOrFail();
    $flow->delete();

    return response()->json(['message' => 'Flow Kanban deletado.']);
}

    public function indexTodo()
    {
        return Flow::where('type', 'todo')->get();
    }

    public function storeTodo(Request $request)
    {
        $request->validate([
            'workspace_id' => 'required|exists:workspaces,id',
            'title' => 'required|string'
        ]);

        $flow = Flow::create([
            'workspace_id' => $request->workspace_id,
            'title' => $request->title,
            'type' => 'todo'
        ]);

        return response()->json($flow, 201); // <-- Resposta JSON correta
    }
    public function updateTodo(Request $request, $id)
{
    $flow = Flow::where('id', $id)->where('type', 'todo')->firstOrFail();

    $request->validate([
        'title' => 'sometimes|string|max:255',
    ]);

    $flow->update($request->only('title'));

    return response()->json($flow);
}

public function updateKanban(Request $request, $id)
{
    $flow = Flow::where('id', $id)->where('type', 'kanban')->firstOrFail();

    $request->validate([
        'title' => 'sometimes|string|max:255',
    ]);

    $flow->update($request->only('title'));

    return response()->json($flow);
}


}
