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
});

Route::fallback(function () {
    return response()->json(['message' => 'Rota não encontrada'], 404);
});
