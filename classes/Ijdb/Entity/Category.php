<?php
namespace Ijdb\Entity;

use Ninja\DatabaseTable;

class Category
{
	public $id;
	public $name;
	private $jokesTable;
	private $jokeCategoriesTable;

	public function __construct(DatabaseTable $jokesTable, DatabaseTable $jokeCategoriesTable)
	{
		$this->jokesTable = $jokesTable;
		$this->jokeCategoriesTable = $jokeCategoriesTable;
	}

	public function getJokes()
	{
		$jokeCategories = $this->jokeCategoriesTable->find('categoryid', $this->id);

		$jokes = [];

		foreach ($jokeCategories as $jokeCategory) {
			$joke = $this->jokesTable->findById($jokeCategory->jokeid);

			if ($joke) {
				$jokes[] = $joke;
			}
		}

		return $jokes;
	}
}