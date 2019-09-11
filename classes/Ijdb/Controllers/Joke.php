<?php

namespace Ijdb\Controllers;

use \Ninja\Authentication;
use \Ninja\DatabaseTable;

class Joke {
    private $authentication;
    private $authorsTable;
    private $categoriesTable;
    private $jokesTable;

    public function __construct(DatabaseTable $jokesTable,
                                DatabaseTable $authorsTable,
                                DatabaseTable $categoriesTable,
                                Authentication $authentication)
    {
        $this->jokesTable = $jokesTable;
        $this->authorsTable = $authorsTable;
        $this->categoriesTable = $categoriesTable;
        $this->authentication = $authentication;
    }

    public function home()
    {
        $title = 'Internet Joke Database';

        return ['template' => 'home.html.php', 'title' => $title];
    }

    public function list()
    {
        $jokes = $this->jokesTable->findAll();

        $title = 'Joke list';

        $totalJokes = $this->jokesTable->total();

        $author = $this->authentication->getUser();

        return [
            'template' => 'jokes.html.php',
            'title' => $title,
            'variables' => [
                'totalJokes' => $totalJokes,
                'jokes' => $jokes,
                'userid' => $author->id ?? null,
                'categories' => $this->categoriesTable->findAll(),
            ]
        ];
    }

    public function delete()
    {
        $author = $this->authentication->getUser();
        $joke = $this->jokesTable->findById($_POST['id']);

        if ($joke['authorid'] != $author->id) {
            return;
        }

        $this->jokesTable->delete($_POST['id']);

        header('location: /joke/list');
    }

    public function saveEdit()
    {
        $author = $this->authentication->getUser();

        if (isset($_GET['id'])) {
            $joke = $this->jokesTable->findById($_GET['id']);

            if ($joke->authorid != $author->id) {
                return;
            }
        }

        $joke = $_POST['joke'];
        $joke['jokedate'] = new \DateTime();

        $jokeEntity = $author->addJoke($joke);

        foreach ($_POST['category'] as $categoryid) {
            $jokeEntity->addCategory($categoryid);
        }

        header('location: /joke/list');
    }

    public function edit()
    {
        $author = $this->authentication->getUser();
        $categories = $this->categoriesTable->findAll();

        if (isset($_GET['id'])) {
            $joke = $this->jokesTable->findById($_GET['id']);
        }

        $title = 'Edit joke';

        return [
            'template' => 'editjoke.html.php',
            'title' => $title,
            'variables' => [
                'joke' => $joke ?? null,
                'userid' => $author->id ?? null,
                'categories' => $categories
            ]
        ];
    }
}
