<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BackendController;
use App\Http\Requests\AuthParameters as AuthParametersRequest;

use App\AuthParameters;
use Milon\Barcode\Facades\DNS2DFacade as DNS2D;


class AuthParametersController extends BackendController
{
    protected $_aclResource = 'companyInfo';
    
    public function index()
    {
        $parameters = AuthParameters::getParameters();
        
        // {"authKey": "CLT-DEV","authCode": "PSeJcfdSQfzmBrWtV6u7"}
        $forToken = new \stdClass();
        $forToken->authKey = $parameters->auth_key;
        $forToken->authCode = $parameters->auth_code;
        $strToken = json_encode($forToken);
        $token = str_random(3) . base64_encode($strToken);
        
        //DNS2D::getBarcodePNG($token, 'DATAMATRIX', 1000, 100);
        
        return view('settings.authParameters.index', compact('parameters', 'token'));
        
    }

    
    public function form()
    {
        $parameters = AuthParameters::getParameters();
    	return view('settings.authParameters.form', compact('parameters'));
    }
    
    public function store(AuthParametersRequest $request)
    {
        $parameters = AuthParameters::getParameters();
    	
        if (!$parameters) {
            $parameters = new AuthParameters();
            $parameters->id = AuthParameters::DEFAULT_ID;
            $parameters->created_by = Auth::id();
            $parameters->created_date = date('Y-m-d H:i:s');
	    }
	    $parameters->fill($request->all());
	    
	    $parameters->modified_date = date('Y-m-d H:i:s');
	    $parameters->modified_by = Auth::id();
	    $parameters->save();
	    
	    return redirect()->route('authParameters.index')->with('success', 'Auth Parameters has been saved');
    }
    
    
}
