<?php

require_once(__DIR__ . '/db_config.php');
$config = $db_config;

$articles = get_db_content();
$id = 0;

function get_db_content()
{
    // get content from database

    $connection = mysqli_connect($GLOBALS['config']['server'], $GLOBALS['config']['login'], $GLOBALS['config']['password'], $GLOBALS['config']['database']);
    if (!$connection) {
        throw new Exception('Could not connect');
    }

    $query = "SELECT * FROM articles";
    $articles = [];

    if ($result = mysqli_query($connection, $query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $articles[$row['id']] = $row;
        }
    }

    mysqli_close($connection);
    return $articles;
}

function update_db($name, $content, $id)
{
    $connection = mysqli_connect($GLOBALS['config']['server'], $GLOBALS['config']['login'], $GLOBALS['config']['password'], $GLOBALS['config']['database']);
    if (!$connection) {
        throw new Exception('Could not connect');
    }

    $query = "UPDATE articles SET name=?, content=? WHERE id=?";
    $result = mysqli_prepare($connection, $query);
    $result->bind_param("ssi", $name, $content, $id);
    $result->execute();

    $GLOBALS['articles'] = get_db_content();

    mysqli_close($connection);
}

function get_name()
{
    return $GLOBALS['articles'][$GLOBALS['id']]['name'];
}

function get_content()
{
    return $GLOBALS['articles'][$GLOBALS['id']]['content'];
}

function checkPath($article_num)
{
    if (!isset($_REQUEST['page'])) {
        return false;
    }

    if ($_REQUEST['page'] != "articles") {
        $page = explode('/', $_REQUEST['page']);
        if (($page[0] != "article-edit" && $page[0] != "article") ||
            intval($page[1]) < 0 || intval($page[1]) > $article_num
        ) {
            return false;
        }
    }
    return true;
}

function get_correct_URL($key = "", $option = "")
{
    $prefix = "/~31140072/cms/article";
    switch ($option) {
        case 'show':
            return "$prefix/$key";
        case 'edit':
            return "$prefix-edit/$key";
        default:
            return $prefix . "s";
    }
}

function main($articles)
{
    if (!checkPath(sizeof($articles))) {
        http_response_code(404);
        return;
    }

    $page = explode('/', $_REQUEST['page']);

    if (sizeof($page) != 1) {
        // save current id
        $GLOBALS['id'] = $page[1];
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['save'])) {
            update_db($_POST['articleName'], $_POST['articleContent'], $_POST['articleId']);
            require_once(__DIR__ . "/templates/articles/articles.php");
        }
    } else {
        try {
            require_once(__DIR__ . "/templates/$page[0]/$page[0].php");
        } catch (Exception $ex) {
            http_response_code(404);
            return;
        }
    }
}

main($articles);
