<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResellerController;

Route::get('/', function () {
    return view('pages.home');
});

Route::get('/about-us', function () {
    return view('pages.about-us');
});

Route::get('/beauty-community', function () {
    return view('pages.beauty-community');
});

Route::get('/loyalty', function () {
    return view('pages.loyalty');
});

Route::get('/term-of-service', function () {
    return view('pages.term-of-service');
});

Route::get('/privacy-policy', function () {
    return view('pages.privacy-policy');
});

Route::get('/reseller-cell-a', function () {
    return view('pages.reseller');
});

Route::get('/reseller-cell-a', [ResellerController::class, 'index'])->name('reseller');
