<?php

function query($pdo, $sql, $parameters = [])
{
	$query = $pdo->prepare($sql);
	$query->execute($parameters);

	return $query;
}

function totalJokes($pdo)
{
    $query = query($pdo, 'SELECT COUNT(*) FROM `joke`');
    $row = $query->fetch();

    return $row[0];
}

function getJoke($pdo, $id)
{
	// Create the array $parameters for use in the query function
	$parameters = [':id' => $id];
	$query = query($pdo, 'SELECT * FROM `joke` WHERE `id` = :id', $parameters);

	return $query->fetch();
}

function allJokes($pdo)
{
	$jokes = query($pdo, 'SELECT `joke`.`id`, `joketext`, `name`, `email`
        				  FROM `joke` INNER JOIN `author`
            				ON `authorid` = `author`.`id`');

	return $jokes->fetchAll();
}

function insertJoke($pdo, $fields)
{
	$query = 'INSERT INTO `joke` (';

	foreach ($fields as $key => $value) {
		$query .= '`' . $key . '`,';
	}

	$query = rtrim($query, ',');

	$query .= ') VALUES (';

	foreach ($fields as $key => $value) {
		$query .= ':' . $key . ',';
	}

	$query = rtrim($query, ',');

	$query .= ')';

	query($pdo, $query, $fields);
}

function updateJoke($pdo, $fields) 
{
	$query = 'UPDATE `joke` SET ';

	foreach ($fields as $key => $value) {
		$query .= '`' . $key . '` = :' . $key . ',';
	}

	$query = rtrim($query, ',');

	$query .= ' WHERE `id` = :primaryKey';

	// Set the :primaryKey variable
	$fields['primaryKey'] = $fields['id'];

	print_r($fields);
	die();

	query($pdo, $query, $fields);
} 

function deleteJoke($pdo, $id)
{
	$parameters = [':id' => $id];

	query($pdo, 'DELETE FROM `joke` WHERE `id` = :id', $parameters);
}