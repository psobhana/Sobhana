<?php
require_once 'config_album.php';

$photo_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $db->prepare("SELECT p.*, a.title as album_title, a.id as album_id FROM photos p JOIN albums a ON p.album_id = a.id WHERE p.id = ?");
$stmt->execute(array($photo_id));
$photo = $stmt->fetch();

if (!$photo) {
    die('Photo not found.');
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="theme-color" content="#6366f1">
    <title><?php echo htmlspecialchars($photo['title'] ? $photo['title'] : $photo['original_name'], ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <?php require_once 'menubar.php'; ?>

    <main>
        <div class="album-section">
            <div class="page-header">
                <a href="album.php?id=<?php echo (int)$photo['album_id']; ?>" class="back-link">
                    &larr; Back to <?php echo htmlspecialchars($photo['album_title'], ENT_QUOTES, 'UTF-8'); ?>
                </a>
                <h1><?php echo htmlspecialchars($photo['title'] ? $photo['title'] : $photo['original_name'], ENT_QUOTES, 'UTF-8'); ?></h1>
                <p><?php echo htmlspecialchars($photo['description'], ENT_QUOTES, 'UTF-8'); ?></p>
            </div>

            <div class="content-card">
                <div class="photo-view">
                    <img src="uploads/<?php echo htmlspecialchars($photo['filename'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($photo['title'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="actions actions-center">
                    <a href="download.php?id=<?php echo (int)$photo['id']; ?>" class="btn">Download Photo</a>
                    <a href="edit_photo.php?id=<?php echo (int)$photo['id']; ?>" class="btn">Edit</a>
                    <a href="delete_photo.php?id=<?php echo (int)$photo['id']; ?>" class="btn btn-danger" onclick="return confirm('Delete this photo?');">Delete</a>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars(SITE_TITLE, ENT_QUOTES, 'UTF-8'); ?>.</p>
    </footer>

</body>
</html>