<?php
require_once("b0t.php");

date_default_timezone_set('Europe/Istanbul');

$saat=date("H");
$dakika=date("i");
$haftagunu=date("N");

switch($saat) {
  case "9":
    $husnab0t->sendMessage("Günaydın hojam!");
    if(date("N") < 6) {
      $husnab0t->yemekad();
    }
  break;
}
