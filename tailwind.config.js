// tailwind.config.js

/** @type {import('tailwindcss').Config} */
export default {
	darkMode: 'class',
	content: [
		"./resources/**/*.blade.php",
		"./resources/**/*.js",
		"./vendor/robsontenorio/mary/src/View/Components/**/*.php"
	],
	theme: {
		extend: {
			colors: {
				brand: {
					DEFAULT: '#003399',
					deep: '#002B7A',
					soft: '#E8EDFA',
				},
				action: {
					DEFAULT: '#2563EB',
					deep: '#1D4ED8',
					soft: '#EFF4FF',
				},
				ink: {
					DEFAULT: '#172033',
					muted: '#536176',
					quiet: '#65758B',
				},
				workspace: '#F4F7FB',
				'surface-subtle': '#EEF3F8',
				line: '#D8E0EA',
			},
			fontFamily: {
				sans: ['Inter', 'ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'sans-serif'],
			},
			boxShadow: {
				workflow: '0 4px 8px rgba(23, 32, 51, 0.10)',
				floating: '0 8px 16px rgba(23, 32, 51, 0.14)',
			},
		},
	},
	plugins: [
		require("daisyui")
	],
	daisyui: {
		themes: [
			{
				mytheme: {
					"primary": "#003399",
					"secondary": "#2563EB",
					"accent": "#F59E0B",
					"neutral": "#172033",
					"base-100": "#ffffff",
					"info": "#2563EB",
					"success": "#067647",
					"warning": "#B54708",
					"error": "#B42318",
				},
			},
		],
	},
}
