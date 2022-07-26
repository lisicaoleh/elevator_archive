<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

session_start();

$dsn = 'mysql:host=localhost;dbname=elevator';
try {
    $pdo = new PDO($dsn, "root", "");
} catch (PDOException $e) {
    echo "Ошибка подключения: ".$e->getMessage();
}
