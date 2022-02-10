<?php
function get_correct_URL($key, $option) {
  $prefix = "/~31140072/cms/article";
  switch ($option) {
    case 'show':
      return "$prefix/$key";
    case 'edit':
      return "$prefix-edit/$key";
    case 'delete':
      return $prefix . "s/";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./templates/articles/articles.css">
  <title>Document</title>
</head>

<body>
  <div class="container">
    <div class="articles">
      <h1>Article list</h1>
      <table id="table">
        <tbody>
          <?php foreach($GLOBALS['articles'] as $key => $value) {?>
            <tr>
              <td id="name"><?php echo $value['name'] ?></td>
              <td><a id="show" href=<?php echo get_correct_URL($key, 'show') ?>>Show</a></td>
              <td><a id="edit" href=<?php echo get_correct_URL($key, 'edit') ?>>Edit</a></td>
              <td><a id="delete" href=<?php echo get_correct_URL($key, 'delete') ?>>Delete</a></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      <button id="previous" type="button">Previous</button>
      <button id="next" type="button">Next</button>
      <button id="create" type="button">Create article</button>
    </div>

  </div>
</body>

</html>