<?php
error_reporting(E_ALL);

/*
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
curl_close($ch);

$result = json_decode($responseRaw);

echo '<pre>';
print_r($result);
echo '</pre>';


authentication


exit;
*/

$token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX2lkIjoxLCJleHAiOjE1NjM1OTA2MDksImlzcyI6Ik9tbmlQT1MiLCJpYXQiOjE1NjM0NjEwMDl9.iyKzuxxjirM5EkVXQie6KD_6N7GZ8w75cCWXWCl3ZGY';

$data = [];
$method = $_GET['m'];

switch ($method) {
    case 'authentication':
        $data['login'] = 'romano@romano.ru';
        $data['password'] = 'd90x15V4';
        $data['authToken'] = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJodHRwOi8vc2NoZW1hcy54bWxzb2FwLm9yZy93cy8yMDA1LzA1L2lkZW50aXR5L2NsYWltcy9uYW1lIjoiQ0xULURFViIsIkNVU1RPTUVSSUQiOiIxIiwiRU5WQ09ERSI6IkRFViIsIm5iZiI6MTU2MzQ1OTMyMywiZXhwIjoxNTYzNTg4OTIzLCJpc3MiOiJBdXRoU2VydmVyIiwiYXVkIjoiQ3VzdG9tZXJzIn0.lDiCoObJ0y40dhJe1SAc11lIyR0nbKg21IxFe3SzcAk';
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