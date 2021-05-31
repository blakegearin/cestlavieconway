<?php
$current_year = date("Y");
$copyright = 2021;

if ($current_year != $copyright) {
  $copyright .= "–{$current_year}";
}

echo $copyright;
?>
