?php
function getIPFromData($str){
  preg_match('/([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})/',$str, $ips);
  if(Net_IPv4::validateIP($ips[0])){
    return $ips[0];
  }else{
    $ips[0] = "";
    return $ips[0];

  }
}

function getIPPathFromReceived($str){
  echo "checkPath $str. \n";
  //  $split_path=explode(" ", $str);

  $ips_path[]=trim_bra($str);
  $mail=$ips_path[0];
  $trim=strpos($mail, "@");
  $ips_path=substr($mail, $trim+1);
  echo "ips_path is";
  var_dump ($ips_path);
  return $ips_path;
}

function is_white($ip, $whites){
  for($i=0; $i<count($whites); $i++){
    if(strstr("[".$ip, $whites[$i])){
      return true;
    }
  }
  return false;
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
        $word = str_replace("<", "", $word);
        $word = str_replace(">", "", $word);
        return $word;
}

$ipsWithoutSpace=array();

function uniqlize($ips){
  $ips=array_unique($ips);
  foreach ($ips as $ipsWithoutSpace[]){};
  return $ipsWithoutSpace;
}
?>
