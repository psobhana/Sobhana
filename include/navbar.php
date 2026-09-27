<nav class="navbar">
    <div class="container2 nav-inner">
        
	<a href="index.php" class="card-link">
	<div class="logo">
            <div class="logo-mark"><img src="images/lotus.svg" alt="Sobhana Net"></div>
            <div>
                <div class="logo-title">SobhanaNet</div>
                <p class="logo-sub">Buddhist Library</p>
            </div>
        </div>
	</a>

<div class="desktop-nav">
            <a href="index.php" class="nav-link">Home</a>
            <a href="pages/main/english.php" class="nav-link">Eglish</a>
            <a href="pages/main/sinhala.php" class="nav-link">සිංහල</a>
            <a href="pages/main/chanting.php" class="nav-link">Chanting</a>
            <a href="#" class="nav-link">Links</a>
            <a href="#" class="nav-link">About</a>
</div>


        <div class="nav-actions">
            <button class="icon-btn" onclick="toggleSearch()" aria-label="Search">⌕</button>
            <button id="theme-btn" class="theme-btn" onclick="toggleTheme()" aria-label="Switch to dark mode" title="Switch to dark mode">
                <span id="theme-icon">🌙</span>
				<!-- <span class="theme-label">Theme</span> --> </button>
          
              <!-- <a href="#" class="membership-btn">JOIN MEMBERSHIP</a>   -->
            <button id="mobile-menu-btn" class="menu-btn" aria-label="Open menu" aria-expanded="false">☰</button>
       
		</div>
    </div>

   <div id="mobile-menu" class="mobile-menu">
        <div class="mobile-menu-inner">
            <a href="index.php">Home</a>
            <a href="pages/main/english.php">Eglish</a>
            <a href="pages/main/sinhala.php">සිංහල</a>
            <a href="pages/main/chanting.php">Chanting</a>
            <a href="#">Links</a>
            <a href="#">About</a>
            <!-- <a href="#" class="mobile-join">Join Lion’s Roar</a>  -->
        </div>
    </div>
 
</nav>

<?php include 'include/search_overlay.php'; ?>