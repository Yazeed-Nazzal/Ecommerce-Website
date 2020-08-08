<?php 
include "Connect.php";

//routes
$temp  = 'Inclodes/templates';
$css   = "Layout/Css";
$js    = "Layout/JS";
$langu = "Inclodes/Lang";
$fun   = "Inclodes/Functions";
include  $langu . "/english.php";
include  $fun   . "/function.php";
include  $temp  . "/header.php";

// where to use the navbar
if (!isset($nonavbar)){
include  $temp . "/navbar.php";
}
?>