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
Route::patch('/editSupplier/{id}', [applicationController::class, 'editSupplier']);
Route::post('/deleteSupplier/{id}', [applicationController::class, 'deleteSupplier']);


Route::post('/addItem', [applicationController::class, 'addItem']);
Route::post('/addUnits', [applicationController::class, 'addUnits']);
Route::get('/getItems', [applicationController::class, 'getItems']);
Route::get('/getUnits', [applicationController::class, 'getUnits']);
Route::post('/deleteUnits/{id}', [applicationController::class, 'deleteUnits']);
Route::patch('/updateItems/{id}', [applicationController::class, 'updateItems']);
Route::patch('/updateUnits/{id}', [applicationController::class, 'updateUnits']);
Route::post('/deleteItem/{id}', [applicationController::class, 'deleteItems']);
Route::get('/getDailyItems', [applicationController::class, 'getDailyItems']);


Route::post('/addCategory', [applicationController::class, 'addCategory']);
Route::get('/getCategories', [applicationController::class, 'getCategories']);
Route::patch('/updateCategory/{id}', [applicationController::class, 'updateCategory']);
Route::post('/deleteCategory/{id}', [applicationController::class, 'deleteCategory']);

Route::post('/addDepartment', [applicationController::class, 'addDepartment']);
Route::get('/getDepartments', [applicationController::class, 'getDepartments']);
Route::patch('/updateDepartment/{id}', [applicationController::class, 'updateDepartment']);
Route::post('/deleteDepartment/{id}', [applicationController::class, 'deleteDepartment']);

Route::post('/addStaff', [applicationController::class, 'addStaff']);
Route::get('/getStaff', [applicationController::class, 'getStaff']);
Route::patch('/editStaff/{id}', [applicationController::class, 'editStaff']);
Route::post('/deleteStaff/{id}', [applicationController::class, 'deleteStaff']);

Route::get('/issuedItem', [applicationController::class, 'issuedItem']);
Route::post('/issueItems', [applicationController::class, 'issueItems']);
Route::patch('/updateIssuedItems/{id}', [applicationController::class, 'updateIssuedItems']);
Route::post('/deleteIssueItem/{id}', [applicationController::class, 'deleteIssueItem']);