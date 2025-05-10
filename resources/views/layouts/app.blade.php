<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Danish Learning App')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>
  <body class="bg-gray-50 min-h-screen flex flex-col">
    <header class="bg-white shadow p-4">
      <div class="container mx-auto">
        <h1 class="text-2xl font-bold text-gray-800">Danish Learning App</h1>
      </div>
    </header>
    <main class="flex-1 container mx-auto p-4">
      @yield('content')
    </main>
    <footer class="bg-gray-100 text-center text-gray-500 py-4 text-sm">
      &copy; {{ date('Y') }} Danish Learning App
    </footer>
  </body>
</html>
