<?php
include('config.php');

$ch = curl_init('https://epetitionen.bundestag.de/petitionen/_2019/_05/_31/Petition_95643.mitzeichnen.html');
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
$petition_count = trim($nodeList[0]->nodeValue);
// var_dump(trim($petition_count));
echo json_encode(['petition_count' => $petition_count]);
