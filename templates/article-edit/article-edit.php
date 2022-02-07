<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../templates/article-edit/article-edit.css">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div class="article">
            <label for="fname">Article Name</label><br>
            <textarea type="text" name="articleName" rows="1" cols="32" maxlength="32" placeholder="Enter name.."><?php echo get_name(); ?></textarea><br><br>

            <label for="fname">Content</label><br>
            <textarea type="text" name="content" rows="16" cols="64" maxlength="1024" placeholder="Write here.."><?php echo get_content(); ?></textarea><br>
        </div>
        <div class="buttons">
            <button id="save" type="button">Save</button>
            <button id="back" type="button">Back to articles</button>
        </div>
    </div>
    <script>
        let save = document.getElementById("save");
        save.addEventListener('click', event => saveHandler())

        let back = document.getElementById("back");
        back.addEventListener('click', event => backHandler())

        function saveHandler() {
            backHandler();
        }

        function backHandler() {
            window.location.href = "../articles";
        }
    </script>
</body>

</html>