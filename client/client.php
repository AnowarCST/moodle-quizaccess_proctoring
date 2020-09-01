<?php

/// MOODLE ADMINISTRATION SETUP STEPS
// 1- Install the plugin
// 2- Enable web service advance feature (Admin > Advanced features)
// 3- Enable XMLRPC protocol (Admin > Plugins > Web services > Manage protocols)
// 4- Create a token for a specific user and for the service 'My service' (Admin > Plugins > Web services > Manage tokens)
// 5- Run this script directly from your browser: you should see 'Hello, FIRSTNAME'
/// SETUP - NEED TO BE CHANGED

function get_camsshots() {
    $token = '440d52bdbbf388c94d3bc03846f3bc51';
    $domainname = 'http://localhost:8080/m/pondit';
    $functionname = 'quizaccess_proctoring_get_camshots';
    header('Content-Type: text/plain');
    $serverurl = $domainname . '/webservice/xmlrpc/server.php' . '?wstoken=' . $token;
    require_once('./curl.php');
    $curl = new curl;
    $post = xmlrpc_encode_request($functionname, array('courseid' => 7));
    $resp = xmlrpc_decode($curl->post($serverurl, $post));
    print_r($resp);
}

function send_camshot() {
    $token = '440d52bdbbf388c94d3bc03846f3bc51';
    $domainname = 'http://localhost:8080/m/pondit';

    $functionname = 'quizaccess_proctoring_get_camshots';
    header('Content-Type: text/plain');
    $serverurl = $domainname . '/webservice/xmlrpc/server.php' . '?wstoken=' . $token;
    require_once('./curl.php');
    $curl = new curl;
    $post = xmlrpc_encode_request($functionname, array('courseid' => 7));
    $resp = xmlrpc_decode($curl->post($serverurl, $post));
    print_r($resp);
}

function upload_file() {
    $token = '440d52bdbbf388c94d3bc03846f3bc51';
    $domainname = 'http://localhost:8080/m/pondit';

    $imagepath = 'db-please-live.png'; //CHANGE THIS !
    $filepath = '/proctoring/'; //put the file to the root of your private file area. //OPTIONAL
    $params = array('file_box' => "@" . $imagepath, 'filepath' => $filepath, 'token' => $token);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
    curl_setopt($ch, CURLOPT_URL, $domainname . '/webservice/upload.php');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    $response = curl_exec($ch);
    print_r($response);
}

upload_file();