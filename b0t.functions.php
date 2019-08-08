<?php


function husnaCurl($url) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($ch);
  curl_close($ch);
  return $response;
}

function array_value_recursive($key, array $arr){
        $val = array();
        array_walk_recursive($arr, function($v, $k) use($key, &$val){
            if($k == $key) array_push($val, $v);
        });
        return count($val) > 1 ? $val : array_pop($val);
    }

/* bilgiad Function STARTS */
function bilgiadFunc(){
        global $husnab0t;
        $ch = curl_init();
        $caller=$husnab0t->getFirstWord();
        $thread='';
        if($caller == "allambilgiad") {
          $thread=trim($husnab0t->getOtherWords());
        }
        if(strlen($thread) > 0) {
          $url = "https://tr.wikipedi0.org/w/api.php?format=json&action=query&prop=extracts&exintro=&explaintext=&titles=".urlencode($thread)."&redirects=1";
        }
        else {
          $url = "https://tr.wikipedi0.org/w/api.php?format=json&action=query&prop=extracts&explaintext=&generator=random&grnnamespace=0&exlimit=max&exintro";
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 900);

        $response = curl_exec($ch);
        $response = json_decode($response, TRUE);
        curl_close($ch);

        if (!array_value_recursive('extract', $response)) {
          $husnab0t->sendMessage("hojam boj yabmayın",1);
        } else {
          $husnab0t->sendMessage("*".array_value_recursive('title', $response)."*");
          $husnab0t->sendMessage(array_value_recursive('extract', $response));
        }

}
/* bilgiad Function ENDS */

