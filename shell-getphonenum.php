#!/usr/bin/php -q
<?php
  //initial
$cmd=array();
$data = '201402';

for($k=20; $k<=20; $k++){
  for($j=0; $j<=23; $j++){
    // $cmd = sprintf("ls /home/scan1/Maildir/cur/%s%02d%02d/*", $data, $i, $j);
    //  $cmd = sprintf("ls /home/mail_store/white/in_house/%s%02d%02d/*", $data, $i, $j);
    $cmd = sprintf("ls /ext_dsk/home/mail-collector/store/%s%02d/%02d/*/*", $data, $k, $j);
    exec($cmd, $msgs);
    echo $cmd;
  }


for($i=0; $i<count($msgs); $i++){
  $cmd = sprintf("/usr/bin/php getphonenum-enduserfeedback.php %s", $msgs[$i]);
  //     $cmd = sprintf("/usr/bin/php getspamfilter.php %s", $msgs[$i]);
  echo $cmd;
  exec($cmd, $log);
  echo $i."\n\n";
 }
 $msgs=NULL;
 }
//  echo $i."\n\n";
echo "fin";
 ?>
