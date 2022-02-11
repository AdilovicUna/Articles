<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../common.css">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div>
            <form action="../articles" method="POST">
                <div class="article">
                    <input type='hidden' name='articleId' value='<?php echo $GLOBALS['id']; ?>'/>

                    <label for="fname">Name</label><br>
                    <textarea type="text" name="articleName" rows="1" cols="32" maxlength="32" placeholder="Enter name.." required><?php echo htmlspecialchars(get_name()); ?></textarea><br><br>

                    <label for="fname">Content</label><br>
                    <textarea type="text" name="articleContent" rows="16" cols="64" maxlength="1024" placeholder="Write here.."><?php echo htmlspecialchars(get_content()); ?></textarea><br><br>

                    <label for="fname">Tags</label><br>
                    <input type="text" name="articleTag" rows="1" cols="32" minlength="1" placeholder="Enter a tag.." pattern="^([a-zA-Z0-9 ]+)$" value="<?php echo htmlspecialchars(get_tag()); ?> "></input><br><br>

                </div>
                <input class="button" id="save" name="save" type="submit" value="Save">
            </form>
            <div class="button" id="back"><a href=<?php echo get_correct_URL(); ?>>Back to articles</a></div>
        </div>
    </div>
</body>

</html>