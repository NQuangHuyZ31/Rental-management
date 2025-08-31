module.exports = {
    darkMode: 'class',
    content: ['./views/**/*.{html,js,ts,jsx,tsx,php}', './index.php'],
    // content: ['./**/*.php', './**/*.html', './**/*.js'],
    theme: {
        extend: {
            boxShadow: {
                full: '0px 0px 4px 2px rgba(0, 0, 0, 0.1)',
            },
            colors: {
                'lozido-green': '#10B981',
                'lozido-orange': '#F59E0B',
            },
        },
    },
    plugins: [require('daisyui')],
};
