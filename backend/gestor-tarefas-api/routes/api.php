<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WorkspaceController;
use App\Http\Controllers\FlowController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Aqui ficam as rotas da sua API RESTful
*/

// 🔐 Autenticação
Route::post('/auth/request-code', [AuthController::class, 'requestCode']);
Route::post('/auth/verify-code', [AuthController::class, 'verifyCode']);

Route::get('/perfil', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/workspace-kanban', [WorkspaceController::class, 'storeKanban']);
    Route::get('/workspace-kanban', [WorkspaceController::class, 'indexKanban'])->name('workspace.kanban.index');
    Route::get('/workspace-todo', [WorkspaceController::class, 'indexTodo'])->name('workspace.todo.index');
    Route::post('/workspace-todo', [WorkspaceController::class, 'storeTodo']);
    Route::get('/tasks-todo', [TaskController::class, 'indexTodo']);
    Route::post('/tasks-todo', [TaskController::class, 'storeTodo']);
    Route::post('/flow-todo', [FlowController::class, 'storeTodo']);
    Route::post('/flow-kanban', [FlowController::class, 'storeKanban']);
    Route::post('/tasks-kanban', [TaskController::class, 'storeKanban']);
    Route::get('/flow-kanban', [FlowController::class, 'indexKanban']);
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/flow-todo', [FlowController::class, 'indexTodo']);
    Route::get('/tasks-kanban', [TaskController::class, 'indexKanban']);
    Route::delete('/workspace-todo/{id}', [WorkspaceController::class, 'destroyTodo']);
    Route::delete('/workspace-kanban/{id}', [WorkspaceController::class, 'destroyKanban']);
    Route::delete('/flow-todo/{id}', [FlowController::class, 'destroyTodo']);
    Route::delete('/flow-kanban/{id}', [FlowController::class, 'destroyKanban']);
    Route::delete('/tasks-todo/{id}', [TaskController::class, 'destroyTodo']);
    Route::delete('/tasks-kanban/{id}', [TaskController::class, 'destroyKanban']);
    Route::put('/tasks-todo/{id}', [TaskController::class, 'updateTodo']);
    Route::patch('/tasks-todo/{id}', [TaskController::class, 'updateTodo']);
    Route::put('/tasks-kanban/{id}', [TaskController::class, 'updateKanban']);
    Route::patch('/tasks-kanban/{id}', [TaskController::class, 'updateKanban']);
    Route::patch('/flow-todo/{id}', [FlowController::class, 'updateTodo']);
    Route::patch('/flow-kanban/{id}', [FlowController::class, 'updateKanban']);
    Route::put('/workspace-todo/{id}', [WorkspaceController::class, 'updateTodo']);
    Route::patch('/workspace-todo/{id}', [WorkspaceController::class, 'updateTodo']);
    Route::put('/workspace-kanban/{id}', [WorkspaceController::class, 'updateKanban']);
    Route::patch('/workspace-kanban/{id}', [WorkspaceController::class, 'updateKanban']);

});

Route::fallback(function () {
    return response()->json(['message' => 'Rota não encontrada'], 404);
});
