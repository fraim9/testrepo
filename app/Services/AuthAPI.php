<?php

namespace App\Services;

use App\AuthParameters;

use App\Exceptions\ApiExceptionFactory as AEF;
use App\Exceptions\ApiException;

class AuthAPI
{
    
    public function authentication($authKey, $authCode)
    {
        $data = [
                'authKey' => $authKey,
                'authCode' => $authCode,
        ];
        $dataString = json_encode($data);
        
        $url = AuthParameters::apiAuthUrl();
        $url = rtrim($url, '/') . '/api/authentication';
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
        
        return $this->_responseProcessing($responseRaw, $headers);
    }
    
    
    public function validateUserLicense($authToken, $authKey, $userId)
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
        $headers = curl_getinfo($ch);
        curl_close($ch);
        
        $result = $this->_responseProcessing($responseRaw, $headers);
        return ($result->errorCode == 0);
    }
    
    public function checkWebUser($userId)
    {
        $authKey = AuthParameters::authKey();
        $authCode = AuthParameters::authCode();
        
        $authAPI = new AuthAPI();
        $result = $authAPI->authentication($authKey, $authCode);
        if ($result->errorCode == 0) {
            $result2 = $authAPI->validateUserLicense($result->authToken, $authKey, $userId);
            if ($result2 == 1) {
                return true;
            }
        }
        return false;
    }
    
    public function getLicenseInfo()
    {
        $authKey = AuthParameters::authKey();
        $authCode = AuthParameters::authCode();
        
        $authAPI = new AuthAPI();
        $result = $authAPI->authentication($authKey, $authCode);
        if ($result->errorCode == 0) {
        
            $url = AuthParameters::apiAuthUrl();
            $url = rtrim($url, '/') . '/api/licenseInfo';
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            //curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'charset=UTF-8',
                    'Authorization: Bearer ' . $result->authToken,
                    'Content-Length: 0')
                    );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseRaw = curl_exec($ch);
            $headers = curl_getinfo($ch);
            curl_close($ch);
            
            return $this->_responseProcessing($responseRaw, $headers);
        }
    }
    
    protected function _responseProcessing($responseRaw, $headers)
    {
        if ($headers['http_code'] == 200) {
            $result = json_decode($responseRaw);
            switch ($result->errorCode) {
                
                case 0: return $result;
                
                case 1: throw AEF::create(AEF::AUTH_GENERAL);
                case 2: throw AEF::create(AEF::AUTH_AUTH_FAILED);
                case 3: throw AEF::create(AEF::AUTH_NO_LICENSE);
                default: throw new ApiException($result->errorMessage . ' [remote]', $result->errorCode);
            }
        } else if ($headers['http_code'] == 401) {
            throw AEF::create(AEF::AUTH_TOKEN_INVALID);
        }
        
        throw AEF::create(AEF::AUTH_GENERAL);
    }
    
    
    
    
    
    
    
    
    
}