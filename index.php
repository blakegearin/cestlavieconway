<!DOCTYPE html>
<html>
  <head>
    <title>C'est la Vie, Conway</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico"/>
    <link rel="stylesheet" href="styles/style.php">
    <link rel="stylesheet" href="styles/fonts.css" type="text/css" charset="utf-8" />
  </head>
  <body>
    <main>
      <?php
        include("php/generate_board.php");
      ?>
    </main>
    <script src="scripts/jquery-3.6.0.min.js"></script>
    <script src="scripts/index.js"></script>
  </body>
</html>
