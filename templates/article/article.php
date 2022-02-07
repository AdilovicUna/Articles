<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../templates/article/article.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <h1><?php echo get_name() ?></h1>
        <div class="article">
            <p1 id="content"><?php echo get_content() ?></p2>
        </div>
        <div class="buttons">
            <button id="edit" type="button">Edit</button>
            <button id="back" type="button">Back to articles</button>
        </div>
    </div>
    <script>
        let edit = document.getElementById("edit");
        edit.addEventListener('click', event => editHandler())

        let back = document.getElementById("back");
        back.addEventListener('click', event => backHandler())

        function editHandler() {
            window.location.href = "../article-edit/<?php echo $GLOBALS['id'];?>";
        }

        function backHandler() {
            window.location.href = "../articles";
        }
    </script>
</body>

</html>