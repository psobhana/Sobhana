<!-- menu.php -->
<?php
// Slide‑in navigation menu (off‑canvas)
// This file is included by index.php
?>
<!-- Overlay that darkens the page when the menu is open -->
<div id="menuOverlay"
     class="fixed inset-0 bg-black bg-opacity-30 hidden md:hidden"
     aria-hidden="true"></div>

<!-- Off‑canvas menu container -->
<nav id="slideMenu"
     class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out md:transform-none md:shadow-none"
     aria-label="Primary navigation">

    <!-- Close button (visible on mobile) -->
    <div class="flex items-center justify-between p-4">
        <h2 class="text-lg font-semibold text-gray-800">Menu</h2>
        <button id="closeMenuBtn"
                class="p-2 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                aria-label="Close menu">
            <img src="https://unpkg.com/lucide-static@latest/icons/x.svg"
                 alt="Close"
                 class="lucide">
        </button>
    </div>

    <!-- Navigation links -->
    <ul class="mt-2 space-y-1">
        <li>
            <a href="../index.php"
               class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                <img src="https://unpkg.com/lucide-static@latest/icons/home.svg"
                     alt="Home"
                     class="lucide mr-3">
                Home
            </a>
        </li>
        <li>
            <a href="../add.php"
               class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                <img src="https://unpkg.com/lucide-static@latest/icons/user.svg"
                     alt="Profile"
                     class="lucide mr-3">
                Add Data
            </a>
        </li>
	<li>
            <a href="../import_tsv.php"
               class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                <img src="https://unpkg.com/lucide-static@latest/icons/user.svg"
                     alt="Profile"
                     class="lucide mr-3">
                Import TSV
            </a>
        </li>
	<li>
            <a href="../export_tsv.php"
               class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                <img src="https://unpkg.com/lucide-static@latest/icons/user.svg"
                     alt="Profile"
                     class="lucide mr-3">
                Export TSV
            </a>
        </li>
	<li>
            <a href="dhammagaru_long_sinhala.php"
               class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                <img src="https://unpkg.com/lucide-static@latest/icons/user.svg"
                     alt="Profile"
                     class="lucide mr-3">
                Garu-Sinhala-Long
            </a>
        </li>
        <li>
            <a href="filter_by_language_length.php"
               class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                <img src="https://unpkg.com/lucide-static@latest/icons/user.svg"
                     alt="Profile"
                     class="lucide mr-3">
                Language & Length
            </a>
        </li>
    </ul>

    <!-- Optional footer inside the menu -->
    <div class="mt-auto p-4 text-sm text-gray-500">
        © 2026 Talks Database
    </div>
</nav>

<script>
    // Close button for the menu (mobile only)
    document.getElementById('closeMenuBtn').addEventListener('click', function () {
        const menu = document.getElementById('slideMenu');
        const overlay = document.getElementById('menuOverlay');
        menu.classList.add('-translate-x-full');
        menu.classList.remove('translate-x-0');
        overlay.classList.add('hidden');
    });
</script>