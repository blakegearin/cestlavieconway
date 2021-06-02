<?php
if (!session_id()) {
  session_start();
}
include("global.php");

if(isset($_SESSION["round"])) {
  $_SESSION["round"] = 1;
  $_SESSION["last_board"] = "";
  $status = "start";

  GLOBAL $board;
  $board = $_POST["board"];
  GLOBAL $new_board;
  $new_board = array();

  GLOBAL $grid_size;
  $grid_size = count($board);

  for ($r = 0; $r < $grid_size; $r++) {
    $row = array();
    for ($c = 0; $c < $grid_size; $c++) {
      $row[$c] = $dead;
    }
    array_push($new_board, $row);
  }

  $binary = convert_multi_array($new_board);
  $hex = binhex($binary);
  $_SESSION["last_board"] = $binary;

  $response = json_encode(
    [
      $_SESSION["round"],
      $status,
      $binary,
      $hex
    ]
  );
  exit($response);
}
?>
