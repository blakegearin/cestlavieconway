<?php
if (!session_id()) {
  session_start();
}
include("global.php");

if(isset($_SESSION["round"])) {
  $_SESSION['round'] = 1;
  $status = "start";

  include("random_board.php");

  $binary = convert_multi_array($new_board);
  $_SESSION["start_board"] = $binary;
  $hex = binhex($binary);

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
  <p>Click cells to make them alive or dead.</p>
  <table id='game-table' class='center table-border-color'>
  <tbody>
    {$html_board}
  </tbody>
  </table>
  <p>
    <button id='go'>Go</button>
    <button id='stop' disabled>Stop</button>
    <button id='next'>Next</button>
    <button id='reset'>Reset</button>
    <button id='clear'>Clear</button>
  </p>
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
    <textarea id='hex' name='test' rows='4' cols='23'>{$hex}</textarea>
  </p>
  <p id='hex-error' class='error' hidden></p>
  <table id='preferences'>
    <tbody>
      <tr>
        <td colspan='2'>
          <h2>Preferences</h2>
        </td>
      </tr>
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
    </tbody>
  </table>
  ";
}
?>
