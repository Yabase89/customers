<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

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

Route::get('/',[CustomerController::class,'index']);
Route::post('/sign-in',[CustomerController::class,'signin']);
Route::get('/dashboard',[CustomerController::class,'dashboard']);
Route::get('/add-customer',[CustomerController::class,'customerform']);
Route::get('/get-types',[CustomerController::class,'getaddresstypes']);
Route::post('/customer-save',[CustomerController::class,'customersave']);
Route::get('/add-customer/{id}',[CustomerController::class,'editcustomer']);
Route::post('/customer-update',[CustomerController::class,'customerupdate']);
Route::get('/delete-customer/{id}',[CustomerController::class,'customerdelete']);
Route::get('/logout',[CustomerController::class,'logout']);

