// Get elements
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

        // Event listeners
        toggleBtn.addEventListener('click', openMenu);
        overlay.addEventListener('click', closeMenu);

