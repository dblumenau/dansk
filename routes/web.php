<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('home');
});

Route::get('/games/noun-gender-sorter', [\App\Http\Controllers\Games\NounGenderSorterController::class, 'index'])->name('games.noun-gender-sorter');
