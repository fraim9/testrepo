<?php

namespace App\Http\Controllers\Company;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BackendController;
use App\Http\Requests\Company as CompanyRequest;
use App\Company;
use App\Country;
use App\City;
use App\TimeZone;
use App\Currency;


class CompanyController extends BackendController
{
    protected $_aclResource = 'companyInfo';
    
    public function index()
    {
        $company = Company::getInfo();
        return view('company.company.index', compact('company'));
    }

    
    public function form()
    {
        $company = Company::getInfo();
        
        $countries = Country::orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $currencies = Currency::orderBy('name')->get();
        $timeZones = (new TimeZone())->asOptions();
        
    	return view('company.company.form', compact('company', 'countries', 'cities', 'currencies', 'timeZones'));
    }
    
    public function store(CompanyRequest $request)
    {
        $company = Company::getInfo();
    	
        if (!$company) {
            $company = new Company();
            $company->created_by = Auth::id();
            $company->created_date = date('Y-m-d H:i:s');
	    }
	    $company->fill($request->all());
	    
	    $company->modified_date = date('Y-m-d H:i:s');
	    $company->modified_by = Auth::id();
	    $company->save();
	    
	    return redirect()->route('company.index')->with('success', 'Company info has been saved');
    }
    
    
}
