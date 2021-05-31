<!DOCTYPE html>
<html>
  <head>
    <title>C'est la Vie, Conway</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico"/>
    <link rel="stylesheet" href="styles/style.php">
    <link rel="stylesheet" href="styles/fonts.css" type="text/css" charset="utf-8" />
    <link rel="stylesheet" href="https://use.typekit.net/kqq2sfs.css">
  </head>
  <body>
    <div id="outer-wrapper">
      <div id="bg-overlay"></div>
    </div>
      <main>
        <?php
          include("php/generate_board.php");
        ?>
      </main>
      <footer class="container-fluid w-100 py-3">
        <div class="center">
          <small class="text-muted">
            Copyright © <?php include("php/get_copyright.php");?> Blake Gearin
          </small>
        </div>
      </footer>

    <script src="scripts/jquery-3.6.0.min.js"></script>
    <script src="scripts/index.js"></script>
  </body>
</html>
