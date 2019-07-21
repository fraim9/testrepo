<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BackendController;
use App\Http\Requests\AuthParameters as AuthParametersRequest;

use App\AuthParameters;


class AuthParametersController extends BackendController
{
    protected $_aclResource = 'companyInfo';
    
    public function index()
    {
        $parameters = AuthParameters::getParameters();
        return view('settings.authParameters.index', compact('parameters'));
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
