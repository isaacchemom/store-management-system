<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\applicationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/addsupplier', [applicationController::class, 'addsupplier']);
Route::get('/getsuppliers', [applicationController::class, 'getsuppliers']);


Route::post('/addItem', [applicationController::class, 'addItem']);
Route::get('/getItems', [applicationController::class, 'getItems']);
Route::patch('/updateItems/{id}', [applicationController::class, 'updateItems']);
Route::post('/deleteItem/{id}', [applicationController::class, 'deleteItems']);


Route::post('/addCategory', [applicationController::class, 'addCategory']);
Route::get('/getCategories', [applicationController::class, 'getCategories']);
Route::patch('/updateCategory/{id}', [applicationController::class, 'updateCategory']);
Route::post('/deleteCategory/{id}', [applicationController::class, 'deleteCategory']);