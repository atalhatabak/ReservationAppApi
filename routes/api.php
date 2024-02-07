<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;

use App\Models\User;

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

Route::post('/login', [AuthController::class, 'loginUser'])->name("login");
Route::post('/register', [AuthController::class, 'createUser']);

Route::middleware('auth:sanctum')->group(function () {
    // User Controllers
    Route::get('/getBranchs', [UserController::class, 'getBranchs']);
    Route::get('/getAvaibleDates', [UserController::class, 'getAvaibleDates']);
    Route::get('/getCars', [UserController::class, 'getCars']);
    Route::get('/getReservations', [UserController::class, 'getReservations']);

    Route::post('/addCar', [UserController::class, 'addCar']);
    Route::post('/addReservation', [UserController::class, 'addReservation']);
    Route::delete('/deleteReservation', [UserController::class, 'deleteReservation']);

    Route::get('/getPersonalInfo', [UserController::class, 'getPersonalInfo']);
    Route::put('/updatePersonalInfo', [UserController::class, 'updatePersonalInfo']);
}); 

