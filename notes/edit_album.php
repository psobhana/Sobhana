<?php
require_once 'config_album.php';

$album_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $db->prepare("SELECT * FROM albums WHERE id = ?");
$stmt->execute(array($album_id));
$album = $stmt->fetch();

if (!$album) {
    die('Album not found.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';

    if (!empty($title)) {
        $stmt = $db->prepare("UPDATE albums SET title = ?, description = ? WHERE id = ?");
        $stmt->execute(array($title, $description, $album_id));
        header('Location: album.php?id=' . $album_id);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="theme-color" content="#6366f1">
    <title>Edit Album</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <?php require_once 'menubar.php'; ?>

    <main>
        <div class="album-section">
            <div class="page-header">
                <a href="album.php?id=<?php echo (int)$album_id; ?>" class="back-link">&larr; Back</a>
                <h1>Edit Album</h1>
            </div>

            <div class="content-card">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            value="<?php echo htmlspecialchars($album['title'], ENT_QUOTES, 'UTF-8'); ?>"
                            required
                            maxlength="255"
                            class="input-field"
                            placeholder="Album title"
                        >
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea
                            id="description"
                            name="description"
                            rows="3"
                            class="input-field"
                            placeholder="Album description (optional)"
                        ><?php echo htmlspecialchars($album['description'], ENT_QUOTES, 'UTF-8'); ?></textarea>
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