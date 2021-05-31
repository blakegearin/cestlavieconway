<?php
  header("Content-type: text/css");

  $dead_color = "#FFFFFF";
  $alive_color = "#B602A0";
  $text_color = "rgba(0,0,0,0)"
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

<!-- table button
{

  width: 100%;
  height: 100%;
  border: 0;
  padding: 0;
  margin: 0;
  background-color: rgba(0,0,0,0);
  color: <?=$text_color?>;
} -->

p,
label
{
  font: 1rem 'Fira Sans', sans-serif;
}

input {
  margin: .4rem;
}
