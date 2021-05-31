<?php
if (!session_id()) {
  session_start();
}
include("global.php");

if(isset($_SESSION["round"])) {
  $_SESSION["dead_color"] = $_POST["deadColor"];
  $_SESSION["alive_color"] = $_POST["aliveColor"];
  $_SESSION["text_color"] = $_POST["textColor"];

  // $hex = substr($_SESSION["text_color"], 1);


  $response = json_encode(
    [
      $_SESSION["dead_color"],
      $_SESSION["alive_color"],
      $_SESSION["text_color"],
      hex2rgb($_SESSION["text_color"], .5)
    ]
  );
  exit($response);
}
?>
