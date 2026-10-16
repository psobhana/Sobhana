<?php
require_once 'db_config.php';

if (!isset($_GET['id'])) {
    die("Invalid request");
}

$id = (int)$_GET['id'];

/* Fetch existing record */
$stmt = $pdo->prepare("SELECT * FROM Pdf_list WHERE id = ?");
$stmt->execute([$id]);
$pdf = $stmt->fetch();

if (!$pdf) {
    die("Record not found");
}

/* Update record */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $sql = "UPDATE Pdf_list SET
        file_number = ?,
        talk_number = ?,
        list = ?,
        author = ?,
        title = ?,
        year = ?,
        backed = ?,
        public = ?,
        audience = ?,
        language = ?,
        country = ?,
        translator = ?,
        notes = ?
        WHERE id = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['file_number'] ?? '',
        $_POST['talk_number'] ?? '',
        $_POST['list'] ?? '',
        $_POST['author'] ?? '',
        $_POST['title'] ?? '',
        $_POST['year'] ?? '',
        $_POST['backed'] ?? '',
        $_POST['public'] ?? '',
        $_POST['audience'] ?? '',
        $_POST['language'] ?? '',
        $_POST['country'] ?? '',
        $_POST['translator'] ?? '',
        $_POST['notes'] ?? '',
        $id
    ]);

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit PDF</title>
<link rel="stylesheet" href="css/style.css">
<?php include 'include/formats.php'; ?>
</head>
<body>
 <?php include 'include/header.php'; ?>
    <?php include 'include/menu.php'; ?>
	
<div class="card">
<h2>Edit PDF</h2>
<form method="post">

<label>File Number</label>
<input type="text" name="file_number" value="<?= htmlspecialchars($pdf['file_number'] ?? '') ?>" required>

<label>Talk Number</label>
<input type="text" name="talk_number" value="<?= htmlspecialchars($pdf['talk_number'] ?? '') ?>">

<label>List</label>
<input type="text" name="list" value="<?= htmlspecialchars($pdf['list'] ?? '') ?>">

<label>Author</label>
<input type="text" name="author" value="<?= htmlspecialchars($pdf['author'] ?? '') ?>" required>

<label>Title</label>
<input type="text" name="title" value="<?= htmlspecialchars($pdf['title'] ?? '') ?>" required>

<label>Year</label>
<input type="number" name="year" value="<?= htmlspecialchars($pdf['year'] ?? '') ?>">

<label>Backed</label>
<input type="text" name="backed" value="<?= htmlspecialchars($pdf['backed'] ?? '') ?>">

<label>Public</label>
<input type="text" name="public" value="<?= htmlspecialchars($pdf['public'] ?? '') ?>">

<label>Audience</label>
<input type="text" name="audience" value="<?= htmlspecialchars($pdf['audience'] ?? '') ?>">

<label>Language</label>
<input type="text" name="language" value="<?= htmlspecialchars($pdf['language'] ?? '') ?>">

<label>Country</label>
<input type="text" name="country" value="<?= htmlspecialchars($pdf['country'] ?? '') ?>">

<label>Translator</label>
<input type="text" name="translator" value="<?= htmlspecialchars($pdf['translator'] ?? '') ?>">

<label>Notes</label>
<textarea name="notes"><?= htmlspecialchars($pdf['notes'] ?? '') ?></textarea>

<button class="btn btn-primary" type="submit">Update</button>
<a href="index.php" class="back-link">Cancel</a>
</form>
</div>
<script>
<?php include 'js/menu.js'; ?>
</script>
</body>
</html>