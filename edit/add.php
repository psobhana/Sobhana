<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/db_config.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $sql = "INSERT INTO Talk_list2
    (file_number, length, talk, list, author, title, youtube, year,
     backed, public, audience, language, country, translator, notes)
    VALUES
    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $_POST['file_number'],
        $_POST['length'],
        $_POST['talk'],
        $_POST['list'],
        $_POST['author'],
        $_POST['title'],
        $_POST['youtube'] ?: null,
        $_POST['year'] ?: null,
        $_POST['backed'] ?: null,
        $_POST['public'] ?: null,
        $_POST['audience'] ?: null,
        $_POST['language'] ?: null,
        $_POST['country'] ?: null,
        $_POST['translator'] ?: null,
        $_POST['notes'] ?: null
    ]);

    header("Location: index.php");
    exit;
}
?>

<html>
<head>
<meta charset="UTF-8">
<title>Add Data</title>
<link rel="stylesheet" href="css/style.css">
 
<?php include 'include/formats.php'; ?>

</head>
<body>

<?php include 'include/header.php'; ?>
	
	<!-- Include the slide‑in menu -->
    <?php include 'include/menu.php'; ?>

<div class="card">
<h2> </h2>

<form method="post">

    <div>
        <label>File Number *</label>
        <input type="text" name="file_number" required>
    </div>

    <div>
        <label>Length *</label>
        <input type="text" name="length" required>
    </div>

    <div>
        <label>Talk *</label>
        <input type="text" name="talk" required>
    </div>

    <div>
        <label>List *</label>
        <input type="text" name="list" required>
    </div>

    <div>
        <label>Author *</label>
        <input type="text" name="author" required>
    </div>

    <div>
        <label>Title *</label>
        <input type="text" name="title" required>
    </div>

    <div>
        <label>YouTube ID</label>
        <input type="text" name="youtube" maxlength="11">
    </div>

    <div>
        <label>Year</label>
        <input type="number" name="year">
    </div>

    <div>
        <label>Backed</label>
        <input type="text" name="backed">
    </div>

    <div>
        <label>Public</label>
        <input type="text" name="public">
    </div>

    <div>
        <label>Audience</label>
        <input type="text" name="audience">
    </div>

    <div>
        <label>Language</label>
        <input type="text" name="language">
    </div>

    <div>
        <label>Country</label>
        <input type="text" name="country">
    </div>

    <div>
        <label>Translator</label>
        <input type="text" name="translator">
    </div>

    <div>
        <label>Notes</label>
        <textarea name="notes"></textarea>
    </div>

    <div style="margin-top:15px;">
        <button class="btn btn-primary" type="submit">Save</button>
        <a href="index.php">Cancel</a>
    </div>

</form>
</div>
<script>
<?php include 'js/menu.js'; ?>
</script>
</body>
</html>
<?php include 'footer.php'; ?>
