<?php
// date_default_timezone_set('Asia/Taipei');
include('config.php');

$ch = curl_init(URL);
curl_setopt($ch, CURLOPT_HTTPGET, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(COOKIE));
$result = curl_exec($ch);
// var_dump($result);
// die();
$dom = new DOMDocument;
@$dom->loadHTML($result);
$dom->saveHTML($dom->documentElement);

$xpath = new DOMXPath($dom);
$nodeList = $xpath->query('//span[@class="mzanzahl"]');
$petition_count = $nodeList[0]->nodeValue;
var_dump(trim($petition_count));

