# Copilot Instructions for Danish Learning App

## Core Project Technologies (Your Working Environment):
* **Backend**: Laravel (PHP, MVC pattern).
* **Frontend Views**: Laravel Blade templates (`.blade.php` files in `resources/views/`).
* **Client-Side Logic**: Vanilla JavaScript (ES6+ modules) in `resources/js/`.
* **Styling**: Tailwind CSS (utility-first).
* **Build Tool**: Vite manages JavaScript modules and Tailwind CSS. (You write modern JS and Tailwind classes; Vite handles the bundling).

## When Building a Mini-Game Feature:

### JavaScript Development (`resources/js/`):
* **Write ES6+ Modules**: Organize your JavaScript into ES6 modules.
    * Create new files as needed (e.g., `newGameFeature.js`).
    * Import/export functions and variables.
* **DOM Interaction**:
    * Select DOM elements from the Blade templates.
    * Update content and attributes dynamically.
* **State Management**: Manage the feature's state using plain JavaScript objects or simple functions.
* **API Calls**: Use the `Workspace` API to get data from or send data to Laravel backend API endpoints (JSON). Handle responses and errors.
* **Event Handling**: Add event listeners for user interactions.

### HTML (Blade Templates - `resources/views/`):
* **Structure**: Define the HTML structure for your feature within Blade files.
* **Dynamic Data**: If initial data is needed from the server, the Laravel controller will pass it; use it in your Blade template (often available to JS via `@json`).
* **Semantic HTML**: Use appropriate HTML tags for their meaning.

### CSS (Tailwind CSS):
* **Utility-First**: Style elements by adding Tailwind CSS utility classes directly in your Blade templates.
* **Dynamic Styling**: If styles need to change based on JavaScript logic, add or remove complete Tailwind class strings using `element.classList`.
* **Reusable Styles**: If you find yourself repeating many Tailwind classes for the same component type, check `resources/css/app.css` for existing `@apply` directives or discuss creating a new one.

## General Coding Standards:
* **Naming**: Use **camelCase** for JavaScript variables and functions.
* **Strings**: Use **single quotes** in JavaScript.
* **Indentation**: Use **2 spaces**.
* **Functions**: Use **arrow functions** for callbacks.
* **Variables**: Use `const` and `let` appropriately.
* **Clarity**: Write clear, well-commented code. Break complex logic into smaller functions.

## Key Principles:
* **Educational Goals**: Keep in mind the learning objectives: engagement, clear feedback, and interactive learning.
