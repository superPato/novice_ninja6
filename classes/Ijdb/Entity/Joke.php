<?php
namespace Ijdb\Entity;

use Ninja\DatabaseTable;

class Joke {
	public $id;
	public $authorid;
	public $jokedate;
	public $joketext;
	private $authorsTable;
	private $author;
	private $jokeCategoriesTable;

	public function __construct(DatabaseTable $authorsTable, DatabaseTable $jokeCategoriesTable)
	{
		$this->authorsTable = $authorsTable;
		$this->jokeCategoriesTable = $jokeCategoriesTable;
	}

	public function getAuthor()
	{
	    if (empty($this->author)) {
            $this->author = $this->authorsTable->findById($this->authorid);
        }

	    return $this->author;
	}

    public function addCategory($categoryId)
    {
        $jokeCat = ['jokeid' => $this->id, 'categoryid' => $categoryId];

        $this->jokeCategoriesTable->save($jokeCat);
	}
}