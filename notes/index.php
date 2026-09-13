<?php
/**
 * Main Landing Page
 */
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Notes and Album">
  <title>Notes</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="shortcut icon" href="notes.svg">
</head>
<body>

  <?php require_once 'menubar.php'; ?>

  <main>
    <section class="hero">
      <a href="notes.php" class="btn-primary">Notes</a>
      <a href="links.php" class="btn-primary">Links</a>
      <a href="ytlinks.php" class="btn-primary">YT Links</a>	  
      <a href="keep.php" class="btn-primary">Keep</a>
      <a href="palbum.php" class="btn-primary">Albums</a>
      <a href="reader.php" class="btn-primary">Reader</a>	  
    </section>

    <section class="features" id="features">
    
    </section>
  </main>

  <footer>
   
  </footer>

</body>
</html>