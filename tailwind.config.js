module.exports = {
    darkMode: false, // Tắt dark mode để luôn sử dụng light theme
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
                background: {
                    light: '#ffffff',
                    dark: '#111827',
                },
                text: {
                    light: '#000000',
                    dark: '#ffffff',
                },
            },
        },
    },
    plugins: [require('daisyui')],
};
