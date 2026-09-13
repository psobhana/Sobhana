<?php
require_once 'config_album.php';

$album_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $db->prepare("SELECT * FROM albums WHERE id = ?");
$stmt->execute(array($album_id));
$album = $stmt->fetch();

if (!$album) {
    die('Album not found.');
}

// Delete photo files first
$stmt = $db->prepare("SELECT filename FROM photos WHERE album_id = ?");
$stmt->execute(array($album_id));
$photos = $stmt->fetchAll();

foreach ($photos as $photo) {
    $filepath = UPLOAD_DIR . $photo['filename'];
    if (file_exists($filepath)) {
        unlink($filepath);
    }
}

// Delete album (cascade will delete photo records)
$stmt = $db->prepare("DELETE FROM albums WHERE id = ?");
$stmt->execute(array($album_id));

header('Location: index.php');
exit;
?>
