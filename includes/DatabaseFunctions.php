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

function insertJoke($pdo, $joketext, $authorId)
{
	$query = 'INSERT INTO `joke` (`joketext`, `jokedate`, `authorid`) 
		VALUES (:joketext, CURDATE(), :authorid)';
	$parameters = [':joketext' => $joketext, ':authorid' => $authorId];

	query($pdo, $query, $parameters);
}

