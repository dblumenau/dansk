#!/bin/zsh
# set -x # Removed for cleaner output
set -e

# --- Configuration ---
# Project root can be customized here
PROJECT_ROOT="/Users/david/Sites/dansk/" # From your original script

# --- Colors and Styles ---
C_RESET='\033[0m'
C_RED='\033[0;31m'
C_GREEN='\033[0;32m'
C_YELLOW='\033[0;33m'
C_BLUE='\033[0;34m'
C_MAGENTA='\033[0;35m'
C_CYAN='\033[0;36m'
C_WHITE_BOLD='\033[1;37m'
C_GREEN_BOLD='\033[1;32m'
C_YELLOW_BOLD='\033[1;33m'
C_MAGENTA_BOLD='\033[1;35m'
C_CYAN_BOLD='\033[1;36m'
C_BLUE_BOLD='\033[1;34m'

# --- Helper Functions ---
print_header() {
  echo -e "${C_MAGENTA_BOLD}"
  echo "===================================================================="
  echo "🚀 Laravel Sparkle Installer 🚀"
  echo "===================================================================="
  echo -e "${C_RESET}"
}

print_footer() {
  echo -e "${C_GREEN_BOLD}"
  echo "===================================================================="
  echo "🎉 All Done! Your Laravel project is ready to shine! 🎉"
  echo "===================================================================="
  echo -e "${C_RESET}"
}

print_step() {
  echo -e "\n${C_CYAN_BOLD}✨ Step $1: $2 ✨${C_RESET}"
}

print_subsection() {
  echo -e "${C_YELLOW}➡️ $1${C_RESET}"
}

print_success_msg() {
  echo -e "${C_GREEN}👍 $1${C_RESET}"
}

print_error() {
  echo -e "${C_RED}❌ Error: $1${C_RESET}" >&2
}

print_warning() {
  echo -e "${C_YELLOW_BOLD}⚠️ $1${C_RESET}"
}

print_info() {
  echo -e "${C_BLUE_BOLD}ℹ️ $1${C_RESET}"
}

# --- Script Start ---
print_header
sleep 1 # For a little dramatic pause

# Check for required commands
print_info "Checking for required commands (laravel, composer, npm, php)..."
for cmd_to_check in laravel composer npm php; do
  if ! command -v "$cmd_to_check" >/dev/null 2>&1; then
    print_error "$cmd_to_check is not installed. Please install it first."
    exit 1
  fi
done
print_success_msg "All required commands are available."


print_step "0" "Cleaning target directory: ${PROJECT_ROOT}"
if [ -d "$PROJECT_ROOT" ]; then
  cd "$PROJECT_ROOT"
  print_subsection "Removing old files (keeping .git, .vscode, script, LICENSE, README.md)..."
  find . -mindepth 1 \
      \( -name '.git' -o -name '.vscode' \) -prune -o \
      -not -name "$(basename "$0")" \
      -not -name 'LICENSE' \
      -not -name 'README.md' \
      -delete
  print_success_msg "Target directory cleaned."
else
  print_warning "Target directory ${PROJECT_ROOT} does not exist yet. Skipping cleanup."
fi


print_step "1" "Creating new Laravel project"
TEMP_DIR=$(mktemp -d)
print_info "Temporary directory created at: $TEMP_DIR"

cd "$TEMP_DIR"
print_subsection "Creating Laravel project skeleton with Composer (this might take a moment)..."
composer create-project laravel/laravel temp_laravel_app --prefer-dist --no-interaction --no-scripts --quiet
print_success_msg "Laravel project skeleton created."

print_subsection "Moving Laravel files to target directory: ${PROJECT_ROOT}..."
mkdir -p "$PROJECT_ROOT"
rsync -ahq temp_laravel_app/ "$PROJECT_ROOT" --exclude '.git/'
cd "$PROJECT_ROOT"
print_success_msg "Laravel files moved to project root."

print_subsection "Cleaning up temporary directory..."
rm -rf "$TEMP_DIR"
print_success_msg "Temporary directory cleaned up."


print_step "1c" "Setting up .env file"
if [ -f ".env.example" ]; then
  cp .env.example .env
  print_success_msg ".env file created from .env.example."
else
  print_warning ".env.example not found! Cannot create .env file. This might cause issues."
fi

print_step "1d" "Configuring SQLite in .env"
if [ -f ".env" ]; then
  sed -i '' 's/DB_CONNECTION=mysql/DB_CONNECTION=sqlite/' .env
  sed -i '' '/^DB_HOST=/d' .env
  sed -i '' '/^DB_PORT=/d' .env
  sed -i '' '/^DB_DATABASE=/d' .env
  sed -i '' '/^DB_USERNAME=/d' .env
  sed -i '' '/^DB_PASSWORD=/d' .env
  print_subsection "Ensuring database/database.sqlite file exists..."
  mkdir -p database
  touch database/database.sqlite
  print_success_msg ".env configured for SQLite and database/database.sqlite created."
else
  print_warning ".env file not found! Skipping SQLite configuration."
fi

print_step "2" "Installing Composer dependencies"
print_subsection "Running composer install (this might take a moment)..."
composer install --prefer-dist --no-progress --no-dev -q # Use --quiet for even less composer output, or remove --no-progress if you like composer's progress bar
print_success_msg "Composer dependencies installed."

print_step "4" "Setting permissions for storage and bootstrap/cache"
mkdir -p storage/framework/{sessions,views,cache} storage/logs bootstrap/cache
chmod -R 775 storage bootstrap/cache || print_warning "Could not set all permissions for storage/bootstrap/cache."
print_success_msg "Permissions set for storage and bootstrap/cache."

print_step "5" "Generating application key"
php artisan key:generate
# The command itself outputs success, so an extra print_success_msg might be redundant unless we quiet it.

