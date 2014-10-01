<?php

  //Library
require_once('file.php');


//initial
$mail_body=array();
$mail_add=array();
$matche1=array();
$matche3=array();
$pnum=array();

$input=$argv[1];

exec("./mail2plain '$input'", $mail_body);
$text = htmlspecialchars(implode("\r\n", $mail_body));

var_dump($text);
$fw=fopen("phone-life-span-0220.txt", "a");

  if(preg_match_all('(\d{2,4}-\d{2,4}-\d{4}|\d{2,4}-\d{2,4}-\d{2,4}-\d{4}|\(\d{2,4}\) \d{2,4}-\d{2,4}-\d{4}|\(\d{2,4}\)-\d{2,4}-\d{2,4}-\d{4}|\+\d{2,4}-\d\{\
2,4}-\d{2,4}-\d{4}|\(\d{2,4}\)\d{2,4}-\d{4}|\(\d{2,4}\)-\d{2,4}-\d{4}|\d{2,4}\(\d{2,4}\)\d{4})', $text, $matches2) !== FALSE){
  for($i=0; $i<count($matches2[0]); $i++){
    $pnum[]=$matches2[0][$i];
    fprintf($fw, "%s, %s, %s\n", $i, $pnum[$i], $input);
  }
 }

echo "Phone_Num \n";
var_dump($pnum);

echo "check fin \n";

?>
