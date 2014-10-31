#!/usr/bin/php -q
<?php

//if($argc!=3){
//        echo "Usage: shell output dir\n";
//        //./shell.php 20140225.txt 20140225
//        exit;
//}

//Initialize
//$msgs=array();
//$output= array();
$cmd=array();

// Value

$output = "memo04.txt";
//$output = $argv[1];
//$dir = $argv[2];
//$cmd=sprintf("ls %s/*", $dir);
//$cmd=sprintf("dir \?/*.eml", $dir);
//exec($cmd, $msgs);
$data = '20140602';

for($i=0; $i<24; $i++){
  $cmd = sprintf("ls /ext_dsk/home/mail-collector/store/%s/%02d/*/*", $data, $i);
  echo $cmd. "\n";
  exec($cmd, $msgs);
  //  var_dump($msgs);
    var_dump(count($msgs));
 }

for($i=0; $i<count($msgs); $i++){

  $cmd = sprintf("php SpamID_Domain.php %s %s", $msgs[$i], $output);
  //  $cmd = sprintf("%s", $output);
  echo $cmd. "\n";
  exec($cmd, $log);
  echo $i."\n\n";
  }
 ?>
