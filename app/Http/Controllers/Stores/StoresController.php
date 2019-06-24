<?php

namespace App\Http\Controllers\Stores;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BackendController;
use App\Http\Requests\Store as StoreRequest;
use App\Store;
use App\StoreGroup;
use App\Country;
use App\City;
use App\TimeZone;
use App\Price;

class StoresController extends BackendController
{

    public function index()
    {
        $stores = Store::all();
        return view('stores.stores.index', compact('stores'));
    }

    
    public function form($id)
    {
        $store = $id ? Store::find($id) : null;
        $storeGroups = StoreGroup::orderBy('name')->get();
        $countries = Country::orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $timeZoneModel = new TimeZone();
        $timeZones = $timeZoneModel->asOptions();
        $prices = Price::orderBy('name')->get();
    	return view('stores.stores.form', compact('store', 'storeGroups', 'countries',
    	        'cities', 'timeZones', 'prices'));
    }
    
    public function store(StoreRequest $request, $id)
    {
        $store = $id ? Store::find($id) : null;
    	
        if (!$store) {
            $store = new Store();
            $store->created_by = Auth::id();
            $store->created_date = date('Y-m-d H:i:s');
	    }
	    $store->fill($request->all());
	    
	    $store->modified_date = date('Y-m-d H:i:s');
	    $store->modified_by = Auth::id();
	    $store->save();
	    
	    return redirect()->route('stores.index')->with('success', 'Store has been saved');
    }
    
    public function delete($id)
    {
        $store = Store::find($id);
        $store->delete();
    	
    	return redirect()->route('stores.index')
    	   ->with('success', 'Store has been deleted Successfully');
    }
    
}
