<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./templates/articles/articles.css">
  <link rel="stylesheet" href="./common.css">
  <title>Document</title>
</head>

<body>
  <div class="container">
    <div id="showArticles">
      <h1>Article list</h1>
      <table id="table">
        <?php foreach ($GLOBALS['articles'] as $key => $value) { ?>
          <tr>
            <td id="name"><?php echo $value['name'] ?></td>
            <td><a id="show" href=<?php echo get_correct_URL($key, 'show') ?>>Show</a></td>
            <td><a id="edit" href=<?php echo get_correct_URL($key, 'edit') ?>>Edit</a></td>
            <td><a id="delete" href=<?php echo get_correct_URL($key) ?>>Delete</a></td>
          </tr>
        <?php } ?>
      </table>
      <button id="previous" type="button">Previous</button>
      <button id="next" type="button">Next</button>
      <p id="page"></p>
      <button id="createArticle" type="button">Create article</button>
    </div>
    <div id="newArticle" hidden>
      <form action="../cms/articles" method="POST">
        <label for="fname">Article Name</label><br>
        <textarea type="text" name="newName" rows="1" cols="32" maxlength="32" placeholder="Enter name.."></textarea><br><br>
        <input class="button" id="save" name="create" type="submit" value="Create">
      </form>
      <button class="button" id="back" type="button">Cancel</button>
    </div>
  </div>
  <script src="./templates/articles/articles.js"></script>
</body>

</html>