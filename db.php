<?php
// Настройки подключения к базе данных
$host = 'localhost';
$dbname = 'blog';
$username = 'root';
$password = '';

try {
    // Создание подключения
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Возвращаем объект подключения
    return $pdo;
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}