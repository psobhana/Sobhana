
const menu = document.getElementById('slideMenu');
const toggleBtn = document.getElementById('menuToggle');
const overlay = document.getElementById('menuOverlay');

// Open menu
function openMenu() {
    menu.classList.remove('-translate-x-full');
    menu.classList.add('translate-x-0');
    overlay.classList.remove('hidden');
}

// Close menu
function closeMenu() {
    menu.classList.remove('translate-x-0');
    menu.classList.add('-translate-x-full');
    overlay.classList.add('hidden');
}

// Toggle button
toggleBtn.addEventListener('click', function (event) {
    event.stopPropagation();

    if (menu.classList.contains('translate-x-0')) {
        closeMenu();
    } else {
        openMenu();
    }
});

// Close when clicking outside the menu
document.addEventListener('click', function (event) {
    if (
        menu.classList.contains('translate-x-0') &&
        !menu.contains(event.target) &&
        !toggleBtn.contains(event.target)
    ) {
        closeMenu();
    }
});

// Close when clicking the overlay
overlay.addEventListener('click', closeMenu);

// Close button inside the menu
const closeBtn = document.getElementById('closeMenuBtn');

if (closeBtn) {
    closeBtn.addEventListener('click', closeMenu);
}
