document.addEventListener('DOMContentLoaded', function () {
	const mobileMenu = document.getElementById('mobileMenu');
	const openMobileMenuButton = document.getElementById('openMobileMenuButton');
	const closeMobileMenuButton = document.getElementById('closeMobileMenuButton');
	const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');

	function openMenu() {
		if (mobileMenu) {
			mobileMenu.classList.remove('hidden');
			// Opcional: podrías querer añadir una clase para la animación de entrada
			// mobileMenu.classList.add('menu-open-animation');
		}
	}

	function closeMenu() {
		if (mobileMenu) {
			// Opcional: podrías querer añadir una clase para la animación de salida
			// mobileMenu.classList.add('menu-close-animation');
			// setTimeout(() => { // Esperar a que la animación termine antes de ocultar
			mobileMenu.classList.add('hidden');
			//    mobileMenu.classList.remove('menu-close-animation');
			// }, 300); // Ajusta el tiempo al de tu animación
		}
	}

	if (openMobileMenuButton) {
		openMobileMenuButton.addEventListener('click', openMenu);
	}

	if (closeMobileMenuButton) {
		closeMobileMenuButton.addEventListener('click', closeMenu);
	}

	if (mobileMenuOverlay) {
		mobileMenuOverlay.addEventListener('click', closeMenu);
	}

	// Opcional: Cerrar el menú si se presiona la tecla Escape
	document.addEventListener('keydown', function (event) {
		if (event.key === 'Escape' && !mobileMenu.classList.contains('hidden')) {
			closeMenu();
		}
	});


	// Código para el Profile Dropdown
	const userMenuButton = document.getElementById('user-menu-button');
	const userMenuDropdown = document.getElementById('user-menu-dropdown');

	// Duración de la transición (debe coincidir con las clases de Tailwind, ej: duration-100)
	const dropdownTransitionDuration = 100;

	if (userMenuButton && userMenuDropdown) {
		function openUserDropdown() {
			userMenuDropdown.classList.remove('hidden');
			requestAnimationFrame(() => {
				userMenuDropdown.classList.remove('opacity-0', 'scale-95');
				userMenuDropdown.classList.add('opacity-100', 'scale-100');
			});
			userMenuButton.setAttribute('aria-expanded', 'true');
		}

		function closeUserDropdown() {
			userMenuDropdown.classList.remove('opacity-100', 'scale-100');
			userMenuDropdown.classList.add('opacity-0', 'scale-95');
			setTimeout(() => {
				userMenuDropdown.classList.add('hidden');
			}, dropdownTransitionDuration);
			userMenuButton.setAttribute('aria-expanded', 'false');
		}

		userMenuButton.addEventListener('click', function (event) {
			event.stopPropagation(); // Previene que el click se propague al document y cierre el menú inmediatamente
			const isExpanded = userMenuButton.getAttribute('aria-expanded') === 'true' || false;
			if (isExpanded) {
				closeUserDropdown();
			} else {
				openUserDropdown();
				// Opcional: Enfocar el primer elemento del menú para accesibilidad
				// userMenuDropdown.querySelector('[role="menuitem"]')?.focus();
			}
		});

		// Cerrar el dropdown si se hace clic fuera de él
		document.addEventListener('click', function (event) {
			if (userMenuButton.getAttribute('aria-expanded') === 'true') {
				if (!userMenuButton.contains(event.target) && !userMenuDropdown.contains(event.target)) {
					closeUserDropdown();
				}
			}
		});

		// Cerrar el dropdown con la tecla Escape
		document.addEventListener('keydown', function (event) {
			if (event.key === 'Escape' && userMenuButton.getAttribute('aria-expanded') === 'true') {
				closeUserDropdown();
			}
		});

		// Opcional: Navegación con flechas dentro del dropdown
		const menuItems = userMenuDropdown.querySelectorAll('[role="menuitem"]');
		menuItems.forEach((item, index) => {
			item.addEventListener('keydown', function (event) {
				if (event.key === 'ArrowUp' || event.key === 'ArrowDown') {
					event.preventDefault();
					let nextIndex;
					if (event.key === 'ArrowUp') {
						nextIndex = (index === 0) ? menuItems.length - 1 : index - 1;
					} else { // ArrowDown
						nextIndex = (index === menuItems.length - 1) ? 0 : index + 1;
					}
					menuItems[nextIndex]?.focus();
				} else if (event.key === 'Home') {
					event.preventDefault();
					menuItems[0]?.focus();
				} else if (event.key === 'End') {
					event.preventDefault();
					menuItems[menuItems.length - 1]?.focus();
				} else if (event.key === 'Tab' && !event.shiftKey && index === menuItems.length - 1) {
					// Si es el último item y se presiona Tab, cerrar el menú
					// (el comportamiento por defecto del tab podría llevar a un lugar no deseado)
					// closeUserDropdown(); // Considera si este comportamiento es deseado
				}
			});
		});


	} else {
		if (!userMenuButton) console.warn('Botón del menú de usuario (user-menu-button) no encontrado.');
		if (!userMenuDropdown) console.warn('Panel del menú de usuario (user-menu-dropdown) no encontrado.');
	}
});