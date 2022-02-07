<?php 
function get_correct_URL($key,$option)
{
  $prefix = "/~31140072/cms/article";
  switch ($option)
  {
    case 'show':
      return $prefix . "/$key";
    case 'edit':
      return $prefix . "-edit/$key";
    case 'delete':
      return $prefix . "s/$key";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./templates/articles/articleList.css">
  <title>Document</title>
</head>
<body>
  <div class="container">
    <div class="articles">
      <h2>Article list</h2>
      <table class="table">
        <tbody>
          <?php foreach ($GLOBALS['articles'] as $key => $value) { ?>
            <tr>
              <td class="name"><?php echo $value['name']; ?></td>
              <td><a class="show" href=<?php echo get_correct_URL($key,'show'); ?>> Show</a></td>
              <td><a class="edit" href=<?php echo get_correct_URL($key,'edit'); ?>> Edit</a></td>
              <td><a class="delete" href=<?php echo get_correct_URL($key,'delete'); ?>> Delete</a></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>