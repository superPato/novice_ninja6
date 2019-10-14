<?php 

namespace Ijdb\Controllers;

use \Ninja\DatabaseTable;

class Register
{
	private $authorsTable;

	public function __construct(DatabaseTable $authorsTable)
	{
		$this->authorsTable = $authorsTable;
	}

	public function list()
	{
		$authors = $this->authorsTable->findAll();

		return [
			'template'  => 'authorlist.html.php',
			'title'     => 'Author List',
			'variables' => compact('authors'),
		];
	}

	public function permissions()
	{
		$author = $this->authorsTable->findById($_GET['id']);

		$reflected = new \ReflectionClass('\Ijdb\Entity\Author');
		$constants = $reflected->getConstants();

		return [
			'template'  => 'permissions.html.php',
			'title'     => 'Edit Permissions',
			'variables' => [
				'author'      => $author,
				'permissions' => $constants,
			]
		];
	}

	public function savePermissions()
	{
		$author = [
			'id' => $_GET['id'],
			'permissions' => array_sum($_POST['permissions'] ?? [])
		];

		$this->authorsTable->save($author);

		header('location: /author/list');
	}

	public function registerUser()
	{
		$author = $_POST['author'];

		// Assume the data is valid to begin with
		$valid = true;
		$errors = [];

		// But if any of the fields have been left blank
		// set $valid to false
		if (empty($author['name'])) {
			$valid = false;
			$errors[] = 'Name cannot be blank';
		}

		if (empty($author['email'])) {
			$errors[] = 'Email cannot be blank';
			$valid = false;
		} elseif (filter_var($author['email'], FILTER_VALIDATE_EMAIL) == false) {
			$valid = false;
			$errors[] = 'Invalid email address';
		} else { // If the eamil is not blank and valid
			$author['email'] = strtolower($author['email']);

			// Search for the lowercase version fo $author['email']
			if (count($this->authorsTable->find('email', $author['email'])) > 0) {
				$valid = 0;
				$errors[] = 'That email address is already registered.';
			}
		}

		if (empty($author['password'])) {
			$valid = false;
			$errors[] = 'Password cannot be blank';
		}

		// If $valid is still true, no fields were blank
		// and the data can be added
		if ($valid == true) {
			// Hash the password before saving in the database
			$author['password'] = password_hash($author['password'], PASSWORD_DEFAULT);
			
			$this->authorsTable->save($author);

			header('Location: /author/success');
		} else {
			return [
				'template'  => 'register.html.php',
				'title'     => 'Register an account',
				'variables' => [
					'errors' => $errors,
					'author' => $author
				]
			];
		}
	}

	public function registrationForm()
	{
		return [
			'template' => 'register.html.php',
			'title'    => 'Register an account'
		];
	}

	public function success()
	{
		return [
			'template' => 'registersuccess.html.php',
			'title'    => 'Registration Successful'
		];
	}
}