<?php

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ProjectTasksController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/projects', [ProjectsController::class, 'getProject'])->name('user-get-project');
    Route::get('/project/create', [ProjectsController::class, 'createProject'])->name('user-create-project');
    Route::get('/projects/{project}', [ProjectsController::class, 'viewOneProject'])->name('user-view-one-project');
    Route::post('/', [ProjectsController::class, 'saveProject'])->name('user-project');
    Route::post('/projects/{project}/tasks', [ProjectTasksController::class, 'addProjectTask'])->name('user-add-project-task');
    Route::put('/projects/{project}/tasks/{task}', [ProjectTasksController::class, 'updateProjectTask'])->name('user-update-project-task');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

Auth::routes();
