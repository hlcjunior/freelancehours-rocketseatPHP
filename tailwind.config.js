/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './app/Http/Livewire/*.php',
    ],
    theme: {
        extend: {
            font: {
                sans: ['Segoe UI', 'sans-serif'],
            }
        },
    },
    plugins: [],
}