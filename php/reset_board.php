<?php
if (!session_id()) {
  session_start();
}
include("global.php");

if(isset($_SESSION["round"])) {
  $_SESSION["round"] = 1;
  $_SESSION["last_board"] = array();
  $status = "start";

  GLOBAL $board;
  $board = $_POST["board"];
  GLOBAL $new_board;
  $new_board = array();

  GLOBAL $grid_size;
  $grid_size = count($board);

  $new_board = $_SESSION["start_board"];

  $binary = convert_multi_array($new_board);
  $hex = binhex($binary);
  $_SESSION["last_board"] = $hex;

  $response = json_encode(
    [
      $_SESSION["round"],
      $status,
      $_SESSION["start_board"],
      $hex
    ]
  );
  exit($response);
}
?>
