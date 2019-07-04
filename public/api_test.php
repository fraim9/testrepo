<?php
error_reporting(E_ALL);

$token = '1cecc8fb-fb47-4c8a-af3d-d34c1ead8c4f';
$data = [];
$method = $_GET['m'];

switch ($method) {
    case 'authentication':
        $data['login'] = 'romano@romano.ru';
        $data['password'] = 'd90x15V4';
        break;
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
    
    $url = 'http://omnipos2.local/api/v0/' . $method;
    //$url = 'https://dev.omnipos.cloud/api/v0/' . $method;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'charset=UTF-8',
            'Authorization: Bearer ' . $token,
            'Content-Length: ' . strlen($dataString))
            );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $responseRaw = curl_exec($ch);
    curl_close($ch);
    
    $result = json_decode($responseRaw);
    
    echo 'URL: ' . $url . '<br>';
    echo 'Method: ' . $method . '<br>';
    echo 'Token: ' . $token . '<br>';
    echo 'Request data: ' . json_encode($data) . '<br>';
    echo 'Response raw: ' . $responseRaw . '<br>';
    echo 'Decoded response:';
    echo '<pre>';
    print_r($result);
    echo '</pre>';
}