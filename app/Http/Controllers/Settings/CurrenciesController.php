<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BackendController;
use App\Http\Requests\Currency as CurrencyRequest;
use App\Currency;

class CurrenciesController extends BackendController
{
    protected $_aclResource = 'settings';
    
    public function index()
    {
    	$currencies = Currency::orderBy('name')->get();
    	return view('settings.currencies.index', compact('currencies'));
    }

    
    public function form($id)
    {
    	$currency = $id ? Currency::find($id) : null;
    	return view('settings.currencies.form', compact('currency'));
    }
    
    public function store(CurrencyRequest $request, $id)
    {
    	$currency = $id ? Currency::find($id) : null;
    	
	    if (!$currency) {
	        $currency = new Currency();
	        $currency->created_by = Auth::id();
	        $currency->created_date = date('Y-m-d H:i:s');
	    }
	    $currency->fill($request->all());
	    $currency->modified_date = date('Y-m-d H:i:s');
	    $currency->modified_by = Auth::id();
	    $currency->save();
	    
	    return redirect()->route('currencies.index')->with('success', 'Currency has been saved');
    }
    
    public function delete($id)
    {
        $currency = Currency::find($id);
        $currency->delete();
    	
    	return redirect()->route('currencies.index')
    	   ->with('success', 'Currency has been deleted Successfully');
    }
    
}
