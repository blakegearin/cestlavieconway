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
    $text_color = $_SESSION["text_color"];
  }

  $border_color = "none";
  if (isset($_SESSION["border_color"]) && $_SESSION["show_border"] == "true") {
    $border_color = $_SESSION["border_color"];
  }
?>

html
{
  background-color: #131313;
}

body, html
{
  height: 100%;
  margin: 0;
}

#outer-wrapper
{
  top: 0;
  background-position: top left;
  background-image: url("../img/newspaper.jpeg");
  background-position: center center;
  background-size: 100% 100%;
  background-attachment: fixed;
  background-repeat: no-repeat;
  position: fixed;
  min-width: 100%;
  width: 100%;
  min-height: 100%;
  z-index: -1;
  transform: translate3d(0, 0, 0);
  filter: blur(3px);
}

#bg-overlay
{
  width: 100%;
  height: 100%;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  position: absolute;
  z-index: -1;
  background-color: rgba(255, 255, 255, .7);
  filter: blur(8px);
  -webkit-filter: blur(8px);
}

button,
label,
p,
small,
span,
td
{
  font-family: 'Raleway', serif;
  font-size: 1.1rem;
  font-weight: 300;
}

input
{
  margin: .4rem;
}

main
{
  text-align: center;
}

textarea
{
  font-family: courier-std, monospace;
  font-weight: 400;
  font-style: normal;
  width: auto;
  resize: none;
}

nav
{
  background-color: #141414;
  height: 85px;
  display: table;
  width: 100%;
}

nav div
{
  font-size: 1.9em;
  font-family: 'Conv_RadioNewsman', serif;
  display: table-cell;
  vertical-align: middle;
  color: white;
  text-align: center;
  padding: 10px;
}

.center
{
  margin-left: auto;
  margin-right: auto;
  text-align: center;
}

.alive
{
  background-color: <?=$alive_color?>;
}

.dead
{
  background-color: <?=$dead_color?>;
}

.error
{
  color: #790707;
}

#game-table
{
  width: 50%;
  max-width: 500px;
  text-align: center;
  border-collapse: collapse;
}

#game-table td
{
  width: 5%;
  position: relative;
}

#game-table td::after
{
  content: '';
  display: block;
  margin-top: 100%;
}

#game-table td .content
{
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  text-align: center;
  color: <?=$text_color?>;
}

#preferences
{
  width: 50%;
  margin-left: auto;
  margin-right: auto;
  padding-bottom: 50px;
  table-layout: fixed;
}

#preferences td
{
  padding: .2em;
}

#preferences tr td[colspan="2"]
{
  font-weight: bold;
}

#preferences tr td:nth-child(odd):not([colspan="2"])
{
  text-align: right;
}

#preferences tr td:nth-child(even):not([colspan="2"])
{
  text-align: left;
}

.table-border-color
{
  border: 1px <?=$border_color?> solid;
}


.switch
{
  position: relative;
  display: inline-block;
  width: 50px;
  height: 27px;
  margin: .4rem;
}

.switch input
{
  opacity: 0;
  width: 0;
  height: 0;
}

.slider
{
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #EFEFEF;
  -webkit-transition: .4s;
  transition: .4s;
  border-radius: 3px;
  border: 1px solid #767676;
}

.slider:before
{
  position: absolute;
  content: "";
  height: 18px;
  width: calc(40px/2);
  left: 4px;
  bottom: 4px;
  background-color: #767676;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider
{
  background-color: #2196F3;
  border-color: #FFFFFF;
}

input:checked + .slider:before
{
  background-color: #FFFFFF;
}

input:focus + .slider
{
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before
{
  -webkit-transform: translateX(21px);
  -ms-transform: translateX(21px);
  transform: translateX(21px);
}

footer div {
  position: fixed;
  left: 0;
  bottom: 0;
  width: 100%;
  height: 40px;
  margin-top: -151px;
  text-rendering: auto;
  background-attachment: fixed;
  background-color: #131313;
  clear: both;
}

.text-muted {
  color: #e2e2e2;
}

footer div small {
  line-height: 3.25;
  font-size: 80%;
  font-weight: 400;
}

footer a {
  color: #FFFFFF;
}

@media only screen and (max-width: 600px) {
  #game-table td .content
  {
    font-size: 2vw;
  }
}

/* Small devices (portrait tablets and large phones, 600px and up) */
@media only screen and (min-width: 600px) {
  #game-table td .content
  {
    font-size: 2vw;
  }
}

/* Medium devices (landscape tablets, 768px and up) */
@media only screen and (min-width: 768px) {
  #game-table td .content
  {
    font-size: 2vw;
  }
}

/* Large devices (laptops/desktops, 992px and up) */
@media only screen and (min-width: 992px) {
  #game-table td .content
  {
    font-size: 1.5vw;
  }
}

/* Extra large devices (large laptops and desktops, 1200px and up) */
@media only screen and (min-width: 1200px) {
  #game-table td .content
  {
    font-size: 1.25vw;
  }
}

#hex
{
  width: 200px;
  height: 57px;
}
