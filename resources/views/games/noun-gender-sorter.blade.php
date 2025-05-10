@extends('layouts.app')

@section('title', 'Danish Noun Gender Sorter')

@section('content')
<div id="game-noun-sorter-container" class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-sky-100 to-blue-200 p-4 selection:bg-sky-200" aria-labelledby="game-title">
    <div class="game-wrapper w-full max-w-3xl bg-white p-6 sm:p-8 rounded-xl shadow-2xl">
        <h1 id="game-title" class="text-3xl sm:text-4xl font-bold text-sky-700 mb-6 sm:mb-8 text-center">Danish Noun Gender Sorter</h1>

        <!-- Scoreboard and Lives -->
        <div class="flex justify-between items-center mb-6 text-lg sm:text-xl">
            <p class="text-gray-700">Score: <span id="score-display" class="font-bold text-sky-600">0</span></p>
            <p class="text-gray-700">Lives: <span id="lives-display" class="font-bold text-red-500">3</span></p>
        </div>

        <!-- Noun Display Area (Draggable Item / Focus for Keyboard) -->
        <div id="noun-presentation-area" class="text-center mb-8 p-4 bg-sky-50 rounded-lg shadow-inner"
             aria-live="polite" aria-atomic="true">
            <p class="text-gray-500 text-sm mb-1">Which gender is this noun?</p>
            <div id="draggable-noun"
                 class="inline-block p-3 px-5 bg-white border-2 border-sky-300 rounded-md shadow-md cursor-grab active:cursor-grabbing focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                 tabindex="0"
                 role="button"
                 aria-grabbed="false"
                 aria-describedby="noun-instruction">
                <span id="current-danish-noun" class="text-2xl sm:text-3xl font-semibold text-sky-800"></span>
                <span id="current-english-noun" class="block text-sm text-gray-500 mt-1"></span>
            </div>
            <p id="noun-instruction" class="sr-only">Drag this noun to a gender zone or use arrow keys and Enter to select a gender.</p>
        </div>

        <!-- Drop Zones -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-8">
            <button id="en-zone" data-gender="en" type="button"
                 class="drop-zone flex flex-col items-center justify-center p-6 min-h-[120px] bg-green-100 border-4 border-dashed border-green-300 hover:border-green-500 hover:bg-green-200 rounded-lg text-2xl font-bold text-green-700 transition-all duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-600"
                 tabindex="0" role="group" aria-label="Common gender (en). Drop noun here or press 'E' or Left Arrow."
                 aria-dropeffect="move">
                <span>EN</span>
                <span class="text-sm font-normal text-green-600">(Common)</span>
            </button>
            <button id="et-zone" data-gender="et" type="button"
                 class="drop-zone flex flex-col items-center justify-center p-6 min-h-[120px] bg-yellow-100 border-4 border-dashed border-yellow-300 hover:border-yellow-500 hover:bg-yellow-200 rounded-lg text-2xl font-bold text-yellow-700 transition-all duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-yellow-600"
                 tabindex="0" role="group" aria-label="Neuter gender (et). Drop noun here or press 'T' or Right Arrow."
                 aria-dropeffect="move">
                <span>ET</span>
                <span class="text-sm font-normal text-yellow-600">(Neuter)</span>
            </button>
        </div>

        <!-- Feedback Area -->
        <div id="feedback-area" aria-live="assertive" class="text-center h-10 mb-6 text-xl font-medium">
            <!-- Feedback like "Correct!" or "Incorrect!" will appear here -->
        </div>

        <!-- Controls -->
        <div class="text-center space-x-4">
            <button id="start-button" class="btn-primary px-8 py-3 text-lg">Start Game</button>
            <button id="next-word-button" class="btn-secondary hidden px-8 py-3 text-lg">Next Word</button>
        </div>
    </div>

    <!-- Game Over Modal (hidden by default) -->
    <div id="game-over-modal"
         class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center p-4 hidden transition-opacity duration-300 ease-in-out"
         aria-modal="true" role="dialog" aria-labelledby="game-over-title" aria-describedby="game-over-description">
        <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-sm text-center">
            <h2 id="game-over-title" class="text-3xl font-bold text-gray-800 mb-4">Game Over!</h2>
            <p id="game-over-description" class="text-lg text-gray-600 mb-6">Your final score: <span id="final-score-modal" class="font-bold text-sky-600">0</span></p>
            <button id="restart-button-modal" class="btn-primary w-full py-3 text-lg">Play Again</button>
        </div>
    </div>
</div>

<script>
  // Pass initial data from Laravel controller to JavaScript
  window.danishNounData = @json($danishNouns ?? []);
</script>
@endsection

@push('styles')
@endpush
