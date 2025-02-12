<?php
// Подключение к базе данных
require_once 'db.php';
$pdo = require 'db.php';

try {
    // Загрузка записей
    $postsUrl = 'https://jsonplaceholder.typicode.com/posts';
    $postsData = json_decode(file_get_contents($postsUrl), true);

    $insertPostStmt = $pdo->prepare("INSERT INTO posts (id, user_id, title, body) VALUES (:id, :user_id, :title, :body)");

    $postCount = 0;
    foreach ($postsData as $post) {
        $insertPostStmt->execute([
            ':id' => $post['id'],
            ':user_id' => $post['userId'],
            ':title' => $post['title'],
            ':body' => $post['body']
        ]);
        $postCount++;
    }

    // Загрузка комментариев
    $commentsUrl = 'https://jsonplaceholder.typicode.com/comments';
    $commentsData = json_decode(file_get_contents($commentsUrl), true);

    $insertCommentStmt = $pdo->prepare("INSERT INTO comments (id, post_id, name, email, body) VALUES (:id, :post_id, :name, :email, :body)");

    $commentCount = 0;
    foreach ($commentsData as $comment) {
        $insertCommentStmt->execute([
            ':id' => $comment['id'],
            ':post_id' => $comment['postId'],
            ':name' => $comment['name'],
            ':email' => $comment['email'],
            ':body' => $comment['body']
        ]);
        $commentCount++;
    }

    // Вывод статистики
    echo "Загружено $postCount записей и $commentCount комментариев\n";

} catch (PDOException $e) {
    die("Ошибка при работе с базой данных: " . $e->getMessage());
}