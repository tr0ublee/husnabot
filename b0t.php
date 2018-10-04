<?php
require_once("b0t.class.php");

$data = file_get_contents('php://input');
$data = json_decode($data, TRUE);

$husnab0t = new husna($data);
require_once("b0t.functions.php");
require_once("priv8.php");

$husnab0t->addCommand("bilgiad","bilgiadFunc");
$husnab0t->addCommand("mizahyab","mizahyabFunc");
$husnab0t->addCommand("fotoad","fotoadFunc");
$husnab0t->addCommand("yemekad","yemekteNeVar");
$husnab0t->addCommand("dolarad","dolaradFunc");
$husnab0t->addCommand("avroad","avroadFunc");
$husnab0t->addCommand("euroad","avroadFunc");
$husnab0t->addCommand("egonomiad","egonomiadFunc");
$husnab0t->addCommand("havadurumuad","havadurumuadFunc");
$husnab0t->addCommand("helb","helber");
//$husnab0t->addCommand("komutad","komutad");

/* PUT NEW COMMANDS BELOW */


/* PUT NEW COMMANDS ABOVE */

$husnab0t->proccess();
?>
