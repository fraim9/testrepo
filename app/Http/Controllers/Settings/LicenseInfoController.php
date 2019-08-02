<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\BackendController;

use App\Services\AuthAPI;
use App\Exceptions\AppException;


class LicenseInfoController extends BackendController
{
    protected $_aclResource = 'settings';
    
    public function index()
    {
        
        try {
            $authAPI = new AuthAPI();
            $info = $authAPI->getLicenseInfo();
            
        } catch (\Exception $e) {
            throw new AppException($e->getMessage(), $e->getCode());
        }
        
        return view('settings.licenseInfo.index', compact('info'));
    }
    
    
    
    
}
