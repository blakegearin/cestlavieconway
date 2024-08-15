<!DOCTYPE html>
<html>
  <head>
    <title>C'est la Vie, Conway</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico"/>
    <link rel="stylesheet" href="styles/style.php">
    <link rel="stylesheet" href="styles/fonts.css" type="text/css" charset="utf-8" />
    <link rel="stylesheet" href="https://use.typekit.net/kqq2sfs.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Simulator of Conway's Game of Life, a 'zero-player game.'">
  </head>
  <body>
    <div id="outer-wrapper">
      <div id="bg-overlay"></div>
    </div>
    <nav>
      <div id="title">
        C'est la Vie, Conway
      </div>
    </nav>
    <main>
      <?php
        include("php/home.php");
      ?>
    </main>
    <footer class="container-fluid w-100 py-3">
      <div class="center">
        <small class="text-muted">
          Copyright © 2021–<?php echo date("Y");?>  <a href="https://blakegearin.com">Blake Gearin</a>
        </small>
      </div>
    </footer>

    <script src="scripts/jquery-3.6.0.min.js"></script>
    <script src="scripts/index.js"></script>
  </body>
</html>
