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
					"primary": "#000000",
					"secondary": "#ff00ff",
					"accent": "#00ffff",
					"neutral": "#ff00ff",
					"base-100": "#ffffff",
					"info": "#0000ff",
					"success": "#00ff00",
					"warning": "#00ff00",
					"error": "#ff0000",
				},
			},
		],
	},
}