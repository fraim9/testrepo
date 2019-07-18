<?php

namespace App\Services;

use App\AuthParameters;

use App\Exceptions\ApiExceptionFactory as AEF;
use App\Exceptions\ApiException;

class AuthAPI
{
    
    function authentication($authKey, $authCode)
    {
        $data = [
                'authKey' => $authKey,
                'authCode' => $authCode,
        ];
        $dataString = json_encode($data);
        
        $url = AuthParameters::apiAuthUrl();
        $url = rtrim($url, '/') . '/authentication';
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
        switch ($result->errorCode) {
            case 0: return $result;
            case 1: throw AEF::create(AEF::AUTH_GENERAL);
            case 2: throw AEF::create(AEF::AUTH_AUTH_FAILED);
            case 3: throw AEF::create(AEF::AUTH_NO_LICENSE);
            default: throw new ApiException($result->errorMessage, $result->errorCode);
        }
    }
    
    
    function validateUserLicense($authToken, $authKey, $userId)
    {
        $data = [
                'authKey' => $authKey,
                'userId' => $userId,
        ];
        $dataString = json_encode($data);
        
        $url = AuthParameters::apiAuthUrl();
        $url = rtrim($url, '/') . '/api/validateUserLicense';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'charset=UTF-8',
                'Authorization: Bearer ' . $authToken,
                'Content-Length: ' . strlen($dataString))
                );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseRaw = curl_exec($ch);
        curl_close($ch);
        
        $result = json_decode($responseRaw);
        switch ($result->errorCode) {
            case 0: return true;
            case 1: throw AEF::create(AEF::AUTH_GENERAL);
            case 2: throw AEF::create(AEF::AUTH_AUTH_FAILED);
            case 3: throw AEF::create(AEF::AUTH_NO_LICENSE);
            default: throw new ApiException($result->errorMessage, $result->errorCode);
        }
        
    }
    
    
    
    
    
    
    
}