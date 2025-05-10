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
