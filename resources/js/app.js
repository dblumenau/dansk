import './bootstrap'
import Alpine from 'alpinejs' // Import Alpine
import.meta.glob(['../images/**', '../font/**']) // Example: if you want Vite to process images/fonts
import '../css/app.css'

window.Alpine = Alpine // Make Alpine globally available
Alpine.start() // Start Alpine
