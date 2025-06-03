import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

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
		port: 5001,
		strictPort: true,
		hmr: {
			host: '192.168.1.40', // Pon la IP real de tu Mac
			protocol: 'ws', // Usa WebSockets
		},
		headers: {
			"Access-Control-Allow-Origin": "*",
		}
	},
}); 
