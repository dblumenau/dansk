import './bootstrap'
import Alpine from 'alpinejs' // Import Alpine
import.meta.glob(['../images/**', '../font/**']) // Example: if you want Vite to process images/fonts
import '../css/app.css'
import './games/noun-gender-sorter/index.js' // Danish Noun Gender Sorter mini-game

window.Alpine = Alpine // Make Alpine globally available
Alpine.start() // Start Alpine
