<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BackendController;
use App\Http\Requests\Country as CountryRequest;
use App\Country;

class CountriesController extends BackendController
{

    public function index()
    {
    	$countries = Country::orderBy('name')->get();
    	return view('settings.countries.index', compact('countries'));
    }

    
    public function form($id)
    {
    	$country = $id ? Country::find($id) : null;
    	return view('settings.countries.form', compact('country'));
    }
    
    public function store(CountryRequest $request, $id)
    {
    	$country = $id ? Country::find($id) : null;
    	
	    if (!$country) {
	        $country = new Country();
	        $country->created_by = Auth::id();
	        $country->created_date = date('Y-m-d H:i:s');
	    }
	    $country->fill($request->all());
	    $country->modified_date = date('Y-m-d H:i:s');
	    $country->modified_by = Auth::id();
	    $country->save();
	    
	    return redirect()->route('countries.index')->with('success', 'Country has been saved');
    }
    
    public function delete($id)
    {
        $country = Country::find($id);
        $country->delete();
    	
    	return redirect()->route('countries.index')
    	   ->with('success', 'Country has been deleted Successfully');
    }
    
}
