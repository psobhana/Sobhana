<?php
require_once 'db_config.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['tsv_file'])) {

    if ($_FILES['tsv_file']['error'] === 0) {

        $file = $_FILES['tsv_file']['tmp_name'];
        $handle = fopen($file, "r");

        if ($handle !== false) {

            $pdo->beginTransaction();

            $insert = $pdo->prepare("
                INSERT INTO Pdf_list (
                    file_number, talk_number, list, author,
                    title, year, backed, public,
                    audience, language, country, translator, notes
                ) VALUES (
                    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
                )
            ");

            $rowCount = 0;
            $errorCount = 0;
            $firstRow = true;

            while (($rawLine = fgets($handle)) !== false) {

                // Remove only line breaks (NOT tabs)
                $rawLine = rtrim($rawLine, "\r\n");

                // Use explode WITHOUT trim()
                $line = explode("\t", $rawLine);

                // Skip header row
                if ($firstRow) {
                    $firstRow = false;
                    continue;
                }

                // Ensure at least 14 columns (id + 13 data fields)
                if (count($line) < 14) {
                    // pad missing columns with empty string
                    $line = array_pad($line, 14, '');
                }

                try {

                    $insert->execute([
                        trim($line[1]),  // file_number
                        trim($line[2]),  // talk_number 
                        trim($line[3]),  // list
                        trim($line[4]),  // author
                        trim($line[5]),  // title
                        is_numeric($line[6]) ? $line[6] : null, // year
                        trim($line[7]),  // backed
                        trim($line[8]), // public
                        trim($line[9]), // audience
                        trim($line[10]), // language
                        trim($line[11]), // country
                        trim($line[12]) !== '' ? trim($line[14]) : null, // translator
                        trim($line[13]) !== '' ? trim($line[15]) : null  // notes
                    ]);

                    $rowCount++;

                } catch (Exception $e) {
                    $errorCount++;
                }
            }

            fclose($handle);
            $pdo->commit();

            $message = "Imported: $rowCount rows. Errors: $errorCount";

        } else {
            $message = "Could not open file.";
        }

    } else {
        $message = "File upload error.";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Import TSV</title>
<link rel="stylesheet" href="css/style.css">
<?php include 'include/formats.php'; ?>
<style>
input[type=file] {
    margin-bottom: 15px;
}

.back-link {
    display: inline-block;
    margin-top: 15px;
}
</style>
</head>
<body>
  <?php include 'include/header.php'; ?>
   <?php include 'include/menu.php'; ?>

<div class="card">
    <h2>Import PDFs from TSV</h2>

    <form method="post" enctype="multipart/form-data">
        <input type="file" name="tsv_file" accept=".tsv" required>
        <br>
        <button type="submit" class="btn btn-primary">Upload & Import</button>
    </form>

    <?php if ($message): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <a href="index.php" class="back-link">← Back to List</a>
</div>
<script>
<?php include 'js/menu.js'; ?>
</script>
</body>
</html>