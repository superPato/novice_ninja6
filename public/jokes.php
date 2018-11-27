<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=ijdb;charset=utf8', 'ijdb', 'ijdb');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT `joketext` FROM `joke`';
    $result = $pdo->query($sql);

    while($row = $result->fetch()) {
        $jokes[] = $row['joketext'];
    }

    $title = 'Joke list';

    $output = '';

    foreach ($jokes as $joke ) {
        $output .= '<blockquote>';
        $output .= '<p>';
        $output .= $joke;
        $output .= '</p>';
        $output .= '</blockquote>';
    }
} catch (PDOException $e) {
    $title = 'An error has ocurred';

    $output = sprintf('Database error: %s in %s:%s',
        $e->getMessage(),
        $e->getFile(),
        $e->getLine()
    );
}

include __DIR__ . '/../templates/layout.html.php';