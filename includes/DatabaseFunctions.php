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

function insertJoke($pdo, $joketext, $authorId)
{
	$query = 'INSERT INTO `joke` (`joketext`, `jokedate`, `authorid`) 
		VALUES (:joketext, CURDATE(), :authorid)';
	$parameters = [':joketext' => $joketext, ':authorid' => $authorId];

	query($pdo, $query, $parameters);
}

function updateJoke($pdo, $jokeId, $joketext, $authorId) 
{
	$parameters = [
		':joketext' => $joketext, 
		':authorid' => $authorId, 
		':id'	    => $jokeId   
	];
	query($pdo, 'UPDATE `joke` SET `authorid` = :authorid, `joketext` = :joketext WHERE `id` = :id', $parameters);
} 

function deleteJoke($pdo, $id)
{
	$parameters = [':id' => $id];

	query($pdo, 'DELETE FROM `joke` WHERE `id` = :id', $parameters);
}