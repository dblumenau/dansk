<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemoryTermController;
use App\Http\Controllers\MemoryGameController;

Route::get('/', function () {
  return view('home');
});

Route::get('/games/noun-gender-sorter', [\App\Http\Controllers\Games\NounGenderSorterController::class, 'index'])->name('games.noun-gender-sorter');

// Removed problematic route: Route::get('/games/memory-game', function () { return view('games.memory-game'); })->name('games.memory-game');

Route::resource('memory-terms', MemoryTermController::class);

// Memory Game Routes
Route::get('/memory-game', [MemoryGameController::class, 'index'])->name('memory-game.index');
Route::get('/memory-game/{topicSlug}', [MemoryGameController::class, 'playTopic'])->name('memory-game.play');
