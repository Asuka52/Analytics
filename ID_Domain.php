#!/usr/bin/php -q
<?php

//Library
require_once('file01.php');
require_once('Net/IPv4.php');

//ComandLineInput
$input = $argv[1];
$output = $argv[2];

//$input = "20140507";
//$output ="memo1.txt";

//Initialize
//$ips=array();
$ips_tmp=array();
$domain=array();
$ips_path=array();
$ips=array();
$whites=array();

//File open. read whiteIP
$r = fopen("white_ip.txt", "r");
while ($fv = fscanf($r, "%s\n")) {
  $whites[]=$fv[0];
 }
fclose($r);

$fw=fopen($output, "a");
$fr=fopen($input, "r");

//Main Loop
if($fr=fopen($input, "r")){
while(!feof($fr)){

  //Initialize
  $str="";
  $ips_tmp=array();
  $ips_tmp_path=array();

  //read a line
  $fileline = fgets($fr);
  echo "\nPickUpLine is $fileline . \n";
    //check ASKIIcode
  for($i=0; $i<strlen($fileline); $i++){
    if(preg_match("/[!-~\s]/", $fileline[$i]) == 1){
      $str.=$fileline[$i];
    }
  }

   //find URL
  if(preg_match_all('/https?:\/\/[a-zA-Z0-9\-\.\/\?\@&=:~#]+/', $str, $matches) !== FALSE){
    for($i=0; $i<count($matches[0]); $i++){
      $url=$matches[0][$i];
      $url=parse_url($url);
      $domain_pre=gethostbyname($url['host']);
      $domain[]=getIPFromData($domain_pre);
    }
  }

  //Received IP
  if(strstr($str, "Received: from")){
    $ips_tmp[]=getIPFromData($str);
  }
    //From
  if(strstr($str, "From: ")){
     $ips_tmp_path_pre=getIPPathFromReceived($str);
     //     $ips_tmp_path_pre=str_replace(array("\r\n","\n","\r"), '',$ips_tmp_path_pre);
     //     var_dump($ips_tmp_path_pre);
     var_dump($ips_tmp_path_pre);
     $ips_tmp_path=gethostbyname($ips_tmp_path_pre);
     var_dump ($tmp);
     $ips_tmp_path=getIPFromData($ips_tmp_path);
      }

  for($i=0; $i<count($ips_tmp); $i++){
    if(!is_white($ips_tmp[$i], $whites)){
      $ips[]=$ips_tmp[$i];
    }
  }

  for($i=0; $i<count($ips_tmp_path); $i++){
    if(!is_white($ips_tmp_path[$i], $whites)){
      $ips_path[]=$ips_tmp_path[$i];
    }
  }
       }

$ips=uniqlize($ips);
$ips_path=uniqlize($ips_path);
$domain=uniqlize($domain);
   echo $ips_path. "\n";
    var_dump ($ips_path);
   //exit;
   // fgets(STDIN, 4096);

echo "final check \n";
echo "Received: \n";
var_dump ($ips);
echo "URL \n";
var_dump ($domain);
echo "Path \n";
var_dump($ips_path);
fprintf($fw, "\n-%s \n", $input);
for($i=0; $i<count($ips); $i++){
  $dbconn = pg_connect("port=5432 user=postgres password=postgres dbname=analytics");
  if (!$dbconn){
    die('fails connect'.pg_last_error());
  }
  print('success. \n');
  for($j=0; $j<count($domain); $j++) {
    for($k=0; $k<count($ips_path); $k++){
      fprintf($fw, "%s %s %s\n",$ips[$i], $domain[$j], $ips_path[$k]);
      $sql = "INSERT INTO spam04(ip, url, path) VALUES('$ips[$i]', '$domain[$j]', '$ips_path[$k]')";
      pg_query($dbconn, $sql) or die('query failed:' . pg_last_error());
    }
  }
       echo "check7 \n";
  if($i>0){
    break;
  }
 }

fclose($fw);
fclose($fr);}
else{
  echo "connect error";
}

?>
  

  
  
