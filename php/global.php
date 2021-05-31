<?php
if (!session_id()) {
  session_start();
}

if(!isset($_SESSION["round"])) {
  $_SESSION["round"] = 1;
  $_SESSION["last_board"] = array();
} else {
  $_SESSION["round"]++;
}

function binhex($str) {
  $result = "";
  for ($i = 0; $i < strlen($str); $i = $i + 8) {
    $eightBits = substr($str, $i, 8);
    $result .= sprintf("%02X", bindec($eightBits));
  }
  return $result;
}

function convert_multi_array($array) {
  $output = implode(
    array_map(
      function($a) {
        return implode($a);
      },
      $array
    )
  );
  return $output;
}

function hex2rgb($hex, $transparency) {
  $hex = substr($hex, 1);

  $parts = str_split($hex, 2);
  $text_color = [
    (string) hexdec($parts[0]),
    (string) hexdec($parts[1]),
    (string) hexdec($parts[2])
  ];

  return "rgba(" . implode(", ", $text_color) . ", {$transparency})";
}

GLOBAL $dead;
$dead = 0;
GLOBAL $alive;
$alive = 1;

?>
