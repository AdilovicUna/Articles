<?php
// get content from database
require_once('db_config.php');

$connection = mysqli_connect($db_config['server'], $db_config['login'], $db_config['password'], $db_config['database']);
if (!$connection) {
    throw new Exception('Could not connect');
}

$query = "SELECT * FROM articles";
$articles = [];
$id = 1;
if ($result = mysqli_query($connection, $query)) {
    while ($row = mysqli_fetch_assoc($result)) {
       $articles[$id++] = $row;
    }
}

mysqli_close($connection);

// display articles
require_once('articleList.php');

