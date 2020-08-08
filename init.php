<?php 
include "Connect.php";

$sessionuser = '';

if (isset($_SESSION['user'])) {
   $sessionuser = $_SESSION['userid'];
}


//routes
$temp  = 'Inclodes/templates';
$css   = "Layout/Css";
$js    = "Layout/JS";
$langu = "Inclodes/Lang";
$fun   = "Inclodes/Functions";
include  $langu . "/english.php";
include  $fun   . "/function.php";
include  $temp  . "/header.php";
include  $temp  . "/navbar.php";

?>