<?php

namespace Ijdb;

use Ninja\DatabaseTable;
use Ijdb\Controllers\Joke;

class IjdbRoutes 
{
	public function callAction($route)
	{
		include __DIR__ . '/../../includes/DatabaseConnection.php';
		
	    $jokesTable = new DatabaseTable($pdo, 'joke', 'id');
	    $authorsTable = new DatabaseTable($pdo, 'author', 'id');

	    if ($route === 'joke/list') {
            $controller = new Joke($jokesTable, $authorsTable);
            $page = $controller->list();
        } elseif ($route === '') {
            $controller = new Joke($jokesTable, $authorsTable);
            $page = $controller->home();
        } elseif ($route === 'joke/edit') {
            $controller = new Joke($jokesTable, $authorsTable);
            $page = $controller->edit();
        } elseif ($route === 'joke/delete') {
            $controller = new Joke($jokesTable, $authorsTable);
            $page = $controller->delete();
        } elseif ($route === 'register') {
            include __DIR__ . '/../classes/controllers/RegisterController.php';
            $controller = new RegisterController($authorsTable);
            $page = $controller->showForm();
        }

        return $page;
	}
}