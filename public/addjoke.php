<?php

if (isset($_POST['joketext'])) {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=ijdb;charset=utf8', 'ijdb', 'ijdb');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = 'INSERT INTO `joke` SET 
            `joketext` = :joketext,
            `jokedate` = CURDATE()';

        // This sends the query to the MySQL server, asking it to prepare 
        // to run the query.
        // The prepare method returns a PDOStatement object
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':joketext', $_POST['joketext']);
        
        $stmt->execute();
        
        header('location: jokes.php');
    } catch (PDOException $e) {
        $title = 'An error has ocurred';

        $output = sprintf('Database error: %s in %s:%s',
            $e->getMessage(),
            $e->getFile(),
            $e->getLine()
        );
    }
} else {
    $title = 'Add a new joke';

    ob_start();
    include __DIR__ . '/../templates/addjoke.html.php';
    $output = ob_get_clean();
}

include __DIR__ . '/../templates/layout.html.php';