<?php
require_once 'db_config.php';


if (!isset($_GET['id'])) {
    die("Invalid request");
}

$id = (int)$_GET['id'];

/* Fetch existing record */
$stmt = $pdo->prepare("SELECT * FROM Talk_list2 WHERE id = ?");
$stmt->execute([$id]);
$talk = $stmt->fetch();

if (!$talk) {
    die("Record not found");
}

/* Update record */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $sql = "UPDATE Talk_list2 SET
        file_number = ?,
        length = ?,
        talk = ?,
        list = ?,
        author = ?,
        title = ?,
        youtube = ?,
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
        $_POST['length'] ?? '',
        $_POST['talk'] ?? '',
        $_POST['list'] ?? '',
        $_POST['author'] ?? '',
        $_POST['title'] ?? '',
        $_POST['youtube'] ?? '',
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
<title>Edit Talk</title>
<link rel="stylesheet" href="css/style.css">


<?php include 'include/formats.php'; ?>
</head>
<body>
 <?php include 'include/header.php'; ?>
    <?php include 'include/menu.php'; ?>
	

<div class="card">
<h2>Edit Talk</h2>

<form method="post">

<label>File Number</label>
<input type="text" name="file_number" value="<?= htmlspecialchars($talk['file_number'] ?? '') ?>" required>

<label>Length</label>
<input type="text" name="length" value="<?= htmlspecialchars($talk['length'] ?? '') ?>" required>

<label>Talk</label>
<input type="text" name="talk" value="<?= htmlspecialchars($talk['talk'] ?? '') ?>" required>

<label>List</label>
<input type="text" name="list" value="<?= htmlspecialchars($talk['list'] ?? '') ?>" required>

<label>Author</label>
<input type="text" name="author" value="<?= htmlspecialchars($talk['author'] ?? '') ?>" required>

<label>Title</label>
<input type="text" name="title" value="<?= htmlspecialchars($talk['title'] ?? '') ?>" required>

<label>YouTube ID</label>
<input type="text" name="youtube" value="<?= htmlspecialchars($talk['youtube'] ?? '') ?>">

<label>Year</label>
<input type="number" name="year" value="<?= htmlspecialchars($talk['year'] ?? '') ?>">

<label>Backed</label>
<input type="text" name="backed" value="<?= htmlspecialchars($talk['backed'] ?? '') ?>">

<label>Public</label>
<input type="text" name="public" value="<?= htmlspecialchars($talk['public'] ?? '') ?>">

<label>Audience</label>
<input type="text" name="audience" value="<?= htmlspecialchars($talk['audience'] ?? '') ?>">

<label>Language</label>
<input type="text" name="language" value="<?= htmlspecialchars($talk['language'] ?? '') ?>">

<label>Country</label>
<input type="text" name="country" value="<?= htmlspecialchars($talk['country'] ?? '') ?>">

<label>Translator</label>
<input type="text" name="translator" value="<?= htmlspecialchars($talk['translator'] ?? '') ?>">

<label>Notes</label>
<textarea name="notes"><?= htmlspecialchars($talk['notes'] ?? '') ?></textarea>

<button class="btn btn-primary" type="submit">Update</button>
<a href="index.php" class="back-link">Cancel</a>

</form>
</div>
<script>
<?php include 'js/menu.js'; ?>
</script>
</body>
</html>
