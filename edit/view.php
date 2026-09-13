<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/db_config.php';
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid ID.");
}
$id = (int) $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM Talk_list2 WHERE id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch();
if (!$row) {
    die("Record not found.");
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Talk Details</title>
<link rel="stylesheet" href="css/style.css">
<?php include 'include/formats.php'; ?>
</head>
<body>
   <?php include 'include/header.php'; ?>
   <?php include 'include/menu.php'; ?>
	
<h2> </h2>
<div class="details-card">
    <table class="details-table">
        <tr><th>ID</th><td><?= $row['id'] ?></td></tr>
        <tr><th>File Number</th><td><?= htmlspecialchars($row['file_number'] ?? '') ?></td></tr>
        <tr><th>Length</th><td><?= htmlspecialchars($row['length'] ?? '') ?></td></tr>
        <tr><th>Talk</th><td><?= htmlspecialchars($row['talk'] ?? '') ?></td></tr>
        <tr><th>List</th><td><?= htmlspecialchars($row['list'] ?? '') ?></td></tr>
        <tr><th>Author</th><td><?= htmlspecialchars($row['author'] ?? '') ?></td></tr>
        <tr><th>Title</th><td><?= htmlspecialchars($row['title'] ?? '') ?></td></tr>
        <tr><th>YouTube</th>
            <td>
                <?php if (!empty($row['youtube'])): ?>
                    <a target="_blank"
                       href="https://youtube.com/watch?v=<?= htmlspecialchars($row['youtube'] ?? '') ?>">
                       ▶ Watch on YouTube
                    </a>
                <?php endif; ?>
            </td>
        </tr>
        <tr><th>Year</th><td><?= htmlspecialchars($row['year'] ?? '') ?></td></tr>
        <tr><th>Backed</th><td><?= htmlspecialchars($row['backed'] ?? '') ?></td></tr>
        <tr><th>Public</th><td><?= htmlspecialchars($row['public'] ?? '') ?></td></tr>
        <tr><th>Audience</th><td><?= htmlspecialchars($row['audience'] ?? '') ?></td></tr>
        <tr><th>Language</th><td><?= htmlspecialchars($row['language'] ?? '') ?></td></tr>
        <tr><th>Country</th><td><?= htmlspecialchars($row['country'] ?? '') ?></td></tr>
        <tr><th>Translator</th><td><?= htmlspecialchars($row['translator'] ?? '') ?></td></tr>
        <tr><th>Notes</th><td><?= htmlspecialchars($row['notes'] ?? '') ?></td></tr>
    </table>
    <div>
        <a class="btn btn-primary" href="index.php">Back</a>
        <a class="btn btn-primary" href="edit.php?id=<?= $row['id'] ?>">Edit</a>
	<a class="btn btn-primary" href="javascript:void(0);" onclick="confirmDelete(<?= $row['id'] ?>)">Delete</a>
        
    </div>
</div>
<?php include 'footer.php'; ?>
<script>
<?php include 'js/menu.js'; ?>
function confirmDelete(id) {
    if (confirm("Are you sure you want to delete this record?")) {
        window.location = "delete.php?id=" + id;
    }
}
</script>
</body>
</html>
