<?php

try {
    include __DIR__ . '/../includes/DatabaseConnection.php';
    include __DIR__ . '/../includes/DatabaseFunctions.php';

    $sql = 'SELECT `joke`.`id`, `joketext`, `name`, `email`
        FROM `joke` INNER JOIN `author`
            ON `authorid` = `author`.`id`';

    // print_r(getJoke($pdo, 1));
    // exit();

    $jokes = $pdo->query($sql);

    $title = 'Joke list';

    $totalJokes = totalJokes($pdo);

    // Start the buffer

    ob_start();

    // Include the template, The PHP code will be executed,
    // but the resulting HTML will be stored in the buffer
    // rather than sent to the browser

    include __DIR__ . '/../templates/jokes.html.php';

    // Read the contents fo the output buffer and store them
    // in the $output variable for use in layout.html.php

    $output = ob_get_clean();

} catch (PDOException $e) {
    $title = 'An error has ocurred';

    $output = sprintf('Database error: %s in %s:%s',
        $e->getMessage(),
        $e->getFile(),
        $e->getLine()
    );
}

include __DIR__ . '/../templates/layout.html.php';
