<?php
function inc_curr_page()
{
  $GLOBALS['curr_page']++;
}
function dec_curr_page()
{
  $GLOBALS['curr_page']--;
}
function get_article_names()
{
  // get names of the articles needed for display on the current page

  $start = ($GLOBALS['curr_page'] - 1) * 10 + 1;
  $result = [];
  for ($i = $start; $i < $start + 10; $i++) {
    if ($i > sizeof($GLOBALS['articles'])) {
      break;
    }
    $result[$i] = $GLOBALS['articles'][$i]['name'];
  }
  return $result;
}
?>

<script>
  function get_correct_URL(key, option) {
    let prefix = "/~31140072/cms/article";
    switch (option) {
      case 'show':
        return prefix + "/" + key;
      case 'edit':
        return prefix + "-edit/" + key;
      case 'delete':
        return prefix + "s/";
    }

  }

  function deleteRows() {
    // delete articles on the current page

    let table = document.getElementById("table");
    while (table.rows.length > 0) {
      table.deleteRow(0);
    }
  }

  function display_Articles() {
    // display articles on the current page

    let articles = <?php echo json_encode(get_article_names()); ?>;
    console.log(articles);
    let table = document.getElementById("table");

    for (let i = 0; i < Object.keys(articles).length; i++) {
      let id = Object.keys(articles)[i];
      let row = table.insertRow(i);

      let cell1 = row.insertCell(0);
      cell1.id = "name";
      cell1.innerHTML = articles[id];

      let cell2 = row.insertCell(1);
      cell2.innerHTML = "<a id=\"show\" href=" + get_correct_URL(id, 'show') + ">Show</a>";

      let cell3 = row.insertCell(2);
      cell3.innerHTML = "<a id=\"edit\" href=" + get_correct_URL(id, 'edit') + ">Edit</a>";

      let cell4 = row.insertCell(3);
      cell4.innerHTML = "<a id=\"delete\" href=" + get_correct_URL(id, 'delete') + ">Delete</a>";
    }
  }
</script>

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
          <script>
            display_Articles();
          </script>
        </tbody>
      </table>
      <button id="previous" type="button">Previous</button>
      <button id="next" type="button">Next</button>
      <p id="page">Page count <?php echo $GLOBALS['curr_page'] ?></p>
      <button id="create" type="button">Create article</button>
    </div>

  </div>
</body>

<script>
  // add event listeners to buttons
  let prev = document.getElementById("previous");
  prev.addEventListener('click', event => prevHandler());

  let next = document.getElementById("next");
  next.addEventListener('click', event => nextHandler());

  let createArticle = document.getElementById("create");
  createArticle.addEventListener('click', event => createArticleHandler());

  // create handlers
  let curr = <?php echo $GLOBALS['curr_page'] ?>;
  let total = <?php echo $GLOBALS['total_page'] ?>;

  function prevHandler() {
    deleteRows();
    display_Articles();
    <?php dec_curr_page(); ?>
  }

  function nextHandler() {
    deleteRows();
    display_Articles();
    <?php inc_curr_page(); ?>
    console.log(<?php echo $GLOBALS['curr_page'] ?>);
  }

  function createArticleHandler() {
    window.location.href = "../articles";
  }

  if (curr == 1) {
    next.style.display = "active";
    prev.style.display = "none";
  }
  else if (curr == total) {
    next.style.display = "none";
    prev.style.display = "active";
  }
  else{
    next.style.display = "active";
    prev.style.display = "active";
  }
</script>

</html>