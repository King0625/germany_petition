<?php
include "config.php";
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
  }
  // 成功：https://epetitionen.bundestag.de/content/epet/registrieren.danke.html 
  // 失敗：https://epetitionen.bundestag.de/content/epet/registrieren.html 
?>
