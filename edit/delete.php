<?php
require_once 'db_config.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM Talk_list2 WHERE id=?");
$stmt->execute([$id]);

/* header("Location: index.php"); */
echo "Record deleted successfully.";