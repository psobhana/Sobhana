<?php
require 'config_notes.php';
$r=$pdo->query("SELECT content FROM notes WHERE id=1")->fetch(PDO::FETCH_ASSOC);
echo $r?$r['content']:'';
?>