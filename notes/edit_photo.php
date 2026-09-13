<?php
require_once 'config_album.php';

$photo_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $db->prepare("SELECT p.*, a.id as album_id FROM photos p JOIN albums a ON p.album_id = a.id WHERE p.id = ?");
$stmt->execute(array($photo_id));
$photo = $stmt->fetch();

if (!$photo) {
    die('Photo not found.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';

    $stmt = $db->prepare("UPDATE photos SET title = ?, description = ? WHERE id = ?");
    $stmt->execute(array($title, $description, $photo_id));
    header('Location: photo.php?id=' . $photo_id);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="theme-color" content="#6366f1">
    <title>Edit Photo</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <?php require_once 'menubar.php'; ?>

    <main>
        <div class="album-section">
            <div class="page-header">
                <a href="photo.php?id=<?php echo (int)$photo_id; ?>" class="back-link">&larr; Back</a>
                <h1>Edit Photo</h1>
            </div>

            <div class="content-card">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            value="<?php echo htmlspecialchars($photo['title'], ENT_QUOTES, 'UTF-8'); ?>"
                            maxlength="255"
                            class="input-field"
                            placeholder="Photo title"
                        >
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea
                            id="description"
                            name="description"
                            rows="3"
                            class="input-field"
                            placeholder="Photo description (optional)"
                        ><?php echo htmlspecialchars($photo['description'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </div>
                    <button type="submit" class="btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars(SITE_TITLE, ENT_QUOTES, 'UTF-8'); ?>.</p>
    </footer>

</body>
</html>