<?php
function hr($return = false){
  if ($return){
    return "<hr>\n";
  } else {
    echo "<hr>\n";
  }
}

function br($return = false){
  if ($return){
    return "<br>\n";
  } else {
    echo "<br>\n";
  }

}

function dump($var, $return = false){
  if (is_array($var)){
    $out = print_r($var, true);
  } else if (is_object($var)) {
    $out = var_export($var, true);
  } else {
    $out = $var;
  }

  if ($return){
    return "\n<pre>$out</pre>\n";
  } else {
    echo "\n<pre>$out</pre>\n";
  }
}

function getCurrentDateTime(){
  return date("Y-m-d H:i:s");
}

function encryptPassword($password){
  global $config;
  return md5($password . $config['salt']);
}

function strhas($string, $search, $caseSensitive = false){
    if ($caseSensitive){
        return strpos($string, $search) !== false;
    } else {
        return strpos(strtolower($string), strtolower($search)) !== false;
    }
}

function url_get_contents2($url, $useragent='cURL', $headers=false, $follow_redirects=true, $debug=false) {

    // initialise the CURL library
    $ch = curl_init();

    // specify the URL to be retrieved
    curl_setopt($ch, CURLOPT_URL,$url);

    // we want to get the contents of the URL and store it in a variable
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

    // specify the useragent: this is a required courtesy to site owners
    curl_setopt($ch, CURLOPT_USERAGENT, $useragent);

    // ignore SSL errors
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    // return headers as requested
    if ($headers==true){
        curl_setopt($ch, CURLOPT_HEADER,1);
    }

    // only return headers
    if ($headers=='headers only') {
        curl_setopt($ch, CURLOPT_NOBODY ,1);
    }

    // follow redirects - note this is disabled by default in most PHP installs from 4.4.4 up
    if ($follow_redirects==true) {
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    }

    // if debugging, return an array with CURL's debug info and the URL contents
    if ($debug==true) {
        $result['contents']=curl_exec($ch);
        $result['info']=curl_getinfo($ch);
    }

    // otherwise just return the contents as a variable
    else $result=curl_exec($ch);

    // free resources
    curl_close($ch);

    // send back the data
    return $result;
}

function is_logged_in($userName,$password){
    $data = url_get_contents2('http://172.17.0.1:8080/student/login?studentNumber='.$userName.'&password='.$password);
    $data = str_replace("}","",$data);
    $data = str_replace("{","",$data);
    $data = str_replace("\"result\":","",$data);
    $data = str_replace("\"","",$data);
    $data = explode(',',$data);


    foreach($data as $key => $value)
    {
        list($k, $v) = explode(':', $value);
        $result[ $k ] = $v;
    }
    if($result["status"]==200){
        return $result["session"];
    }else{
        return false;
    }
}


function is_authenticated($studentNumber,$session){
    $data = url_get_contents2('http://172.17.0.1:8080/authenticate?studentNumber='.$studentNumber.'&session='.$session);
    $data = str_replace("}","",$data);
    $data = str_replace("{","",$data);
    $data = str_replace("\"result\":","",$data);
    $data = str_replace("\"","",$data);
    $data = explode(',',$data);


    foreach($data as $key => $value)
    {
        list($k, $v) = explode(':', $value);
        $result[ $k ] = $v;
    }
    /*foreach($result as $key => $value)
    {
        echo $key."=>". $value;
        echo "</br>";
    }*/
    if($result["status"]==200){
        return true;
    }else{
        return false;
    }
}
