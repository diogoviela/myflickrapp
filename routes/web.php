<?php

use App\Http\Controllers\PhotoController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [PhotoController::class, 'index'])->name('flickr.index');
Route::get('/images', [PhotoController::class, 'getImagesWithSizes'])->name('images');
Route::post('/save-images', [PhotoController::class, 'saveImages'])->name('save-images');
