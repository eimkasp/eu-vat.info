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
		extend: {},
	},
	plugins: [
		require("daisyui")
	],
	daisyui: {
		themes: [
			{
				mytheme: {
					"primary": "#003399",
					"secondary": "#0EA5E9",
					"accent": "#F59E0B",
					"neutral": "#374151",
					"base-100": "#ffffff",
					"info": "#3b82f6",
					"success": "#10B981",
					"warning": "#F59E0B",
					"error": "#EF4444",
				},
			},
		],
	},
}