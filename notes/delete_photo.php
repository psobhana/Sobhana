<?php
require_once 'config_album.php';

$photo_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $db->prepare("SELECT * FROM photos WHERE id = ?");
$stmt->execute(array($photo_id));
$photo = $stmt->fetch();

if (!$photo) {
    die('Photo not found.');
}

$album_id = $photo['album_id'];

// Delete file
$filepath = UPLOAD_DIR . $photo['filename'];
if (file_exists($filepath)) {
    unlink($filepath);
}

// Delete record
$stmt = $db->prepare("DELETE FROM photos WHERE id = ?");
$stmt->execute(array($photo_id));

header('Location: album.php?id=' . $album_id);
exit;
?>
