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
$husnab0t->addCommand("help","helber");
$husnab0t->addCommand("neyesem","yemeksepeti");
$husnab0t->addCommand("gunaydin","gunadyinFunc");
$husnab0t->addCommand("günaydın","gunadyinFunc");
$husnab0t->addCommand("boşyapıyolar","bojyabmaFunc");
$husnab0t->addCommand("bojyapıyolar","bojyabmaFunc");
$husnab0t->addCommand("bosyapiyolar","bojyabmaFunc");
$husnab0t->addCommand("boşyapiyolar","bojyabmaFunc");
$husnab0t->addCommand("bojyapiyolar","bojyabmaFunc");
$husnab0t->addCommand("nasıl","beyle");
$husnab0t->addCommand("nasil","beyle");
$husnab0t->addCommand("java","jaava");
$husnab0t->addCommand("bilimsiz","bilimsiz");
$husnab0t->addCommand("bilimsizlik","bilimsiz");
$husnab0t->addCommand("bilimsizliktir","bilimsiz");
$husnab0t->addCommand("muazzam","muazzam");
//$husnab0t->addCommand("komutad","komutad");

/* PUT NEW COMMANDS BELOW */


/* PUT NEW COMMANDS ABOVE */

$husnab0t->proccess();
?>
