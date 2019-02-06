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
/**
 * Get header Authorization
 * */
function getAuthorizationHeader(){
    $headers = null;
    if (isset($_SERVER['Authorization'])) {
        $headers = trim($_SERVER["Authorization"]);
    }
    else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
        $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
    } elseif (function_exists('apache_request_headers')) {
        $requestHeaders = apache_request_headers();
        // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
        $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
        //print_r($requestHeaders);
        if (isset($requestHeaders['Authorization'])) {
            $headers = trim($requestHeaders['Authorization']);
        }
    }
    return $headers;
}
/**
 * get access token from header
 * */
function getBearerToken() {
    $headers = getAuthorizationHeader();
    // HEADER: Get the access token from the header
    if (!empty($headers)) {
        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
            return $matches[1];
        }
    }
    return null;
}

function is_token_expired($registeredTime,$typeOfToken){
    date_default_timezone_set('Asia/Tehran');
    $now = new DateTime(date("Y-m-d H:i:s"));
    $registeredTime = new DateTime($registeredTime);
    $diff = $now->diff($registeredTime);
    $hours = $diff->h;
    $hours = $hours + ($diff->days*24);
    if($typeOfToken == "T"){
        if($hours < 2) {
            return true;//valid token
        }
        return false;//token has been expiered
    }
    if($hours < 5){
        return true;//valid refresh token
    }

    return false;//login again
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
    $data = url_get_contents2('http://172.19.0.1:8080/student/login?studentNumber='.$userName.'&password='.$password);
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