print_step "7" "Installing and configuring Laravel Telescope"
print_subsection "Requiring laravel/telescope (dev dependency)..."
composer require --dev laravel/telescope --quiet
php artisan telescope:install
print_subsection "Cleaning up any pre-existing Telescope migration files..."
find database/migrations -name '*_create_telescope_entries_table.php' -delete || true
print_success_msg "Pre-existing Telescope migration files cleaned (if any)."
print_subsection "Force publishing Telescope assets..."
php artisan vendor:publish --provider="Laravel\Telescope\TelescopeServiceProvider" --force
print_success_msg "Laravel Telescope installed and configured."

print_step "8" "Running all migrations"
php artisan migrate -q
# Migrate command has its own detailed and useful output.

print_step "9" "Installing Laravel Debugbar"
print_subsection "Requiring barryvdh/laravel-debugbar (dev dependency)..."
composer require --dev barryvdh/laravel-debugbar --quiet
print_success_msg "Laravel Debugbar installed."

print_step "10" "Installing Node dependencies"
print_subsection "Running initial npm install..."
npm install --silent # Or --quiet, depending on npm version for less output
print_success_msg "Base Node dependencies installed."
print_subsection "Installing/Updating Tailwind CSS, PostCSS, Autoprefixer, AlpineJS..."
npm install -D tailwindcss@latest postcss@latest autoprefixer@latest alpinejs@latest --silent # Or --quiet
print_success_msg "Frontend dev dependencies installed."

print_subsection "Installing Prettier and plugins..."
npm install -D prettier prettier-plugin-tailwindcss @prettier/plugin-php prettier-plugin-blade prettier-plugin-sh --silent
print_success_msg "Prettier and plugins installed."

print_step "10b" "Creating Prettier configuration files"
print_subsection "Creating .prettierrc..."
cat << 'EOF' > .prettierrc
{
  "semi": false,
  "singleQuote": true,
  "printWidth": 80,
  "tabWidth": 2,
  "useTabs": false,
  "trailingComma": "es5",
  "bracketSpacing": true,
  "arrowParens": "always",
  "plugins": ["prettier-plugin-tailwindcss", "@prettier/plugin-php", "prettier-plugin-blade", "prettier-plugin-sh"]
}
EOF
print_success_msg ".prettierrc created."

print_subsection "Creating .prettierignore..."
cat << 'EOF' > .prettierignore
/bootstrap/cache/
/node_modules/
/public/build/
/storage/
/vendor/
.env
*.lock
EOF
print_success_msg ".prettierignore created."

print_step "11" "Creating Tailwind CSS v4 configuration (tailwind.config.js)"
mkdir -p resources/js resources/css
cat << 'EOF' > tailwind.config.js
import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite'

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './app/View/Components/**/**/*.php', // For Blade components
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php', // For Laravel pagination
  ],
  theme: {
    extend: {},
  },
  plugins: [tailwindcss()],
}
EOF
print_success_msg "tailwind.config.js created."

print_step "14" "Creating resources/css/app.css with Tailwind directives"
cat << 'EOF' > resources/css/app.css
@import 'tailwindcss';
@source "../views";
EOF
print_success_msg "resources/css/app.css created."

print_step "15" "Creating resources/js/app.js and vite.config.js"
print_subsection "Creating resources/js/app.js..."
echo "import './bootstrap';
import Alpine from 'alpinejs'; // Import Alpine
import.meta.glob(['../images/**', '../font/**']); // Example: if you want Vite to process images/fonts
import '../css/app.css';

window.Alpine = Alpine; // Make Alpine globally available
Alpine.start(); // Start Alpine
" > resources/js/app.js
print_success_msg "resources/js/app.js created."

print_subsection "Creating vite.config.js..."
echo "import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
" > vite.config.js
print_success_msg "vite.config.js created."

print_step "16" "Creating Blade layout and view files"
print_subsection "Creating resources/views/layouts/app.blade.php..."
mkdir -p resources/views/layouts
cat << 'EOF' > resources/views/layouts/app.blade.php
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
EOF
print_success_msg "resources/views/layouts/app.blade.php created."

print_subsection "Creating resources/views/layout.blade.php..."
mkdir -p resources/views
cat << 'EOF' > resources/views/layout.blade.php
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dansk Learning App</title>
  {{-- Vite will compile and load assets --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
  @yield('content')
</body>
</html>
EOF
print_success_msg "resources/views/layout.blade.php created."

print_subsection "Creating resources/views/home.blade.php..."
mkdir -p resources/views
cat << 'EOF' > resources/views/home.blade.php
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
EOF
print_success_msg "resources/views/home.blade.php created."

print_step "19" "Formatting project with Prettier"
print_subsection "Running npx prettier --write . --ignore-path .prettierignore..."
npx prettier --write . --ignore-path .prettierignore
print_success_msg "Project files formatted with Prettier."

print_step "20" "Building assets with Vite"
print_subsection "Running npm run build (this might take a moment)..."
npm run build # npm run build often has useful output, so not silencing it by default
print_success_msg "Assets built with Vite."

print_footer
sleep 1

echo -e "${C_WHITE_BOLD}🚀 Next Steps:${C_RESET}"
echo -e "${C_GREEN}1. Configure your .env file further if needed (APP_URL, mail services, etc.).${C_RESET}"
echo -e "${C_GREEN}2. Start the Vite development server with:${C_RESET} ${C_YELLOW_BOLD}npm run dev${C_RESET}"
echo -e "${C_GREEN}3. Open your awesome new application in the browser!${C_RESET}"
echo ""
echo -e "${C_MAGENTA_BOLD}🎉 Happy Developing from your pals at Gemini! 🎉${C_RESET}"
echo ""
# --- Script End ---
