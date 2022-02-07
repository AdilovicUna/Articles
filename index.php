<?php

$articles = get_db_content();
$id = 0;

function get_db_content()
{
    // get content from database
    require_once(__DIR__ . '/db_config.php');

    $connection = mysqli_connect($db_config['server'], $db_config['login'], $db_config['password'], $db_config['database']);
    if (!$connection) {
        throw new Exception('Could not connect');
    }

    $query = "SELECT * FROM articles";
    $id = 1;

    if ($result = mysqli_query($connection, $query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $articles[$id++] = $row;
        }
    }

    mysqli_close($connection);
    return $articles;
}

function checkPath($article_num)
{
    if(!isset($_REQUEST['page']))
    {
        return false;
    }

    if($_REQUEST['page'] != "articles")
    {
        $page = explode('/', $_REQUEST['page']);
        if(($page[0] != "article-edit" && $page[0] != "article") ||
            intval($page[1]) < 0 || intval($page[1]) > $article_num)
        {
            return false;
        }
    }
    return true;
}

function main($articles)
{
    if(!checkPath(sizeof($articles)))
    {
        http_response_code(404);
        return;
    }

    $page = explode('/', $_REQUEST['page']);

    if($page[0] != "articles")
    {
        // save current id
        $GLOBALS['id'] = $page[1];
    }
    
    try
    {
        require_once(__DIR__ . "/templates/$page[0]/view.php");
    }
    catch(Exception $ex)
    {
        http_response_code(404);
        return;
    }
}

main($articles);
