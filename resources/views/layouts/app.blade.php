<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Danish Learning App')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
  </head>
  <body class="bg-gray-50 min-h-screen flex flex-col">
    <header class="bg-white shadow p-4">
      <div class="container mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Danish Learning App</h1>
        <nav class="w-full sm:w-auto">
          <ul class="flex flex-col sm:flex-row gap-2 sm:gap-6 items-center justify-center">
            <li>
              <a href="/" class="text-gray-700 hover:text-sky-700 font-medium transition-colors px-3 py-2 rounded hover:bg-sky-100 focus:outline-none focus:ring-2 focus:ring-sky-400">Home</a>
            </li>
            <li>
              <a href="{{ route('games.noun-gender-sorter') }}" class="text-gray-700 hover:text-sky-700 font-medium transition-colors px-3 py-2 rounded hover:bg-sky-100 focus:outline-none focus:ring-2 focus:ring-sky-400">Noun Gender Sorter</a>
            </li>
            <li>
              <a href="{{ route('games.memory-game') }}" class="text-gray-700 hover:text-sky-700 font-medium transition-colors px-3 py-2 rounded hover:bg-sky-100 focus:outline-none focus:ring-2 focus:ring-sky-400">Memory Game</a>
            </li>
            <!-- Add more nav links here as you add more games -->
          </ul>
        </nav>
      </div>
    </header>
    <main class="flex-1 container mx-auto p-4">
      @yield('content')
    </main>
    <footer class="bg-gray-100 text-center text-gray-500 py-4 text-sm">
      &copy; {{ date('Y') }} Danish Learning App
    </footer>
    @stack('scripts')
  </body>
</html>
