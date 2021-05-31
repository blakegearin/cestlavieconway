<?php
  GLOBAL $board;
  $board = $_POST['board'];
  GLOBAL $new_board;
  $new_board = array();

  GLOBAL $dead;
  $dead = 0;
  GLOBAL $alive;
  $alive = 1;

  GLOBAL $grid_size;
  $grid_size = count($board);

  function get_cell($r, $c) {
    return (int) $GLOBALS['board'][$r][$c];
  }

  function count_alive_neighbors($r, $c) {
    $alive_neighbors = 0;

    $row_above = $r > 0;
    $row_below = $r < $GLOBALS['grid_size']-1;
    $column_left = $c > 0;
    $column_right = $c < $GLOBALS['grid_size']-1;

    if ($row_above) {
      if ($column_left && (get_cell($r-1, $c-1) === $GLOBALS['alive'])) {
        $alive_neighbors++;
      }

      if (get_cell($r-1, $c) === $GLOBALS['alive']) {
        $alive_neighbors++;
      }

      if ($column_right && (get_cell($r-1, $c+1) === $GLOBALS['alive'])) {
        $alive_neighbors++;
      }
    }

    if ($column_left && (get_cell($r, $c-1) === $GLOBALS['alive'])) {
      $alive_neighbors++;
    }

    if ($column_right && (get_cell($r, $c+1) === $GLOBALS['alive'])) {
      $alive_neighbors++;
    }

    if ($row_below) {
      if ($column_left && (get_cell($r+1,$c-1)) === $GLOBALS['alive']) {
        $alive_neighbors++;
      }

      if (get_cell($r+1, $c) === $GLOBALS['alive']) {
        $alive_neighbors++;
      }

      if ($column_right && (get_cell($r+1, $c+1) === $GLOBALS['alive'])) {
        $alive_neighbors++;
      }
    }

    return $alive_neighbors;
  }

  for ($r = 0; $r < $grid_size; $r++) {
    $row = $board[$r];
    $new_row = array();
    for ($c = 0; $c < $grid_size; $c++) {
      $cell = (int) $board[$r][$c];
      $alive_neighbors = count_alive_neighbors($r, $c);
      if ($cell === $dead) {
        if ($alive_neighbors === 3) {
          $new_row[$c] = $alive;
        } else {
          $new_row[$c] = $dead;
        }
      } else if ($cell === $alive) {
        if ($alive_neighbors < 2 || $alive_neighbors > 3) {
          $new_row[$c] = $dead;
        } else {
          $new_row[$c] = $alive;
        }
      }
    }
    array_push($new_board, $new_row);
  }

  exit(json_encode($new_board));
?>
