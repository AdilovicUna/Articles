<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../templates/article/article.css">
    <link rel="stylesheet" href="../common.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <h1><?php echo get_name() ?></h1>
        <div class="article">
            <p1 id="content"><?php echo get_content() ?></p2>
        </div>
        <div class="buttons">
            <div class="button" id="edit"><a href=<?php echo get_correct_URL($GLOBALS['id'],"edit"); ?>>Edit</a></div>
            <div class="button" id="back"><a href=<?php echo get_correct_URL(); ?>>Back to articles</a></div>
        </div>
    </div>
</body>

</html>