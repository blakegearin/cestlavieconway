<?php
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
?>
