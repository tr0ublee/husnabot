<?php

function husnaCurl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch,CURLOPT_TIMEOUT,1000);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
  }
  

function zlotyadFunc() {
    global $husnab0t;
    $response = husnaCurl("https://api.exchangeratesapi.io/latest?base=TRY");
    $exchange_rates = json_decode($response, true);
    $pln_rate = 1 / $exchange_rates['rates']['PLN'];
    $message = "\xF0\x9F\x87\xB5\xF0\x9F\x87\xB1 zloty şu an ".number_format($pln_rate, 4)." ₺ hojam. \xF0\x9F\x87\xB9\xF0\x9F\x87\xB7";
    echo $message;
  }

function zlotyadFunc2() {
  global $husnab0t;
  $response = husnaCurl("https://m.tr.investing.com/currencies/pln-try");
  preg_match_all('/<span class=\"lastInst pid.*?\">\s*?(\S*?)\s*?<\/span>/msi', $response, $resultRegex);
  $message = "\xF0\x9F\x87\xB5\xF0\x9F\x87\xB1 zloty şu an **".$resultRegex[1][0]."** ₺ hojam. \xF0\x9F\x87\xB9\xF0\x9F\x87\xB7";
  echo $message;
  $husnab0t->sendMessage($message);
}
  

  zlotyadFunc2();