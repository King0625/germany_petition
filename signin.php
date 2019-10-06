<?php
include "config.php";
$post_data = [
    'email' => trim($_POST['email']),
    'passwort' => trim($_POST['passwort']),
    'mitzeichnerliste_name' => trim($_POST['mitzeichnerliste_name']),
    '_charset_' => trim($_POST['_charset_']),
    'sectimestamp' => trim($_POST['sectimestamp'])
];

// $post_data = [
//     'email' => 'independentchen@gmail.com',
//     'passwort' => 'a7110783A',
//     'mitzeichnerliste_name' => 0,
//     '_charset_' => 'UTF-8',
//     'sectimestamp' => 1570177371186
// ];

$ch = curl_init('https://epetitionen.bundestag.de/petitionen/_2019/_05/_31/Petition_95643.mitzeichnen.form.html');

curl_setopt($ch, CURLOPT_POST, true);
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_NOBODY, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
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
$url = $m[1];
echo $response;
curl_close($ch);
preg_match('/.*(JSESSIONID=.+).;/', $header, $cookie);
// var_dump($cookie);
$jsessionid = $cookie[1];

preg_match('/.*(SERVERID=.+).;/', $header, $cookie);
$serverid = $cookie[1];



if($url == 'https://epetitionen.bundestag.de/petitionen/_2019/_05/_31/Petition_95643.html'){
    echo json_encode(['message' => 'Signin failed!']);
}else{
    echo json_encode(['message' => 'Signin successfully!']);
    // echo "YES";
    // $ch = curl_init('https://epetitionen.bundestag.de/petitionen/_2019/_05/_31/Petition_95643.mitzeichnen.layer.$$$.a.u.html');
    // curl_setopt($ch, CURLOPT_HTTPGET, true);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($ch, CURLOPT_HEADER, true);
    // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    // // curl_setopt($ch, CURLOPT_NOBODY, false);
    // curl_setopt($ch, CURLOPT_HTTPHEADER	, array(
    //     "Connection: keep-alive" . 
    //     "Cookie: renderid=s293; $serverid; $jsessionid" .
    //     "Host: epetitionen.bundestag.de" .
    //     "Referer: https://epetitionen.bundestag.de/petitionen/_2019/_05/_31/Petition_95643.$$$.a.u.html" . 
    //     "Sec-Fetch-Mode: cors" .
    //     "Sec-Fetch-Site: same-origin" . 
    //     "X-Requested-With: XMLHttpRequest" .
    //     "User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36"
    // ));
    
    // $result = curl_exec($ch);

    // echo $result;
}
// 成功：https://epetitionen.bundestag.de/petitionen/_2019/_05/_31/Petition_95643.$$$.a.u.html 
// 失敗：https://epetitionen.bundestag.de/petitionen/_2019/_05/_31/Petition_95643.html

