<?php

require_once(__DIR__ . '/db_config.php');
$config = $db_config;

$articles = get_db_article_content();
$tags = get_all_tags_content();
$id = 0;

function get_db_article_content()
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

function get_all_tags_content()
{
    // get content from database
    $connection = mysqli_connect($GLOBALS['config']['server'], $GLOBALS['config']['login'], $GLOBALS['config']['password'], $GLOBALS['config']['database']);
    if (!$connection) {
        throw new Exception('Could not connect');
    }

    $query = "SELECT * FROM articles";
    $tags = [];

    if ($result = mysqli_query($connection, $query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $tags[$row['tag']] = [];
        }
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($tags[$row['tag']], $row['id']);
        }
    }

    mysqli_close($connection);
    return $tags;
}

function update_articles($tag)
{
    // get content from database
    $connection = mysqli_connect($GLOBALS['config']['server'], $GLOBALS['config']['login'], $GLOBALS['config']['password'], $GLOBALS['config']['database']);
    if (!$connection) {
        throw new Exception('Could not connect');
    }

    $query = "SELECT * FROM articles WHERE tag=?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("s", $tag);
    $stmt->execute();

    $articles = [];

    if ($result = $stmt->get_result()) {
        while ($row = mysqli_fetch_assoc($result)) {
            $articles[$row['id']] = $row;
        }
    }

    mysqli_close($connection);
    return $articles;
}

function update()
{
    $GLOBALS['articles'] = get_db_article_content();
    $GLOBALS['tags'] = get_all_tags_content();
}

function update_db($name, $content, $id, $tag)
{
    $connection = mysqli_connect($GLOBALS['config']['server'], $GLOBALS['config']['login'], $GLOBALS['config']['password'], $GLOBALS['config']['database']);
    if (!$connection) {
        throw new Exception('Could not connect');
    }

    $query = "UPDATE articles SET name=?, content=? , tag=? WHERE id=?";
    $result = mysqli_prepare($connection, $query);
    $result->bind_param("sssi", $name, $content, $tag, $id);
    $result->execute();

    update();

    mysqli_close($connection);
}

function insert_to_db($name)
{
    $connection = mysqli_connect($GLOBALS['config']['server'], $GLOBALS['config']['login'], $GLOBALS['config']['password'], $GLOBALS['config']['database']);
    if (!$connection) {
        throw new Exception('Could not connect');
    }

    $query = "INSERT INTO articles (name) VALUES (?)";
    $result = mysqli_prepare($connection, $query);
    $result->bind_param("s", $name);
    $result->execute();

    update();

    mysqli_close($connection);
}

function delete_from_db($id)
{
    $connection = mysqli_connect($GLOBALS['config']['server'], $GLOBALS['config']['login'], $GLOBALS['config']['password'], $GLOBALS['config']['database']);
    if (!$connection) {
        throw new Exception('Could not connect');
    }

    $query = "DELETE FROM articles WHERE id=?";
    $result = mysqli_prepare($connection, $query);
    $result->bind_param("i", $id);
    $result->execute();

    update();

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

function get_tag()
{
    return $GLOBALS['articles'][$GLOBALS['id']]['tag'];
}

function get_id($name)
{
    $result = 0;
    foreach ($GLOBALS['articles'] as $key => $value) {
        if ($value['name'] == $name) {
            $result = $value['id'];
            break;
        }
    }
    return $result;
}

function checkPath($article_num)
{
    if (!isset($_REQUEST['page'])) {
        return false;
    }

    if ($_REQUEST['page'] != "articles") {
        $page = explode('/', $_REQUEST['page']);
        if (($page[0] != "article-edit" && $page[0] != "article") ||
            intval($page[1]) < 0 || !array_key_exists($page[1], $GLOBALS['articles'])
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
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['save'])) {
            update_db($_POST['articleName'], $_POST['articleContent'], $_POST['articleId'], $_POST['articleTag']);
            header('Location: ./articles', TRUE, 302);
        } else if (isset($_POST['create'])) {
            $name = $_POST['newName'];
            insert_to_db($name);
            header('Location: ./article-edit/' . get_id($name), TRUE, 302);
        } else if (isset($_POST['all_tags'])) {
            update_articles($_POST['all_tags']);
            header('Location: ./articles', TRUE, 302);
        }
    } else {
        $temp = explode('/', $_GET['page']);

        if ($temp[0] == 'delete') {
            delete_from_db($temp[1]);
            echo json_encode($GLOBALS['articles']);
            return true;
        }

        if (!checkPath(sizeof($articles))) {
            http_response_code(404);
            return;
        }

        $page = explode('/', $_REQUEST['page']);

        if (sizeof($page) != 1) {
            // save current id
            $GLOBALS['id'] = $page[1];
        }

        try {
            require_once(__DIR__ . "/templates/$page[0]/$page[0].php");
        } catch (Exception $ex) {
            http_response_code(404);
            return;
        }
    }
}

main($articles);
