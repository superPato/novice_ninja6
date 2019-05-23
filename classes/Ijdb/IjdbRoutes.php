<?php

namespace Ijdb;

use Ninja\DatabaseTable;
use Ninja\Authentication;
use Ijdb\Controllers\Joke;
use Ijdb\Controllers\Login;
use Ijdb\Controllers\Register;

class IjdbRoutes implements \Ninja\Routes
{
    private $authorsTable;
    private $jokesTable;
    private $authentication;

    public function __construct()
    {
        include __DIR__ . '/../../includes/DatabaseConnection.php';

        $this->jokesTable     = new DatabaseTable($pdo, 'joke', 'id');
        $this->authorsTable   = new DatabaseTable($pdo, 'author', 'id');
        $this->authentication = new Authentication($this->authorsTable, 'email', 'password');
    }

	public function getRoutes(): array
	{
        $jokeController   = new Joke($this->jokesTable, $this->authorsTable);
        $authorController = new Register($this->authorsTable);
        $loginController  = new Login($this->authentication);

        $routes = [
            'author/register' => [
                'GET' => [
                    'controller' => $authorController,
                    'action'     => 'registrationForm'
                ],
                'POST' => [
                    'controller' => $authorController,
                    'action'     => 'registerUser'
                ],
            ],
            'author/success' => [
                'GET' => [
                    'controller' => $authorController,
                    'action'     => 'success'
                ]
            ],
            'joke/edit' => [
                'POST' => [
                    'controller' => $jokeController,
                    'action'     => 'saveEdit'
                ],
                'GET' => [
                    'controller' => $jokeController,
                    'action'     => 'edit'
                ],
                'login' => true
            ],
            'joke/delete' => [
                'POST' => [
                    'controller' => $jokeController,
                    'action'     => 'delete'
                ],
                'login' => true
            ],
            'joke/list' => [
                'GET' => [
                    'controller' => $jokeController,
                    'action'     => 'list'
                ]
            ],
            '' => [
                'GET' => [
                    'controller' => $jokeController,
                    'action'     => 'home'
                ]
            ],
            'login' => [
                'GET' => [
                    'controller' => $loginController,
                    'action'     => 'loginForm'
                ],
                'POST' => [
                    'controller' => $loginController,
                    'action'     => 'processLogin'
                ]
            ],
            'logout' => [
                'GET' => [
                    'controller' => $loginController,
                    'action'     => 'logout'
                ]
            ],
            'login/success' => [
                'GET' => [
                    'controller' => $loginController,
                    'action'     => 'success'
                ],
                'login' => true
            ],
            'login/error' => [
                'GET' => [
                    'controller' => $loginController,
                    'action'     => 'error'
                ]
            ],
        ];

        return $routes;
	}

    public function getAuthentication(): Authentication
    {
        return $this->authentication;
    }
}