import './bootstrap';

import $ from 'jquery';
window.$ = window.jQuery = $;

if ('serviceWorker' in navigator) {
	navigator.serviceWorker.register('/service-worker.js')
		.then(() => console.log('SW registrado'))
		.catch(err => console.error('SW error', err));
}