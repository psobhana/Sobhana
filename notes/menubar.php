<?php
/**
 * Responsive Navigation Bar Component
 */
?>
<nav class="navbar" role="navigation" aria-label="Main Navigation">
  <div class="nav-container">
    
    <a href="index.php" class="nav-logo">Home</a>
    
    <button class="hamburger" id="hamburger" aria-label="Toggle Menu" aria-expanded="false">
      <span></span>
      <span></span>
      <span></span>
    </button>
    
    <ul class="nav-menu" id="navMenu">
      <li><a href="index.php" class="nav-link">Home</a></li>
      <li><a href="notes.php" class="nav-link">Notes</a></li>
      <li><a href="links.php" class="nav-link">Links</a></li>
      <li><a href="ytlinks.php" class="nav-link">YT Links</a></li>
       <li><a href="keep.php" class="nav-link">Keep</a></li>
     <li><a href="palbum.php" class="nav-link">Albums</a></li>
      <li><a href="reader.php" class="nav-link">Reader</a></li>


      
      <li>
        <button class="theme-toggle" id="themeToggle" aria-label="Toggle Dark Mode">
          <svg class="icon-moon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
          </svg>
          <svg class="icon-sun" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <circle cx="12" cy="12" r="5"/>
            <line x1="12" y1="1" x2="12" y2="3"/>
            <line x1="12" y1="21" x2="12" y2="23"/>
            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
            <line x1="1" y1="12" x2="3" y2="12"/>
            <line x1="21" y1="12" x2="23" y2="12"/>
            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
          </svg>
        </button>
      </li>
    </ul>
    
  </div>
</nav>

<div class="overlay" id="overlay"></div>

<script>
(function() {
  'use strict';
  
  const hamburger = document.getElementById('hamburger');
  const navMenu   = document.getElementById('navMenu');
  const overlay   = document.getElementById('overlay');
  const themeBtn  = document.getElementById('themeToggle');
  const html      = document.documentElement;
  
  function toggleMenu() {
    const isOpen = hamburger.classList.toggle('active');
    navMenu.classList.toggle('active');
    overlay.classList.toggle('active');
    hamburger.setAttribute('aria-expanded', isOpen);
    document.body.style.overflow = isOpen ? 'hidden' : '';
  }
  
  hamburger.addEventListener('click', toggleMenu);
  overlay.addEventListener('click', toggleMenu);
  
  document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', () => {
      if (navMenu.classList.contains('active')) toggleMenu();
    });
  });
  
  const storedTheme = localStorage.getItem('theme');
  const systemDark  = window.matchMedia('(prefers-color-scheme: dark)').matches;
  
  if (storedTheme) {
    html.setAttribute('data-theme', storedTheme);
  } else if (systemDark) {
    html.setAttribute('data-theme', 'dark');
  }
  
  themeBtn.addEventListener('click', () => {
    const current = html.getAttribute('data-theme');
    const next    = current === 'dark' ? 'light' : 'dark';
    html.setAttribute('data-theme', next);
    localStorage.setItem('theme', next);
  });
  
  const currentPath = window.location.pathname.split('/').pop() || 'index.php';
  document.querySelectorAll('.nav-link').forEach(link => {
    const href = link.getAttribute('href');
    if (href && href.includes(currentPath)) {
      document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
      link.classList.add('active');
    }
  });
  
})();
</script>