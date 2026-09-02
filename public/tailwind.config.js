/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                navy: { 950:'#070d1a', 900:'#0b1220', 800:'#111a2e', 700:'#182444' },
                brand: { 300:'#5eead4', 400:'#2dd4bf', 500:'#14b8a6', 600:'#0d9488' },
                gold: { 400:'#fbbf24', 500:'#f59e0b' },
            },
            fontFamily: {
                sans: ['Vazirmatn', 'Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            },
            animation: {
                float: 'float 6s ease-in-out infinite',
                'float-slow': 'float 9s ease-in-out infinite',
            },
            keyframes: {
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-16px)' },
                },
            },
        },
    },
    plugins: [],
}
