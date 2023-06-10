<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoodController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [FoodController::class, 'CreateToken']);
// Route::get('/', [FoodController::class, 'CreateToken']);
// Route::get('/foods', [FoodController::class, 'index']);
// Route::post('/foods/store', [FoodController::class, 'store']);
// Route::get('/foods/{id}', [FoodController::class, 'show']);
// Route::patch('/foods/update/{id}', [FoodController::class, 'update']);
// Route::delete('/foods/delete/{id}', [FoodController::class, 'destroy']);







