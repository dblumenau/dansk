@extends('layouts.app')

@section('title', 'Home')

@section('content')
  <div class="min-h-[calc(100vh-10rem)] bg-gradient-to-br from-sky-50 via-rose-50 to-amber-50 py-12 px-4 sm:px-6 lg:px-8">
    <!-- Hero Section -->
    <div class="text-center mb-16">
      <h1 class="text-5xl sm:text-6xl md:text-7xl font-extrabold tracking-tight mb-4">
        <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-pink-500 to-purple-600">Master Danish,</span>
        <span class="block text-gray-700">One Click at a Time.</span>
      </h1>
      <p class="mt-3 max-w-md mx-auto text-base text-gray-600 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
        Unlock the beauty of the Danish language with our interactive lessons, fun games, and a supportive community. Din rejse starter her!
      </p>
      <div class="mt-8 flex justify-center">
        <div class="rounded-md shadow">
          <a href="#" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gradient-to-r from-blue-600 to-pink-500 hover:from-pink-500 hover:to-blue-600 md:py-4 md:text-lg md:px-10 transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
            Start Learning Now
          </a>
        </div>
        <div class="mt-3 sm:mt-0 sm:ml-3">
          <a href="#" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 md:py-4 md:text-lg md:px-10 transform transition-all duration-300 hover:scale-105">
            Explore Features
          </a>
        </div>
      </div>
    </div>

    <!-- Features Section -->
    <div class="max-w-7xl mx-auto">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Why Choose Us?</h2>
        <p class="mt-4 text-lg text-gray-600">Everything you need to become fluent in Danish, all in one place.</p>
      </div>
      <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 lg:gap-x-8">
        <!-- Feature 1 -->
        <div class="bg-white/70 backdrop-blur-md p-6 rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 border border-gray-200">
          <div class="flex items-center justify-center h-12 w-12 rounded-md bg-gradient-to-br from-blue-500 to-indigo-600 text-white mb-4">
            <!-- Heroicon name: outline/academic-cap -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.627 48.627 0 0 1 12 20.904a48.627 48.627 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.902 59.902 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-gray-900 mb-2">Interactive Lessons</h3>
          <p class="text-base text-gray-600">Engage with dynamic content designed by language experts to make learning Danish intuitive and fun.</p>
        </div>
        <!-- Feature 2 -->
        <div class="bg-white/70 backdrop-blur-md p-6 rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 border border-gray-200">
          <div class="flex items-center justify-center h-12 w-12 rounded-md bg-gradient-to-br from-pink-500 to-rose-600 text-white mb-4">
            <!-- Heroicon name: outline/puzzle-piece -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
              <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 6.087c0-.599.484-1.083 1.083-1.083h.002c.599 0 1.083.484 1.083 1.083v.002c0 .599-.484 1.083-1.083 1.083h-.002a1.083 1.083 0 0 1-1.083-1.083Zm0 0c0 .599-.484 1.083-1.083 1.083H12c-.599 0-1.083-.484-1.083-1.083v.002c0-.599.484-1.083 1.083-1.083h1.168ZM11.25 9.087h1.5v1.5h-1.5v-1.5Zm0 3h1.5v1.5h-1.5v-1.5Zm0 3h1.5v1.5h-1.5v-1.5Zm0 3h1.5v1.5h-1.5v-1.5Zm-3-12h1.5v1.5h-1.5v-1.5Zm0 3h1.5v1.5h-1.5v-1.5Zm0 3h1.5v1.5h-1.5v-1.5Zm0 3h1.5v1.5h-1.5v-1.5Zm0 3h1.5v1.5h-1.5v-1.5Zm-3-12h1.5v1.5h-1.5v-1.5Zm0 3h1.5v1.5h-1.5v-1.5Zm0 3h1.5v1.5h-1.5v-1.5Zm0 3h1.5v1.5h-1.5v-1.5Zm0 3h1.5v1.5h-1.5v-1.5Zm10.125-9.087c.704-.022 1.399-.022 2.103 0a.75.75 0 0 1 .75.75v12.004a.75.75 0 0 1-.75.75c-.704.022-1.399.022-2.103 0a.75.75 0 0 1-.75-.75V6.837a.75.75 0 0 1 .75-.75ZM9.375 3.087c.704-.022 1.399-.022 2.103 0a.75.75 0 0 1 .75.75v16.504a.75.75 0 0 1-.75.75c-.704.022-1.399.022-2.103 0a.75.75 0 0 1-.75-.75V3.837a.75.75 0 0 1 .75-.75Zm-3.375 3.375c.704-.022 1.399-.022 2.103 0a.75.75 0 0 1 .75.75v10.504a.75.75 0 0 1-.75.75c-.704.022-1.399.022-2.103 0a.75.75 0 0 1-.75-.75V7.212a.75.75 0 0 1 .75-.75Z" />
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-gray-900 mb-2">Fun Learning Games</h3>
          <p class="text-base text-gray-600">Reinforce your vocabulary and grammar through a variety of engaging games. Learning has never been so enjoyable!</p>
        </div>
        <!-- Feature 3 -->
        <div class="bg-white/70 backdrop-blur-md p-6 rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 border border-gray-200">
          <div class="flex items-center justify-center h-12 w-12 rounded-md bg-gradient-to-br from-amber-500 to-orange-600 text-white mb-4">
            <!-- Heroicon name: outline/users -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
              <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m8.007 0a3 3 0 0 0-4.682-2.72M12 12.75a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z" />
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-gray-900 mb-2">Community Support</h3>
          <p class="text-base text-gray-600">Connect with fellow learners, practice speaking, and get help from native speakers in our friendly community forums.</p>
        </div>
      </div>
    </div>

    <!-- Call to Action Section -->
    <div class="mt-20 bg-gradient-to-r from-blue-700 via-pink-600 to-purple-700 rounded-xl shadow-2xl">
      <div class="max-w-2xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
          <span class="block">Ready to dive in?</span>
          <span class="block text-blue-200">Start your Danish adventure today.</span>
        </h2>
        <p class="mt-4 text-lg leading-6 text-blue-100">
          Join thousands of students who are already on their way to fluency. It's free to get started!
        </p>
        <a href="#" class="mt-8 w-full inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-md text-base font-medium text-blue-600 bg-white hover:bg-blue-50 sm:w-auto transform transition-all duration-300 hover:scale-105">
          Sign Up for Free
        </a>
      </div>
    </div>
  </div>
@endsection
