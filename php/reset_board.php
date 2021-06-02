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
  $new_board = "";

  GLOBAL $grid_size;
  $grid_size = count($board);

  $new_board = $_SESSION["start_board"];
  $_SESSION["last_board"] = $new_board;
  $hex = binhex($new_board);

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
