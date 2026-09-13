<?php
require 'config_notes.php';
$c=$_POST['content']??'';
$st=$pdo->prepare("UPDATE notes SET content=? WHERE id=1");
$st->execute([$c]);
echo 'OK';
?>