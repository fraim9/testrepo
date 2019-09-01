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
        $_SESSION['test_api_base_url'] = $baseUrl;
    }
    
} else {
    
    $accessToken = $_SESSION['test_api_access_token'];
    $baseUrl = $_SESSION['test_api_base_url'];
    
}



$data = [];
$method = isset($_GET['m']) ? $_GET['m'] : false;

switch ($method) {
    case 'pull-clients':
        $method = 'clients';
        $httpMethod = 'GET';
        $data['modifiedFrom'] = '2019-06-30T01:00:00';
        //$data['onlyCount'] = '1';
        $data['page'] = '1';
        $data['pageSize'] = '2';
        break;
    case 'amlminis':
        $httpMethod = 'GET';
        
        //$data['modifiedFrom'] = '2019-06-30T01:00:00';
        //$data['onlyCount'] = '1';
        //$data['id'] = '7';
        //$data['page'] = '1';
        //$data['pageSize'] = '2';
        break;
    case 'productSections':
        $httpMethod = 'POST';
        
        $data = [
                [
                        'id' => '',
                        'code' => 'A001',
                        'parentId' => '',
                        'parentCode' => '0',
                        'name' => 'Одежда',
                ],
                [
                        'id' => '',
                        'code' => 'A002',
                        'parentId' => '',
                        'parentCode' => 'A001',
                        'name' => 'Костюмы',
                ],
                [
                        'id' => '',
                        'code' => 'A003',
                        'parentId' => '',
                        'parentCode' => 'A001',
                        'name' => 'Платья',
                ],
                [
                        'id' => '',
                        'code' => 'B001',
                        'parentId' => '',
                        'parentCode' => '0',
                        'name' => 'Косметика',
                ],
                [
                        'id' => '',
                        'code' => 'B002',
                        'parentId' => '',
                        'parentCode' => 'B001',
                        'name' => 'Макияж',
                ],
                [
                        'id' => '',
                        'code' => 'B003',
                        'parentId' => '',
                        'parentCode' => 'B001',
                        'name' => 'Уход за кожей лица',
                ],
                
        ];
        break;
    case 'push-client':
        $method = 'clients';
        $httpMethod = 'POST';
        
        $data = [
                [
                    'id' => '',
                    'code' => '789',
                    'firstName' => 'Махмет',
                    'middleName' => 'Мерзлуевич',
                    'lastName' => 'Абрикосов',
                    'firstNameLat' => '',
                    'lastNameLat' => '',
                    'gender' => 'm',
                    'comment' => 'странный клиент',
                    'phone' => '+79051234567',
                    'email' => 'abricos.cocos@mail.com',
                    
                    'bdDay' => '21',
                    'bdMonth' => '10',
                    'bdYear' => '1988',
                    'birthPlace' => 'Узбекистан аул кабул',
                    
                    'timeZoneId' => '',
                    'timeZoneCode' => 'West Asia Standard Time',
                    
                    'countryCode' => 'UZB',
                    
                    'postcode' => '123456',
                    'city' => 'Самарканд',
                    'address' => 'улица Кабул-абуба 88',
                    
                    'citizenshipCode' => 'RUS',
                    'passportSeries' => '0304',
                    'passportNumber' => '123456',
                    'passportIssuedDate' => '2002-12-02',
                    'passportIssuedBy' => '',
                    'passportSubdivisionCode' => '',
                    'inn' => '1234567890',
                    'registrationAddress' => '',
                    
                    
                    'postalOptIn' => true,
                    'voiceOptIn' => true,
                    'emailOptIn' => true,
                    'msgOptIn' => true,
                    'consentSigned' => true,
                    
                    'employeeId' => '',
                    'employeeCode' => '',
                    
                    'responsibleId' => '',
                    'responsibleCode' => '',
                    
                    'createdEmployeeId' => '',
                    'createdEmployeeCode' => '',
                    
                    'createdStoreId' => '',
                    'createdStoreCode' => 'GUM',
                    
                    'attachedStoreId' => '',
                    'attachedStoreCode' => 'GUM',
                ],
        ];
        break;
    case 'warehouses': 
        $httpMethod = 'POST';
        
        $data = [
                [
                        'id' => '',
                        'code' => 'WW01',
                        'name' => 'Склад №1',
                        'storeId' => '0',
                        'storeCode' => 'GUM',
                ],
                [
                        'id' => '',
                        'code' => 'WW02',
                        'name' => 'Склад №2',
                        'storeId' => '0',
                        'storeCode' => 'GUM',
                ],
        ];
        break;
    case 'stock': 
        $httpMethod = 'POST';
        
        $data = [
                [
                        'warehouseId' => '',
                        'warehouseCode' => 'WW02',
                        'barcode' => '11111',
                        'serialNumber' => '001-001',
                        'physicalQty' => '5',
                        'availableQty' => '3',
                        'reservedQty' => '2',
                        'transferQty' => '1',
                        'deliveryQty' => '5',
                ],
                
        ];
        break;
    case 'sales': 
        $httpMethod = 'POST';
        
        $data = [
                [
                        'id' => 0,
                        'code' => '2019-0456',
                        'checkNumber' => 1,
                        'date' => '2019-08-22T10:00:00',
                        'timeZone' => '+03:00',
                        'dateLocal' => '',
                        'storeCode' => 'GUM',
                        'clientCode' => 'RU03455',
                        'clientId' => '',
                        'employeeCode' => '472',
                        'cashDeskCode' => 'CASH-001',
                        'lines' => [
                                [
                                        'lineNumber' => '',
                                        'salespersonCode' => '267',
                                        'warehouseCode' => 'WW02',
                                        'barcode' => '11111',
                                        'serialNumber' => '001-001',
                                        'quantity' => '2',
                                        'price' => '1000.00',
                                        'discount' => '200',
                                ]
                        ],
                        
                ],
                
        ];
        break;
    case 'brands': 
        $httpMethod = 'POST';
        
        $data = [
                [
                        'id' => 0,
                        'code' => 'CNL',
                        'name' => 'CHANEL',
                        'logo' => base64_encode(file_get_contents('/Users/roman/Downloads/demo_user_key.png')),
                        'logoFormat' => 'png'
                ],
                [
                        'id' => 0,
                        'code' => '7LV',
                        'name' => '7 level',
                ],
                
        ];
        break;
    case 'collections': 
        $httpMethod = 'POST';
        
        $data = [
                [
                        'id' => 0,
                        'code' => 'CH-A-2019',
                        'name' => 'Осень 2019',
                        'description' => 'Что такое осень 2019 года это небо 2019 года',
                        'year' => 2019,
                        'brandCode' => 'CNL',
                ],
                
        ];
        break;
    case 'products': 
        $httpMethod = 'POST';
        
        $data = [
                [
                        'id' => 0,
                        'code' => 'A-00001',
                        'manufactureCode' => 'FKM-754-123',
                        'name' => 'Свитер женский и мужской, два в одном',
                        'shortDescription' => 'Корткий мужской свитер средней длинны и с вырезом под женский свитер большой длинны',
                        'description' => 'Два свитера в одном - просто бросьте таблетку в таз с водой и выбегайте из комнаты. Два свитера по цене одного в тазу лежат не тужат есть не просят лишь глазом косят.',
                        'composition' => 'нитроэтилгидрадхлорофил, путеводная нить, водородная сыпь',
                        'brandCode' => 'CNL',
                        'collectionCode' => 'CH-A-2019',
                        'divisionCode' => '22',
                        'model' => 'пуловер 2112',
                        'colors' => [
                                [
                                        'code' => 'RED-1',
                                        'name' => 'светло-красный',
                                        'hex' => 'ffdddd',
                                        'image' => base64_encode(file_get_contents('/Users/roman/Downloads/demo_user_key.png')),
                                        'imageFormat' => 'png',
                                ],
                                [
                                        'code' => 'RED-2',
                                        'name' => 'красный',
                                        'hex' => 'ff0000',
                                ],
                                [
                                        'code' => 'RED-3',
                                        'name' => 'тёмно-красный',
                                        'hex' => 'dd0000',
                                ],
                        ],
                        'configs' => [
                                [
                                        'code' => 'CONF-001',
                                        'name' => 'с рукавами и шапкой',
                                ],
                                [
                                        'code' => 'CONF-002',
                                        'name' => 'без рукавов и с зонтом',
                                ],
                        ],
                        'sizes' => [
                                [
                                        'code' => 'S',
                                        'name' => 'S',
                                ],
                                [
                                        'code' => 'M',
                                        'name' => 'M',
                                ],
                                [
                                        'code' => 'L',
                                        'name' => 'L',
                                ],
                        ],
                        'seasons' => [
                                [
                                        'code' => 'W',
                                        'name' => 'Зима',
                                ],
                                [
                                        'code' => 'S',
                                        'name' => 'Лето',
                                ],
                        ],
                        'sections' => [1, 2, 3],
                        'items' => [
                                [
                                        'colorCode' => 'RED-1',
                                        'sizeCode' => 'L',
                                        'configCode' => 'CONF-001',
                                        'seasonCode' => 'W',
                                        'gtin' => '1234-56789',
                                        'barcodes' => [
                                                '46392847483',
                                                '46392847484',
                                                '46392847485',
                                                '46392847487',
                                        ],
                                        'serials' => [
                                                'A-00001-7483',
                                                'A-00001-7484',
                                                'A-00001-7485',
                                                'A-00001-7487',
                                        ],
                                ],
                                [
                                        'colorCode' => 'RED-2',
                                        'sizeCode' => 'M',
                                        'configCode' => '',
                                        'seasonCode' => '',
                                        'gtin' => '1234-567123',
                                        'barcodes' => [
                                                '46392847583',
                                                '46392847584',
                                                '46392847585',
                                                '46392847586',
                                        ],
                                        'serials' => [
                                                'A-00001-7583',
                                                'A-00001-7584',
                                                'A-00001-7585',
                                                'A-00001-7586',
                                        ],
                                ],
                        ],
                ],
                
        ];
        break;
    case 'productImage':
        $httpMethod = 'POST';
        
        $data = [
                'productId' => 0,
                'productCode' => 'A-00001',
                'colorCode' => 'RED-2',
                'sizeCode' => 'L',
                'configCode' => 'CONF-002',
                'seasonCode' => 'W',
                'image' => base64_encode(file_get_contents('/Users/roman/Downloads/demo_user_key.png')),
                'imageFormat' => 'png'
        ];
        break;
}







if ($method) {
    $dataString = json_encode($data);   
    
    //$url = 'http://omnipos2.local/api/v0/files/22';
    $url = $baseUrl . '/api/v0/' . $method;
    //$url = 'https://dev.omnipos.cloud/api/v0/' . $method;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $httpMethod);
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
    
    echo '<pre>';
    print_r($responseRaw);
    echo '</pre>';
    
    $result = json_decode($responseRaw);
    
    echo 'URL: ' . $url . '<br>';
    echo 'Method: ' . $method . '<br>';
    echo 'HTTP Code: ' . $headers['http_code'] . '<br>';
    echo '<pre>';
    print_r($result);
    echo '</pre>';
    
}