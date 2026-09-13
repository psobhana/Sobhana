<?php
require_once 'config_album.php';

$album_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $db->prepare("SELECT * FROM albums WHERE id = ?");
$stmt->execute(array($album_id));
$album = $stmt->fetch();

if (!$album) {
    die('Album not found.');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_photo'])) {
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['photo'];

        if ($file['size'] > MAX_FILE_SIZE) {
            $error = 'File too large. Max size: ' . (MAX_FILE_SIZE / 1024 / 1024) . 'MB';
        } elseif (strpos(ALLOWED_TYPES, $file['type']) === false) {
            $error = 'Invalid file type. Allowed: JPG, PNG, GIF';
        } else {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '_' . time() . '.' . strtolower($ext);
            $filepath = UPLOAD_DIR . $filename;

            if (move_uploaded_file($file['tmp_name'], $filepath)) {
                $title = isset($_POST['photo_title']) ? trim($_POST['photo_title']) : '';
                $description = isset($_POST['photo_description']) ? trim($_POST['photo_description']) : '';

                $stmt = $db->prepare("INSERT INTO photos (album_id, title, description, filename, original_name, file_size, mime_type) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute(array($album_id, $title, $description, $filename, $file['name'], $file['size'], $file['type']));

                header('Location: album.php?id=' . $album_id);
                exit;
            } else {
                $error = 'Failed to move uploaded file.';
            }
        }
    } else {
        $error = 'Upload error: ' . (isset($_FILES['photo']['error']) ? $_FILES['photo']['error'] : 'No file uploaded');
    }
}

$stmt = $db->prepare("SELECT * FROM photos WHERE album_id = ? ORDER BY uploaded_at DESC");
$stmt->execute(array($album_id));
$photos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="theme-color" content="#6366f1">
    <title><?php echo htmlspecialchars($album['title'], ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <?php require_once 'menubar.php'; ?>

    <main>
        <div class="album-section">
            <div class="page-header">
                <a href="palbum.php" class="back-link">&larr; Back to Albums</a>
                <h1><?php echo htmlspecialchars($album['title'], ENT_QUOTES, 'UTF-8'); ?></h1>
                <p><?php echo htmlspecialchars($album['description'], ENT_QUOTES, 'UTF-8'); ?></p>
            </div>

            <div class="content-card">
                <h2>Photos</h2>
                <?php if (count($photos) > 0): ?>
                    <div class="photos-grid">
                        <?php foreach ($photos as $photo): ?>
                            <div class="photo-card">
                                <a href="photo.php?id=<?php echo (int)$photo['id']; ?>">
                                    <img src="uploads/<?php echo htmlspecialchars($photo['filename'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($photo['title'], ENT_QUOTES, 'UTF-8'); ?>">
                                </a>
                                <div class="photo-info">
                                    <h4><?php echo htmlspecialchars($photo['title'] ? $photo['title'] : $photo['original_name'], ENT_QUOTES, 'UTF-8'); ?></h4>
                                    <p><?php echo htmlspecialchars($photo['description'], ENT_QUOTES, 'UTF-8'); ?></p>
                                    <div class="actions">
                                        <a href="download.php?id=<?php echo (int)$photo['id']; ?>" class="btn-small">Download</a>
                                        <a href="edit_photo.php?id=<?php echo (int)$photo['id']; ?>" class="btn-small">Edit</a>
                                        <a href="delete_photo.php?id=<?php echo (int)$photo['id']; ?>" class="btn-small btn-danger" onclick="return confirm('Delete this photo?');">Delete</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <p>No photos in this album yet.</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="content-card">
                <h2>Add Photo</h2>
                <?php if (!empty($error)): ?>
                    <div class="msg-alert"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
                <?php endif; ?>
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="photo_file">Photo</label>
                        <input type="file" id="photo_file" name="photo" accept="image/jpeg,image/png,image/gif" required class="input-field">
                        <small>Max size: <?php echo (MAX_FILE_SIZE / 1024 / 1024); ?>MB (JPG, PNG, GIF)</small>
                    </div>
                    <div class="form-group">
                        <label for="photo_title">Title</label>
                        <input type="text" id="photo_title" name="photo_title" maxlength="255" placeholder="Photo title (optional)" class="input-field">
                    </div>
                    <div class="form-group">
                        <label for="photo_desc">Description</label>
                        <textarea id="photo_desc" name="photo_description" rows="2" placeholder="Photo description (optional)" class="input-field"></textarea>
                    </div>
                    <button type="submit" name="upload_photo" class="btn-primary">Upload Photo</button>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars(SITE_TITLE, ENT_QUOTES, 'UTF-8'); ?>.</p>
    </footer>

</body>
</html>