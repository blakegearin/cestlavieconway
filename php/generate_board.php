<?php
if (!session_id()) {
  session_start();
}
include("global.php");

if(isset($_SESSION["round"])) {
  $_SESSION['round'] = 1;
  $status = "start";

  GLOBAL $new_board;
  $new_board = array();

  GLOBAL $grid_size;
  $grid_size = 20;

  $html_board = "";

  for ($r = 0; $r < $grid_size; $r++) {
    $row = array();
    $columns = "";

    for ($c = 0; $c < $grid_size; $c++) {
      $value = mt_rand(0,1);
      $row[$c] = $value;

      $class = $value == 0 ? "dead" : "alive";
      $columns = $columns . "<td id='r{$r}c{$c}' class='{$class}'>{$value}</td>";
    }
    array_push($new_board, $row);
    $html_board .= "<tr>{$columns}</tr>";
  }

  $_SESSION["start_board"] = $new_board;
  $binary = convert_multi_array($new_board);
  $hex = binhex($binary);
  $hex_strings = str_split($hex, 25);
  $hex_string = nl2br(implode("\n", $hex_strings));

  $dead_color = "#FFFFFF";
  if (isset($_SESSION["dead_color"])) {
    $dead_color = $_SESSION["dead_color"];
  }

  $alive_color = "#000000";
  if (isset($_SESSION["alive_color"])) {
    $alive_color = $_SESSION["alive_color"];
  }

  $text_color = "rgba(127, 127, 127, 0)";
  if (isset($_SESSION["text_color"])) {
    $text_color = $_SESSION["text_color"];
  }

  echo "
  <h1>C'est La Vie, Conway</h1>

  <p>
    <div>
      <input type='color' id='dead-color' name='dead' value='{$dead_color}'>
      <label for='dead'>Dead</label>
    </div>
    <div>
      <input type='color' id='alive-color' name='alive' value='{$alive_color}'>
      <label for='alive'>Alive</label>
    </div>
    <div>
      <input type='color' id='text-color' name='text' value='{$text_color}'>
      <label for='alive'>Text</label>
    </div>
  </p>
  <p>
    <button id='go'>Go</button>
    <button id='stop' disabled>Stop</button>
    <button id='next'>Next</button>
    <button id='reset'>Reset</button>
    <button id='clear'>Clear</button>
  </p>
  <p id =>
    <label class='switch'>
      <input id='show-text' type='checkbox'>
      <span class='slider'></span>
    </label>
    <span>Show text</span>
  </p>
  <div class='flex-container'>
    <table id='myTable' class='center'>
    <tbody>
      {$html_board}
    </tbody>
    </table>
    <div style='display:inline-block;'>
      <p>
        Round: <span id='round'>1</span>
      </p>
      <p>
        Status: <span id='status'>Start</span>
      </p>
    </div>
    <p>
      Board ID:
      <br>
      <code id='hex'>
        {$hex_string}
      </code>
    </p>
  <div>
  ";
}
?>
