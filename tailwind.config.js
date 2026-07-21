/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                brand: {
                    blue: '#3b82f6', // Softer vibrant blue
                    blue2: '#2563eb', // Hover blue
                    navy: '#0f172a', // Premium dark slate for text/sidebar
                    ink: '#1e293b',
                    muted: '#64748b',
                    line: '#e2e8f0',
                    soft: '#f8fafc', // Softest gray/blue background
                },
            },
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', 'Segoe UI', 'Arial', 'sans-serif'],
            },
            boxShadow: {
                card: '0 6px 16px rgba(17,36,79,.07)',
                soft: '0 4px 20px -2px rgba(0,0,0,0.04)',
                'soft-hover': '0 12px 30px -4px rgba(0,0,0,0.08)',
            },
            borderRadius: {
                card: '16px',
            },
        },
    },
    plugins: [],
};
