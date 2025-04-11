<?php

use App\Http\Controllers\AttractionController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('attractions', [AttractionController::class, 'index'])->name('attractions.index');
Route::get('attractions/{attraction}', [AttractionController::class, 'show'])->name('attractions.show');
Route::post('attractions/review', [AttractionController::class, 'review'])->name('attractions.review');

Route::get('hotels', [HotelController::class, 'index'])->name('hotels.index');
Route::get('hotels/{hotel}', [HotelController::class, 'show'])->name('hotels.show');
Route::post('hotels/review', [HotelController::class, 'review'])->name('hotels.review');
