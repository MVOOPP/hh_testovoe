<?php
// Подключение к базе данных
require_once 'db.php';
$pdo = require 'db.php';

try {
    // Получение параметра запроса
    if (isset($_GET['query']) && strlen($_GET['query']) >= 3) {
        $query = $_GET['query'];

        // SQL-запрос для поиска записей по тексту комментария
        $stmt = $pdo->prepare("
            SELECT p.title, c.body
            FROM comments c
            JOIN posts p ON c.post_id = p.id
            WHERE c.body LIKE :query
        ");
        $stmt->execute([':query' => "%$query%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Вывод результатов
        if (count($results) > 0) {
            echo "<h2>Результаты поиска:</h2>";
            foreach ($results as $row) {
                echo "<p><strong>Заголовок записи:</strong> {$row['title']}</p>";
                echo "<p><strong>Комментарий:</strong> {$row['body']}</p>";
                echo "<hr>";
            }
        } else {
            echo "<p>Ничего не найдено.</p>";
        }
    } else {
        echo "<p>Введите минимум 3 символа для поиска.</p>";
    }

} catch (PDOException $e) {
    die("Ошибка при работе с базой данных: " . $e->getMessage());
}
?>