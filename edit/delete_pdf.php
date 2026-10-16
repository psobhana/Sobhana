<?php
require_once 'db_config.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM Pdf_list WHERE id=?");
$stmt->execute([$id]);

/* header("Location: index.php"); */
echo "Record deleted successfully.";