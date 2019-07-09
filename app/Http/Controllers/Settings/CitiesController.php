<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BackendController;
use App\Http\Requests\City as CityRequest;
use App\Country;
use App\City;

class CitiesController extends BackendController
{
    protected $_aclResource = 'settings';
    
    public function index()
    {
        $cities = City::orderBy('name')->get();
    	return view('settings.cities.index', compact('cities'));
    }

    public function form($id)
    {
        $city = $id ? City::find($id) : null;
        $countries = Country::orderBy('name')->get();
    	return view('settings.cities.form', compact('city', 'countries'));
    }
    
    public function store(CityRequest $request, $id)
    {
        $city = $id ? City::find($id) : null;
    	
        if (!$city) {
            $city = new City();
            $city->created_by = Auth::id();
            $city->created_date = date('Y-m-d H:i:s');
	    }
	    $city->fill($request->all());
	    $city->modified_date = date('Y-m-d H:i:s');
	    $city->modified_by = Auth::id();
	    $city->save();
	    
	    return redirect()->route('cities.index')->with('success', 'City has been saved');
    }
    
    public function delete($id)
    {
        $country = Country::find($id);
        $country->delete();
    	
    	return redirect()->route('cities.index')
    	   ->with('success', 'City has been deleted Successfully');
    }
    
}
