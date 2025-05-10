@extends('layouts.app')

@section('title', 'Dansk Memory Spil')

@section('content')
<div class="flex flex-col items-center justify-start min-h-screen py-10 font-sans text-slate-800 bg-slate-100">
  <h1 class="text-4xl font-bold text-slate-700 mb-8">Dansk Memory Spil</h1>

  <form id="topicForm" class="mb-8 p-6 bg-white rounded-xl shadow-lg w-full max-w-lg">
    <div class="mb-6">
      <label for="topicSelect" class="block text-slate-700 text-sm font-semibold mb-2">Vælg et Emne:</label>
      <select id="topicSelect" name="topic" class="shadow-sm appearance-none border border-slate-300 rounded-md w-full py-3 px-4 text-slate-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        <option value="default" disabled selected>-- Vælg venligst --</option>
        <option value="jobs">Jobs & Arbejde</option>
        <option value="food">Mad & Drikke</option>
        <option value="travel">Rejser & Transport</option>
        <option value="hobbies">Fritid & Hobbies</option>
      </select>
    </div>
    <div class="flex items-center justify-center">
      <button type="submit" id="startGameButton" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg focus:outline-none focus:shadow-outline transition-colors duration-150 ease-in-out shadow-md hover:shadow-lg">
        Hent Ord & Start Spil
      </button>
    </div>
  </form>

  <div id="gameContainer" class="w-full max-w-4xl memory-card-flip perspective">
    <div class="game-info mb-6 p-4 bg-white rounded-lg shadow-md flex justify-around text-lg w-full max-w-md mx-auto">
      <div>Forsøg: <span id="movesCounter" class="font-semibold">0</span></div>
      <div>Fundne Par: <span id="pairsCounter" class="font-semibold">0</span>/<span id="totalPairsDisplay" class="font-semibold">0</span></div>
    </div>

    <div class="controls mb-6 text-center">
      <button class="button bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-2 px-5 rounded-lg focus:outline-none focus:shadow-outline transition-colors shadow hover:shadow-md" id="resetButton" style="display: none;">Nulstil Spil</button>
    </div>

    <div class="game-board grid grid-cols-4 sm:grid-cols-5 md:grid-cols-6 lg:grid-cols-8 gap-3 p-4 bg-white rounded-xl shadow-xl min-h-[100px]" id="gameBoard">
      <p class="text-slate-500 col-span-full text-center py-10">Vælg et emne og tryk på 'Hent Ord & Start Spil' for at begynde.</p>
    </div>
  </div>

  <div id="winModal" class="fixed inset-0 bg-slate-900 bg-opacity-75 flex items-center justify-center p-4 z-50" style="display: none;">
    <div class="bg-white p-8 rounded-xl shadow-2xl text-center max-w-sm w-full">
      <h2 class="text-3xl font-bold text-green-500 mb-5">Tillykke!</h2>
      <p class="text-slate-700 mb-2">Du har fundet alle par!</p>
      <p class="text-slate-600 mb-6">Dine forsøg: <span id="finalMoves" class="font-semibold"></span></p>
      <button class="button bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-lg focus:outline-none focus:shadow-outline transition-colors w-full shadow-md hover:shadow-lg" id="playAgainButton">Spil Igen Med Samme Emne</button>
      <button class="button bg-slate-500 hover:bg-slate-600 text-white font-semibold py-3 px-6 rounded-lg focus:outline-none focus:shadow-outline transition-colors w-full mt-3 shadow-md hover:shadow-lg" id="newTopicButton">Vælg Nyt Emne</button>
    </div>
  </div>
</div>
@endsection

@push('styles')
@endpush

@push('scripts')
@vite('resources/js/games/memory-game/index.js')
@endpush
