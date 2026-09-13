<?php
require_once 'config_album.php';

$photo_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $db->prepare("SELECT * FROM photos WHERE id = ?");
$stmt->execute(array($photo_id));
$photo = $stmt->fetch();

if (!$photo) {
    die('Photo not found.');
}

$filepath = UPLOAD_DIR . $photo['filename'];

if (!file_exists($filepath)) {
    die('File not found on server.');
}

// Set headers for download
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $photo['original_name'] . '"');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . $photo['file_size']);

ob_clean();
flush();
readfile($filepath);
exit;
?>
