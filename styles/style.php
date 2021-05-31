<?php
  header("Content-type: text/css");

  if (!session_id()) {
    session_start();
  }
  include("../php/global.php");

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
    $text_color = hex2rgb($_SESSION["text_color"], 0);
  }
?>

body {
  background: #f5f5f5;
}

table, th, td {
  border: 1px solid black;
}

table {
  border-collapse: collapse;
}

td {
  width: 18px;
  height: 15px;
}

.alive
{
  background-color: <?=$alive_color?>;
}

.dead
{
  background-color: <?=$dead_color?>;
}

td {
  text-align: center;
  padding: 0;
  margin: 0;
  background-color: rgba(0,0,0,0);
  color: <?=$text_color?>;
}

p,
label
{
  font: 1rem 'Fira Sans', sans-serif;
}

input {
  margin: .4rem;
}

main
{
  text-align: center;
}

.center {
  margin-left: auto;
  margin-right: auto;
}





.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 30px;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 22px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}
