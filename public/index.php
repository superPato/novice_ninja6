<?php

try {
    include __DIR__ . '/../classes/EntryPoint.php';

    $route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');

    $entryPoint = new EntryPoint($route);
    $entryPoint->run();
} catch (PDOException $e) {
    $title = 'An error has ocurred';

    $output = sprintf(
		'Database error: %s in %s:%s',
		$e->getMessage(),
		$e->getFile(),
		$e->getLine()
	);
    include __DIR__ . '/../templates/layout.html.php';
}
