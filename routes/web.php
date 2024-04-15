<?php

use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
  //  return view('myhome');
//})->middleware('auth');


//Route::get('/dashboard', function () {
   // return view('myhome');
//})->middleware('auth');

//Route::get('/{any?}', ApplicationController::class)->where('any','.*');






Route::get('/1/{any?}', function () {
  return view('myhome');
})->where('any', '.*')->middleware('auth');;



Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);