/* mizahyab Function STARTS */
function mizahyabFunc()
{
        global $husnab0t;
        $response = husnaCurl("http://fikra.gen.tr/index.php");
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
function fotoadFunc(){
        global $husnab0t;
        $response = husnaCurl("http://www.funcage.com/?");
        $result = "";
        preg_match_all('/src="([^"]+)"/',$response, $result);
        $sonhal = "http://www.funcage.com".$result[1][1];
        $husnab0t->sendPhoto($sonhal);
}
/* fotoad Function ENDS */

/* yemekad Function STARTS */
function yemekteNeVar() {
        global $husnab0t;
        $others=trim($husnab0t->getOtherWords());
        date_default_timezone_set('Europe/Istanbul');
        $bak=date("N");
        $tomo=0;
        $others=explode(" ",$others);
        if(in_array("yarın", $others) || in_array("yarin", $others)) {
          $bak=(date("N")+1) % 7;
          $tomo=1;
        }
        if($tomo) {
          $response = husnaCurl("http://kafeterya.metu.edu.tr/tarih/".date("d-m-Y", strtotime('tomorrow')));
        }
        else {
          $response = husnaCurl("http://kafeterya.metu.edu.tr/");
        }
        preg_match_all("/<div class=\"yemek\">(.*?)<span>(.*?)<img src=\"(.*?)\" alt=\"(.*?)\"\/><\/span>(.*?)<p>(.*?)<\/p>(.*?)<\/div><!--end yemek-->/msi", $response, $output);
        if($bak > 5) {
          $yemekler = "Haftasonu yemek yok hojam \xF0\x9F\x98\x94";
        }
        else {
          $yemekler = "\xF0\x9F\x8D\xB4 Y";
          if($tomo) {
            $yemekler .="arın y";
          }
          $yemekler .= "emekte şunlar varmış hojam: \n\n*Öğle yemeği*\n · ".$output[4][0]."\n · ".$output[4][1]."\n · ".$output[4][2]."\n · ".$output[4][3]."\n\n";
          if(strlen($output[4][4]) > 2) {
          $yemekler .= "*Akşam yemeği*\n · ".$output[4][4]."\n · ".$output[4][5]."\n · ".$output[4][6]."\n · ".$output[4][7]."\n\n";
          }
          $yemekler .= "Afiyet olsun hojam!";
        }
        $husnab0t->sendMessage($yemekler);
        if(contains("BORONA",$output[4])) {
          $husnab0t->sendMessage("Aaa bi dk hojam borona varmış menüde? \xf0\x9f\xa5\x95 \n BORONA BORONA \n AL BENI BORONA \n YAKISIRIZ AMA \n COK COK");
        }
}
/* yemekad Function ENDS */

/* dolarad Function STARTS */
function dolaradFunc() {
          global $husnab0t;
          $response = husnaCurl("https://www.bloomberght.com/doviz");
          preg_match_all("/<span data-type=\"son_fiyat\" class=\"LastPrice\" data-secid=\"USDTRY Curncy\">(.*?)<\/span>/msi", $response, $resultRegex);
          $message = "\xF0\x9F\x92\xB5 dolar şu an *".$resultRegex[1][0]."* ₺ hojam. \xF0\x9F\x92\xB8";
          $husnab0t->sendMessage($message);
}
/* dolarad Function ENDS */

/* avroad Function STARTS */
function avroadFunc() {
          global $husnab0t;
          $response = husnaCurl("https://www.bloomberght.com/doviz");
          preg_match_all("/<span data-type=\"son_fiyat\" class=\"LastPrice\" data-secid=\"EURTRY Curncy\">(.*?)<\/span>/msi", $response, $resultRegex);
          $message = "\xF0\x9F\x92\xB6 avro şu an *".$resultRegex[1][0]."* ₺ hojam. \xF0\x9F\x92\xB6";
          $husnab0t->sendMessage($message);
}
/* avroad Function ENDS */

/* egonomiad Function STARTS */
function egonomiadFunc() {
          global $husnab0t;
          $response = husnaCurl("https://www.bloomberght.com/doviz");
          preg_match_all("/<span data-type=\"son_fiyat\" class=\"LastPrice\" data-secid=\"USDTRY Curncy\">(.*?)<\/span>/msi", $response, $resultRegex);
          $message = "\xF0\x9F\x92\xB5 dolar şu an *".$resultRegex[1][0]."* ₺. \xF0\x9F\x92\xB8";
          preg_match_all("/<span data-type=\"son_fiyat\" class=\"LastPrice\" data-secid=\"EURTRY Curncy\">(.*?)<\/span>/msi", $response, $resultRegex);
          $message = $message."\n"."\xF0\x9F\x92\xB6 avro şu an *".$resultRegex[1][0]."* ₺. \xF0\x9F\x92\xB6";
          preg_match_all("/<span data-type=\"son_fiyat\" class=\"LastPrice\" data-secid=\"XU100 Index\">(.*?)<\/span>/msi", $response, $resultRegex);
          $message = $message."\n"."\xF0\x9F\x93\x88 borsa endeksi şu an *".$resultRegex[1][0]."*. \xF0\x9F\x93\x88";
          preg_match_all("/<span data-type=\"son_fiyat\" class=\"LastPrice\" data-secid=\"EURUSD Curncy\">(.*?)<\/span>/msi", $response, $resultRegex);
          $message = $message."\n"."\xF0\x9F\x8F\xA7 avro/dolar paritesi şu an *".$resultRegex[1][0]."*. \xF0\x9F\x8F\xA7";
          preg_match_all("/<span data-type=\"son_fiyat\" class=\"LastPrice\" data-secid=\"IECM2Y Index\">(.*?)<\/span>/msi", $response, $resultRegex);
          $message = $message."\n"."faiz şu an *%".$resultRegex[1][0]."*.";
          preg_match_all("/<span data-type=\"son_fiyat\" class=\"LastPrice\" data-secid=\"XAU Curncy\">(.*?)<\/span>/msi", $response, $resultRegex);
          $message = $message."\n"."altın/ons şu an *".$resultRegex[1][0]."* ₺.";
          preg_match_all("/<span data-type=\"son_fiyat\" class=\"LastPrice\" data-secid=\"CO1 Comdty\">(.*?)<\/span>/msi", $response, $resultRegex);
          $message = $message."\n"."brent şu an *".$resultRegex[1][0]."* \$.";
          $message = $message."\n\n"."egonomi çoh iyi hojam.";
          $husnab0t->sendMessage($message);
}
/* egonomiad Function ENDS */

/* havadurumuad Function BEGINS*/
function havadurumuadFunc() {

          global $husnab0t;
	        include('libs/turkeyweather.php');
          $weather = new TurkeyWeather();

          $obj1 = trim($husnab0t->getOtherWords());
          $obj = explode(" ", $obj1);

          if(count($obj) == 1 && $obj[0] == "") {
            $city = "Ankara";
            $district = "Çankaya";
          }
          else if (count($obj) == 1 && $obj[0] != "") {
            $city = $obj[0];
            $district = null;
          }
          else {
            $city = $obj[0];
            $district = $obj[1];
          }
          $weather->province($city);
          $weather->district($district);
          $weather->getData();
          $durum=$weather->event()[turkish];
          if($durum == "-9999") {
            $durum="bi tuhaf";
          }

          if(strlen($weather->province()) > 1) {
            $message = $weather->province()." ".$weather->district()." konumunda hava *".$durum."* ve sıcaklık *".$weather->temperature()."°*.";
            $message = $message."\n\n"."hava çoh iyi hojam.";
          }
          else {
            $message = "$obj1 diye bi yer yok hojam.";
          }
          $husnab0t->sendMessage($message);
      }
/* havadurumuad Function ENDS*/

/* yemeksepeti function BEGINS*/

function yemeksepeti() {

          global $husnab0t;

          $others=trim($husnab0t->getOtherWords());
          $others=explode(" ",$others);
          $othersC=count($others);
          $minTutar = 0;
          $coksatan = 0;
          if(in_array("popi", $others) || in_array("popı", $others)) {
            $coksatan = 1;
          }
          if(($othersC > 1 && $coksatan == 1) || ($othersC == 1 && $coksatan == 0)) {
            $minTutar=$others[$coksatan];
          }
          $kampusteki="https://www.yemeksepeti.com/ankara/orta-dogu-teknik-universitesi-odtu-kampusu#sof:2|sob:true";
          if($minTutar) {
            $kampusteki.="|mbt:".$minTutar;
          }
          $simdiAcik=husnaCurl($kampusteki);
          #preg_match_all('/<a class="restaurantName withTooltip" href="(.*?)" target="_parent">/msi', $simdiAcik, $restorantlar);
          preg_match_all('/<a class="restaurantName withTooltip" href="(.*?)" target="_parent">(.*?)<span data-tooltip="(.*?)MinimumDeliveryPrice&quot;:(.*?),&quot(.*?)">/msi', $simdiAcik, $restorantlar);
          #1- links, 4- min delivery limits
          if($minTutar) {
            $restorantlarYeni=array();
            $Yenisay=count($restorantlar[1]);
            for($i=0;$i<$Yenisay;$i++) {
              if($restorantlar[4][$i] < $minTutar) {
                array_push($restorantlarYeni,array($restorantlar[0][$i],$restorantlar[1][$i]));
              }
            }
            $restorantlar=$restorantlarYeni;
          }

          $restorantSay=count($restorantlar[1]);
          $restorantSec=rand(1,$restorantSay)-1;
          $restorant="https://www.yemeksepeti.com".$restorantlar[1][$restorantSec];
          $menuGetir=husnaCurl($restorant);
          preg_match_all('/<meta name="twitter:title" content="(.*?), Ankara Online/msi', $menuGetir, $restorantAdi);

          if($coksatan) {
            preg_match_all('/<div class="productName">(.*?)<a href="javascript\:void\(0\)\;" data-catalog-name="TR_ANKARA" class="getProductDetail" data-product-id="(.*?)" data-category-name="(.*?)" data-top-sold-product="true">(.*?)<\/a>(.*?)<\/div>(.*?)<span class="productInfo">(.*?)<p>(.*?)<\/p>(.*?)<\/span>(.*?)<span class="pull-right newPrice">(.*?)<\/span>/msi', $menuGetir, $yemekler);
            $menuSay=count($yemekler[4]);
          }
          else {
            preg_match_all('/<div class="productName">(.*?)<a href="javascript\:void\(0\)\;" data-catalog-name="TR_ANKARA" class="getProductDetail" data-product-id="(.*?)" data-category-name="(.*?)" data-top-sold-product="(.*?)">(.*?)<\/a>(.*?)<\/div>(.*?)<span class="productInfo">(.*?)<p>(.*?)<\/p>(.*?)<\/span>(.*?)<span class="pull-right newPrice">(.*?)<\/span>/msi', $menuGetir, $yemekler);
            $menuSay=count($yemekler[5]);
          }

          $yemekSec=rand(1,$menuSay)-1;

          if($coksatan) {
            $yemek=$yemekler[4][$yemekSec];
            $icerik=$yemekler[8][$yemekSec];
            $fiyat=$yemekler[11][$yemekSec];
          }
          else {
            $yemek=$yemekler[5][$yemekSec];
            $icerik=$yemekler[9][$yemekSec];
            $fiyat=$yemekler[12][$yemekSec];
          }
          @preg_match_all('/<i class="ys-icons ys-icons-foto" data-imagepath="(.*?)" data-productname="(.*?)"><\/i>/msi', $yemek, $yemekozel);
          if(strlen($yemekozel[2][0]) > 2) {
            $yemek=$yemekozel[2][0];
          }
          $yemek=html_entity_decode($yemek);
          $sonuc="hojam bence *".$restorantAdi[1][0]."* mekanından *".$yemek."* yiyin. ";
          if(strlen($icerik) > 0) {
            $icerik=html_entity_decode($icerik);
            $sonuc.= "içinde *".$icerik."* var, ";
          }
          $sonuc.= "fiyatı da *".$fiyat."*, güzel bence. şuradan direkt sipariş verebilirsiniz: $restorant";


          $husnab0t->sendMessage($sonuc);

}


/* yemeksepeti function ENDS*/

function helber(){
	global $husnab0t;
  $husnab0t->sendMessage($husnab0t->getWhoamI());
}


function komutad(){
	global $husnab0t;
	if (!$husnab0t->getGroupOrPrivate()){
	$lista=array_chunk(array_keys($husnab0t->getMenu()), (ceil(count(array_keys($husnab0t->getMenu()))/3)));
	$replyMarkup = array(
    'keyboard' => $lista,
	);
	$encodedMarkup = json_encode($replyMarkup);
	$husnab0t->sendMessage_w_markup("komut seç bro",$encodedMarkup);}
	else {
		$husnab0t->sendMessage("bu fonksiyon sadece özel mesajda çalışıyor",1);	
	}
}

/* gunaydin Function STARTS	*/
function gunadyinFunc(){
	global $husnab0t;
	$husnab0t->sendMessage("hepinize günaydınlar :)");
	havadurumuadFunc();
	yemekteNeVar();
	egonomiadFunc();
}

/* gunaydin Function ENDS */

/* bojyabmaFunc Function STARTS*/
function bojyabmaFunc(){
	global $husnab0t;
	$husnab0t->sendPhoto("https://s2.eksiup.com/f4efffa4d670.jpeg","",1);
}
/* bojyabmaFunc Function ENDS */

/* muazzam Function STARTS*/
function muazzam(){
	global $husnab0t;
	$husnab0t->sendPhoto("https://s3.eksiup.com/66e49a926940.jpg","",1);
}
/* muazzam Function ENDS */

/* bilimsiz Function STARTS*/
function bilimsiz(){
	global $husnab0t;
	$husnab0t->sendPhoto("https://s3.eksiup.com/eb5ffea94370.jpg","",1);
}
/* bilimsiz Function ENDS */

/* java Function STARTS*/
function jaava(){
	global $husnab0t;
	$husnab0t->sendPhoto("https://s3.eksiup.com/4aed51458925.jpg","",1);
}
/* java Function ENDS */

/* beyle Function STARTS*/
function beyle(){
	global $husnab0t;
	$husnab0t->sendPhoto("https://s3.eksiup.com/fc55f421b312.jpg","",1);
}
/* beyle Function ENDS */

/* spam Function STARTS*/
function spamlamayin(){
	global $husnab0t;
	$husnab0t->sendMessage("hojam botu spamlamayin",1);
}
/* spam Function ENDS */

/* husnacim Function STARTS*/
function husnacimFunc() {
  global $husnab0t;
  $husnab0t->sendMessage("yeter ki sen iste",1);
}

function contains($str, array $arr) {
  foreach($arr as $a) {
    if (stripos($a,$str) !== false) return true;
  }
  return false;
}




/* PUT NEW FEATURES BELOW */

/* PUT NEW FEATURES ABOVE */
