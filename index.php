<?php

$request = $_SERVER['REQUEST_URI'];
switch ($request) {
    case '/petition' :
        require __DIR__ . '/petition_count.php';
        break;
    case '/signin' :
        require __DIR__ . '/signin.php';
        break;
    case '/register' :
        require __DIR__ . '/register.php';
        break;
    default:
        require __DIR__ . '/404.php';
        break;
}