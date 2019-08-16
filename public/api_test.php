<?php
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['test_api_access_token']) || isset($_GET['clean_token'])) {
    
    //===== ПОЛУЧЕНИЕ AUTH TOKEN ===========================
    
    $data = [
            'authKey' => 'CLT-DEV',
            'authCode' => 'PSeJcfdSQfzmBrWtV6u7',
    ];
    $dataString = json_encode($data);
    
    $url = 'https://auth.omnipos.cloud/api/authentication';
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'charset=UTF-8',
            'Content-Length: ' . strlen($dataString))
            );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $responseRaw = curl_exec($ch);
    $headers = curl_getinfo($ch);
    curl_close($ch);
    
    $result = json_decode($responseRaw);
    
    echo 'URL: ' . $url . '<br>';
    echo 'HTTP Code: ' . $headers['http_code'] . '<br>';
    echo '<pre>';
    print_r($result);
    echo '</pre>';
    
    $authToken = $result->authToken;
    //$baseUrl = $result->apiBaseUrl;
    $baseUrl = 'http://omnipos2.local/';
    
    //===== АВТОРИЗАЦИЯ ПОЛЬЗОВАТЕЛЯ И ПОЛУЧЕНИЕ ACCESS TOKEN ===========================
    
    $data['login'] = 'romano@romano.ru';
    $data['password'] = '12345678';
    $data['authToken'] = $authToken;
    $data['appName'] = 'TestAPI Mad Bot';
    $data['appVersion'] = '2.' . date('s');
    $data['deviceName'] = 'MACBOOK AIR - ' . date('Y-m-d H:i:s');
    $dataString = json_encode($data);
    
    $url = $baseUrl . '/api/v0/authentication';
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'charset=UTF-8',
            //'Authorization: Bearer ' . $token,
            'Content-Length: ' . strlen($dataString))
            );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $responseRaw = curl_exec($ch);
    $headers = curl_getinfo($ch);
    curl_close($ch);
    
    $result = json_decode($responseRaw);
    
    echo 'URL: ' . $url . '<br>';
    echo 'HTTP Code: ' . $headers['http_code'] . '<br>';
    echo '<pre>';
    print_r($result);
    echo '</pre>';
    
    if ($result->errorCode == 0) {
        $accessToken = $result->accessToken;
        $_SESSION['test_api_access_token'] = $accessToken;
    }
    
} else {
    
    $accessToken = $_SESSION['test_api_access_token'];
    
}



$data = [];
$method = isset($_GET['m']) ? $_GET['m'] : false;

switch ($method) {
    case 'clients':
        $data['modifiedFrom'] = '2019-06-30T01:00:00';
        //$data['onlyCount'] = '1';
        $data['page'] = '1';
        $data['pageSize'] = '2';
        break;
    case 'amlminis':
        //$data['modifiedFrom'] = '2019-06-30T01:00:00';
        //$data['onlyCount'] = '1';
        //$data['id'] = '7';
        //$data['page'] = '1';
        //$data['pageSize'] = '2';
        break;
}



if ($method) {
    $dataString = json_encode($data);   
    
    //$url = 'http://omnipos2.local/api/v0/files/22';
    $url = $baseUrl . '/api/v0/' . $method;
    //$url = 'https://dev.omnipos.cloud/api/v0/' . $method;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'charset=UTF-8',
            'Authorization: Bearer ' . $accessToken,
            'Content-Length: ' . strlen($dataString))
            );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //curl_setopt($ch, CURLOPT_HEADER, true); 
    $responseRaw = curl_exec($ch);
    $headers = curl_getinfo($ch);
    curl_close($ch);
    
    $result = json_decode($responseRaw);
    
    echo 'URL: ' . $url . '<br>';
    echo 'Method: ' . $method . '<br>';
    echo 'HTTP Code: ' . $headers['http_code'] . '<br>';
    echo '<pre>';
    print_r($result);
    echo '</pre>';
    
}