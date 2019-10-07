<?php
include "config.php";
// header("Access-Control-Allow-Methods: POST");

$error = array();

if(empty($_POST['email'])){
  $error['email'] = '電子郵件為必填';
}elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
  $error['email'] = '須符合電子郵件格式';
}

$uppercase = preg_match('@[A-Z]@', $_POST['passwort']);
$lowercase = preg_match('@[a-z]@', $_POST['passwort']);
$special_char = preg_match('@[^\da-zA-Z]@', $_POST['passwort']);
$number    = preg_match('@[0-9]@', $_POST['passwort']);
if(empty($_POST['passwort'])){
  $error['passwort'] = '密碼為必填';
}elseif(!$uppercase || !$lowercase || !($number || $special_char) || strlen($_POST['passwort']) < 8) {
  $error['passwort'] = '密碼不符合格式 ( 您的密碼必須至少8個字符長。它必須至少包含一個大寫字母和一個小寫字母，以及一個數字或特殊字符（例如: _＃@ * + ?!-$）。 )';
}

if(empty($_POST['passwort_wiederholen'])){
  $error['passwort_wiederholen'] = '請再次確認密碼';
}elseif($_POST['passwort'] != $_POST['passwort_wiederholen']){
  $error['passwort_wiederholen'] = '確認密碼必須與原本密碼相同';
}

if(!$_POST['datenschutz_ok']){
  $error['datenschutz_ok'] = '請確認您同意程序原則和隱私聲明';
}

if(!$_POST['nutzungsbed_ok']){
  $error['nutzungsbed_ok'] = '請確認您同意使用條款';
}

if(empty($_POST['vorname'])){
  $error['vorname'] = '名字為必填';
}

if(empty($_POST['nachname'])){
  $error['nachname'] = '姓氏為必填';
}

if(empty($_POST['str_nr'])){
  $error['str_nr'] = '地址為必填';
}

if(empty($_POST['plz'])){
  $error['plz'] = '郵遞區號為必填';
}

if(empty($_POST['ort'])){
  $error['ort'] = '居住城市為必填';
}

if(empty($_POST['land'])){
  $error['land'] = '居住國家為必填';
}

if(!empty($error)){
  echo json_encode($error, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT );
  die();
}

$post_data = [
  'email' => trim($_POST['email']),
  'passwort' => trim($_POST['passwort']),
  'passwort_wiederholen' => trim($_POST['passwort_wiederholen']),
  'datenschutz_ok' => trim($_POST['datenschutz_ok']),
  'nutzungsbed_ok' => trim($_POST['nutzungsbed_ok']),
  'vorname' => trim($_POST['vorname']),
  'nachname' => trim($_POST['nachname']),
  'str_nr' => trim($_POST['str_nr']),
  'plz' => trim($_POST['plz']),
  'ort' => trim($_POST['ort']),
  'land' => trim($_POST['land']),
  'btAbsendenMitRegistrieren' => trim($_POST['btAbsendenMitRegistrieren']),
  '_charset_' => trim($_POST['_charset_']),
  'sectimestamp' => trim($_POST['sectimestamp']),
  'JavaScriptEnable' => trim($_POST['JavaScriptEnable'])
];
// $post_data = $_POST;
// var_dump($post_data);
// die();
  $ch = curl_init('https://epetitionen.bundestag.de/epet/registrieren.form.html');
  
  curl_setopt($ch, CURLOPT_POST, true);
  // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
  curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_NOBODY, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
  curl_setopt($ch, CURLOPT_HTTPHEADER	, array(
    COOKIE .
    'Origin: https://epetitionen.bundestag.de' .
    'Content-type: application/x-www-form-urlencoded'
  ));

  $response = curl_exec($ch);
  
  $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
  $header = substr($response, 0, $header_size);
  $body = substr($response, $header_size);
  preg_match('/.*location: (http[a-z\:\/\/\.]+).*/', $header, $m);
  // var_dump($m);
  // die();
  $url = $m[1];
  // echo $response;
  // die();

  curl_close($ch);

  if($url == 'https://epetitionen.bundestag.de/content/epet/registrieren.danke.html'){
    echo json_encode(['message' => 'Register successfully!!']);
  }elseif($url == 'https://epetitionen.bundestag.de/content/epet/registrieren.html'){
    echo json_encode(['message' => 'Register failed. Please check your email.']);
  }else{
    echo json_encode(['message' => 'Request error!!']);
  }
  // 成功：https://epetitionen.bundestag.de/content/epet/registrieren.danke.html 
  // 失敗：https://epetitionen.bundestag.de/content/epet/registrieren.html 
?>
