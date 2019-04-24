<?php

use Ninja\EntryPoint;
use Ijdb\IjdbRoutes;

try {
    include __DIR__ . '/../includes/autoload.php';

    $route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');

    $entryPoint = new EntryPoint($route, $_SERVER['REQUEST_METHOD'], new IjdbRoutes());
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
