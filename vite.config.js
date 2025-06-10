import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite'
import fs from 'node:fs';

export default defineConfig({
	plugins: [
		laravel({
			input: ['resources/css/app.css', 'resources/js/app.js'],
			refresh: true,
		}),
		tailwindcss(),
	],
	server: {
		host: '192.168.1.40',
		port: 5174,
	},
});
