<?php
$host='localhost';$db='sobhanan_notepad';$user='sobhanan_notepad';$pass='metta200' ;
$pdo=new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4",$user,$pass,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
?>