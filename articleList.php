<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="articleList.css">
  <title>Document</title>
</head>
<body>
  <div class="container">
    <div class="articles">
        <h2>Article list</h2>
        <table class="table">
          <tbody>
            <?php foreach($articles as $article) { ?>
                <td class="name"><?php echo $article['name'];?></td>
                <td class="show">Show</td>
                <td class="edit">Edit</td>
                <td class="delete">Delete</td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
    </div>
  </div>
</body>
</html>