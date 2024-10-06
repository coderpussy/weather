<?php
//$srv_dump = print_r($_SERVER, true);
//$fp = file_put_contents('server-new.log', $srv_dump);
//die();

header('Content-type: text/plain; charset=utf8', true);

function check_header($name, $value = false) {
    if(!isset($_SERVER[$name])) {
        return false;
    }
    if($value && $_SERVER[$name] != $value) {
        return false;
    }
    return true;
}

function sendFile($path) {
    header($_SERVER["SERVER_PROTOCOL"].' 200 OK', true, 200);
    header('Content-Type: application/octet-stream', true);
    header('Content-Disposition: attachment; filename='.basename($path));
    header('Content-Length: '.filesize($path), true);
    header('x-MD5: '.md5_file($path), true);
    readfile($path);
}

$esp = '';

if(check_header('HTTP_USER_AGENT', 'ESP8266-http-Update') || check_header('HTTP_USER_AGENT', 'ESP32-http-Update')) {
    if(check_header('HTTP_USER_AGENT', 'ESP8266-http-Update')) {
        $esp = '8266';
    }
    if(check_header('HTTP_USER_AGENT', 'ESP32-http-Update')) {
        $esp = '32';
    }
} else {
    header($_SERVER["SERVER_PROTOCOL"].' 403 Forbidden', true, 403);
    echo "only for ESP8266 or ESP32 updater!\n";
    exit();
}

if(
    !check_header('HTTP_X_ESP'.$esp.'_STA_MAC') ||
    !check_header('HTTP_X_ESP'.$esp.'_AP_MAC') ||
    !check_header('HTTP_X_ESP'.$esp.'_FREE_SPACE') ||
    !check_header('HTTP_X_ESP'.$esp.'_SKETCH_SIZE') ||
    !check_header('HTTP_X_ESP'.$esp.'_SKETCH_MD5') ||
    !check_header('HTTP_X_ESP'.$esp.'_CHIP_SIZE') ||
    !check_header('HTTP_X_ESP'.$esp.'_SDK_VERSION')
) {
    header($_SERVER["SERVER_PROTOCOL"].' 403 Forbidden', true, 403);
    echo "only for ESP8266 or ESP32 updater! (header)\n";
    exit();
}

// 00:00:00:00:00:00 => outdoor

$db = array(
    "00:00:00:00:00:00" => "outdoor"
);

if(!isset($db[$_SERVER['HTTP_X_ESP'.$esp.'_STA_MAC']])) {
    header($_SERVER["SERVER_PROTOCOL"].' 500 ESP MAC not configured for updates', true, 500);
}

$localBinary = "./bin/".$db[$_SERVER['HTTP_X_ESP'.$esp.'_STA_MAC']].".bin";

// Check if version has been set and does not match, if not, check if
// MD5 hash between local binary and ESP8266 binary do not match if not.
// then no update has been found.
//if((!check_header('HTTP_X_ESP8266_SDK_VERSION') && $db[$_SERVER['HTTP_X_ESP8266_STA_MAC']] != $_SERVER['HTTP_X_ESP8266_VERSION']) || $_SERVER['HTTP_X_ESP8266_SKETCH_MD5'] != md5_file($localBinary)) {
if($_SERVER['HTTP_X_ESP'.$esp.'_SKETCH_MD5'] != md5_file($localBinary)) {
    sendFile($localBinary);
} else {
    header($_SERVER["SERVER_PROTOCOL"].' 304 Not Modified', true, 304);
}

//header($_SERVER["SERVER_PROTOCOL"].' 500 no version for ESP MAC', true, 500);