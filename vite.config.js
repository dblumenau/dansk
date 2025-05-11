import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import tailwindcss from '@tailwindcss/vite' // Added import

export default defineConfig({
  plugins: [
    tailwindcss(), // Added plugin
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
  ],
   server: {
        host: true, // or '0.0.0.0'
   }
})
