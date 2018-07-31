<?php
require_once("b0t.class.php");



$data = file_get_contents('php://input');
$data = json_decode($data, TRUE);


$husnab0t = new husna($data);






/* bilgiad Function STARTS DOES NOT WORK BECAUSE OF WIKIPEDIA */
$husnab0t->addCommand("bilgiad","bilgiadFunc");
function array_value_recursive($key, array $arr){
        $val = array();
        array_walk_recursive($arr, function($v, $k) use($key, &$val){
            if($k == $key) array_push($val, $v);
        });
        return count($val) > 1 ? $val : array_pop($val);
    }

function bilgiadFunc(){
        global $husnab0t;
        /*$ch = curl_init();
        $url = "https://tr.wikipedia.org/w/api.php?format=json&action=query&prop=extracts&explaintext=&generator=random&grnnamespace=0&exlimit=max&exintro";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 900);

        $response = curl_exec($ch);
        $response = json_decode($response, TRUE);
        curl_close($ch);
        $husnab0t->sendMessage(array_value_recursive('title', $response));
	$husnab0t->sendMessage(array_value_recursive('extract', $response));
        */
        $husnab0t->sendMessage("bilgiad ve allambilgiad fonksiyonlarımız hükümetimizin politikaları gereği geçici olarak kullanım dışıdır.");
}
/* bilgiad Function ENDS */

/* mizahyab Function STARTS */
$husnab0t->addCommand("mizahyab","mizahyabFunc");
function mizahyabFunc()
{
        global $husnab0t;
        $ch = curl_init();
        $url = "http://fikra.gen.tr/index.php";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response =curl_exec($ch);
        curl_close($ch);
        $result = "";
        preg_match_all ("/<div class=fikra_body >([^`]*?)<\/div>/", $response, $result);
        $ver = $result[1][0];

        $ver =  mb_convert_encoding($ver,'UTF-8','ISO-8859-9');

        $ver = str_replace("<br />", "", $ver);
        if(trim($ver) == ""){
                mizahyabFunc();
        }
        if (strlen($ver) > 4000) {
                $messageparts = str_split($ver, 4004);
                foreach($messageparts as $parts){
                $husnab0t->sendMessage($parts);
                }
        }
        else{
                $husnab0t->sendMessage($ver);
        }
}
/* mizahyab Function ENDS */


/* fotoad Function STARTS */
$husnab0t->addCommand("fotoad","fotoadFunc");
function fotoadFunc(){
        global $husnab0t;
        $ch = curl_init();
        $url = "http://www.funcage.com/?";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $result = "";
        preg_match_all('/src="([^"]+)"/',$response, $result);
        $sonhal = "http://www.funcage.com".$result[1][1];
        $husnab0t->sendPhoto($sonhal);
}
/* fotoad Function ENDS */



/* PUT NEW FEATURES BELOW */

$husnab0t->addCommand("yemekad","yemekteNeVar");

function yemekteNeVar() {
        global $husnab0t;
        $ch = curl_init();
        $url = "http://kafeterya.metu.edu.tr/";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        preg_match_all("/<div class=\"yemek\">(.*?)<span>(.*?)<img src=\"(.*?)\" alt=\"(.*?)\"\/><\/span>(.*?)<p>(.*?)<\/p>(.*?)<\/div><!--end yemek-->/msi", $response, $output);
        $yemekler = "Yemekte şunlar varmış hojam: \n\nÖğle yemeği\n".$output[4][0]."\n".$output[4][1]."\n".$output[4][2]."\n".$output[4][3]."\n\nAkşam yemeği\n".$output[4][4]."\n".$output[4][5]."\n".$output[4][6]."\n".$output[4][7]."\n\nAfiyet olsun hojam!";
        $husnab0t->sendMessage($yemekler);

}





/* PUT NEW FEATURES ABOVE */

$husnab0t->proccess();
?>
