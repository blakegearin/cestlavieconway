<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="styles/style.php">
  </head>
  <body>

  <h1>My <span style="text-decoration: line-through;">first</span> second PHP page</h1>

  <p>
    <button id="go">Go</button>
    <button id="reset">Reset</button>
    <div>
      <input type="color" id="dead" name="dead" value="#FFFFFF">
      <label for="dead">Dead</label>
    </div>

    <div>
        <input type="color" id="alive" name="alive" value="#000000">
        <label for="alive">Alive</label>
    </div>
  </p>
  <div class="flex-container">
    <table id="myTable">
      <tbody>
      <?php
        $grid_size = 20;
        for ($r = 0; $r < $grid_size; $r++) {
          $columns = "";

          for ($c = 0; $c < $grid_size; $c++) {
            // $button = "<button id='r{$r}c{$c}'>0</button>";
            $columns = $columns . "<td id='r{$r}c{$c}' class='dead'>0</td>";
          }
          echo "<tr>". $columns . "</tr>";
        }
      ?>
      </tbody>
    </table>
  <div>

  <script src="scripts/jquery-3.6.0.min.js"></script>
  <script src="scripts/ds.min.js"></script>
  <script src="scripts/index.js"></script>
  </body>
</html>
