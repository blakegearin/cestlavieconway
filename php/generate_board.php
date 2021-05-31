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
      $value = (string) mt_rand(0,1);
      $row[$c] = $value;

      $class = $value == 0 ? "dead" : "alive";
      $columns = $columns .
        "<td class='table-border-color'>
          <div id='r{$r}c{$c}' class='{$class} content'>
            {$value}
          </div>
        </td>";
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

  $text_color = "#7f7f7f";
  if (isset($_SESSION["text_color_hex"])) {
    $text_color = $_SESSION["text_color_hex"];
  }

  $show_text = false;
  if (isset($_SESSION["show_text"])) {
    $show_border = $_SESSION["show_text"] === "true" ? "checked" : "";
  }

  $border_color = "#7f7f7f";
  if (isset($_SESSION["border_color_hex"])) {
    $border_color = $_SESSION["border_color_hex"];
  }

  $show_border = false;
  if (isset($_SESSION["show_border"])) {
    $show_border = $_SESSION["show_border"] === "true" ? "checked" : "";
  }

  echo "
  <h1>C'est la Vie, Conway</h1>

  <table id='toggles'>
    <tbody>
      <tr>
        <td colspan='2'>
          Cell Colors
        </td>
      </tr>
      <tr>
        <td>
          <input type='color' id='dead-color' name='dead-color' value='{$dead_color}'>
        </td>
        <td>
          <label for='dead-color'>Dead</label>
        </td>
      </tr>
      <tr>
        <td>
          <input type='color' id='alive-color' name='alive-color' value='{$alive_color}'>
        </td>
        <td>
          <label for='alive-color'>Alive</label>
        </td>
      </tr>
      <tr>
        <td colspan='2'>
          Text
        </td>
      </tr>
      <tr>
        <td>
          <input type='color' id='text-color' name='text' value='{$text_color}'>
        </td>
        <td>
          <label for='alive'>Color</label>
        </td>
      </tr>
      <tr>
        <td>
          <label class='switch'>
            <input id='show-text' type='checkbox' $show_text>
            <span class='slider'></span>
          </label>
        </td>
        <td>
          Show
        </td>
      </tr>
      <tr>
        <td colspan='2'>
          Borders
        </td>
      </tr>
    </tbody>
    <tr>
      <td>
        <input type='color' id='border-color' name='border-color' value='{$border_color}'>
      </td>
      <td>
        <label for='border-color'>Color</label>
      </td>
    </tr>
    <tr>
        <td>
          <label class='switch'>
            <input id='show-border' type='checkbox' $show_border>
            <span class='slider'></span>
          </label>
        </td>
        <td>
          Show
        </td>
      </tr>
  </table>
  <p>
    <button id='go'>Go</button>
    <button id='stop' disabled>Stop</button>
    <button id='next'>Next</button>
    <button id='reset'>Reset</button>
    <button id='clear'>Clear</button>
  </p>
  <div class='flex-container'>
    <table id='game-table' class='center table-border-color'>
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
      Board State:
      <br>
      <code id='hex'>
        {$hex_string}
      </code>
    </p>
  <div>
  ";
}
?>
