<?php

use App\Http\Controllers\dataController;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/Soal-2', function () {
    return view('RS_Soal2');
});

Route::get('/', [dataController::class, 'index'])->name('Soal-1');
// Route::get('/Soal-2', [dataController::class, 'index']);

