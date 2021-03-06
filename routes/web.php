<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('app');
});



Route::get('/api',  [PostController::class, 'showData']);
Route::get('/api/delete/{id}',  [PostController::class, 'deleteData']);
Route::post('/api/posts',  [PostController::class, 'addData']);
Route::post('/api/edit',  [PostController::class, 'editData']);

