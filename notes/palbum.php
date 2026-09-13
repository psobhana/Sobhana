<?php
require_once 'config_album.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_album'])) {
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';

    if (!empty($title)) {
        $stmt = $db->prepare("INSERT INTO albums (title, description) VALUES (?, ?)");
        $stmt->execute(array($title, $description));
        header('Location: palbum.php');
        exit;
    }
}

$stmt = $db->query("SELECT * FROM albums ORDER BY created_at DESC");
$albums = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="theme-color" content="#6366f1">
    <title><?php echo htmlspecialchars(SITE_TITLE, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="styles.css">
    <link rel="shortcut icon" href="album.svg">
</head>
<body>

    <?php require_once 'menubar.php'; ?>

    <main>
        <div class="album-section">
            <div class="page-header">
                <h1>Albums</h1>
            </div>

            <div class="content-card">
                <h2>All Albums</h2>
                <?php if (count($albums) > 0): ?>
                    <div class="albums-grid">
                        <?php foreach ($albums as $album): ?>
                            <div class="album-card">
                                <h3>
                                    <a href="album.php?id=<?php echo (int)$album['id']; ?>">
                                        <?php echo htmlspecialchars($album['title'], ENT_QUOTES, 'UTF-8'); ?>
                                    </a>
                                </h3>
                                <p><?php echo htmlspecialchars($album['description'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <small><?php echo htmlspecialchars(date('F j, Y', strtotime($album['created_at'])), ENT_QUOTES, 'UTF-8'); ?></small>
                                <div class="actions">
                                    <a href="edit_album.php?id=<?php echo (int)$album['id']; ?>" class="btn-small">Edit</a>
                                    <a href="delete_album.php?id=<?php echo (int)$album['id']; ?>" class="btn-small btn-danger" onclick="return confirm('Delete this album and all its photos?');">Delete</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <p>No albums yet. Create one below!</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="content-card">
                <h2>Create New Album</h2>
                <form method="post" action="">
                    <div class="form-group">
                        <label for="album_title">Title</label>
                        <input type="text" id="album_title" name="title" required maxlength="255" placeholder="Enter album title" class="input-field">
                    </div>
                    <div class="form-group">
                        <label for="album_desc">Description</label>
                        <textarea id="album_desc" name="description" rows="3" placeholder="Enter album description (optional)" class="input-field"></textarea>
                    </div>
                    <button type="submit" name="create_album" class="btn-primary">Create Album</button>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars(SITE_TITLE, ENT_QUOTES, 'UTF-8'); ?>.</p>
    </footer>

</body>
</html>