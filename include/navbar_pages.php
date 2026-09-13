<nav class="navbar">
    <div class="container nav-inner">
 
	<a href="../../index.php" class="card-link">
	<div class="logo">
            <div class="logo-mark"><img src="../../images/lotus.svg" alt="Sobhana Net"></div>
            <div>
                <div class="logo-title">SobhanaNet</div>
                <p class="logo-sub">An Audio-Visual Library of Theravada Buddhism</p>
            </div>
        </div>
	</a>

<?php include '../../include/navbar_desktop_items.php'; ?>
 

        <div class="nav-actions">
            <button class="icon-btn" onclick="toggleSearch()" aria-label="Search">⌕</button>
            <button id="theme-btn" class="theme-btn" onclick="toggleTheme()" aria-label="Switch to dark mode" title="Switch to dark mode">
                <span id="theme-icon">🌙</span>
				<!-- <span class="theme-label">Theme</span> --> </button>
          
              <!-- <a href="#" class="membership-btn">JOIN MEMBERSHIP</a>   -->
            <button id="mobile-menu-btn" class="menu-btn" aria-label="Open menu" aria-expanded="false">☰</button>
       
		</div>
    </div>

<?php include '../../include/navbar_mobile_items.php'; ?>
    
</nav>

<?php include '../../include/search_overlay.php'; ?>