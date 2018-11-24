<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=ijdb;charset=utf8', 'ijdb', 'ijdb');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT `joketext` FROM `joke`';

    $result = $pdo->query($sql);

    while($row = $result->fetch()) {
        $jokes[] = $row['joketext'];
    }
} catch (PDOException $e) {
    $error = sprintf(
        'Unable to connect to the database server: %s in %s:%s',
        $e->getMessage(),
        $e->getFile(),
        $e->getLine()
    );
}

include __DIR__ . '/../templates/output.html.php';