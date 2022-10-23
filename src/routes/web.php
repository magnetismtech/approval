<?php

use Illuminate\Support\Facades\Route;
use Magnetism\Approval\Http\ApprovalController;

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

Route::resource('/approvables', ApprovalController::class);
Route::post('/approved', [ApprovalController::class, 'approved']);
Route::get('/approvableSubjects', [ApprovalController::class, 'approvableSubjects']);
