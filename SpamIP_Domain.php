#!/usr/bin/php -q
<?php

require 'Net/IPv4.php';

function getIPFromReceived($str){
  //$match="";
  //echo $str. "\n";
  $ips=array();
  //if(strstr($str, "Received: from")){
  //if(strstr($str, "X-Received:")){
  //echo "X\n";
  $split=explode(" ", $str);
  //var_dump($split);
  for($i=0; $i<count($split); $i++){
    $ip_candidate=trim_bra($split[$i]);
    if(Net_IPv4::validateIP($ip_candidate)){
      $ips[]="[".$ip_candidate."]";
    }
  }
  //preg_match("/\[.+?\]/", $str, $match);
  //echo "in Received:". $str ."\n";
  //}

  return $ips;
}

function is_ip($strIP){

  $result = false;

  $strIP=trim_bra($strIP);
  $arrOct = split('\.',$strIP,5);

  if (count($arrOct)==4){
    $result = true;
    foreach ($arrOct as $n) $result &= (is_numeric($n) && ($n<=255));
  }
  return $result;
}

function trim_bra($word){
  $word = str_replace("(", "", $word);
  $word = str_replace("[", "", $word);
  $word = str_replace("]", "", $word);
  $word = str_replace(")", "", $word);
  $word = str_replace(";", "", $word);
  return $word;
}
function is_white($ip, $whites){
  for($i=0; $i<count($whites); $i++){
    if(strstr($ip, $whites[$i])){
      return true;
    }
  }
  return false;
}

function uniqlize($ips){
  $ips=array_unique($ips);
  foreach ($ips as $ipsWithoutSpace[]){};
  return $ipsWithoutSpace;
}

$input = $argv[1];
$output = $argv[2];
$ips=array();

$whites=array();
$r = fopen("white_ip.txt", "r");
while ($fv = fscanf($r, "%s\n")) {
        $whites[]=$fv[0];
}
fclose($r);

$flag=0;
$fw=fopen($output, "a");
$fr = fopen($input, "r");
while(!feof($fr)){
  $fileline = fgets($fr);

  $str="";
  for($i=0; $i<strlen($fileline); $i++){
    if(preg_match("/[!-~\s]/", $fileline[$i]) == 1){
      $str.=$fileline[$i];
    }
  }
  //echo $str. "\n";
  if( preg_match_all('/https?:\/\/[a-zA-Z0-9\-\.\/\?\@&=:~#]+/', $str, $matches) !== FALSE){
    //var_dump($matches);
  }
  for($i=0; $i<count($matches[0]); $i++){
    //echo $matches[0][$i]. "\n";
    $url=$matches[0][$i];
    $url=parse_url($url);
    $domain=$url['host'];
    //              fprintf($fw, "%s %s %s\n", $input, $domain, gethostbyname($domain));
    fprintf($fw, "%s %s\n", $domain, gethostbyname($domain));
  }
  
 }
fclose($fw);
fclose($fr);

?>

  
