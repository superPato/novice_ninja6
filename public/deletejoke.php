<?php

try {
    include __DIR__ . '/../includes/DatabaseConnection.php';
    include __DIR__ . '/../classes/DatabaseTable.php';

    $jokesTable = new DatabaseTable($pdo, 'joke', 'id');
    
    $jokesTable->delete($_POST['id']);

    header('location: jokes.php');
} catch (PDOException $e) {
    $title = 'An error has ocurred';

    $output = sprintf("Unable to connect to the database server: %s in %s:%s",
        $e->getMessage(),
        $e->getFile(),
        $e->getLine()
    );
}

include __DIR__ . '/../templates/layout.html.php';
