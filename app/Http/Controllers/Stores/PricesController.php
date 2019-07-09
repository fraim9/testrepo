<?php

namespace App\Http\Controllers\Stores;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BackendController;
use App\Http\Requests\Prices as PricesRequest;
use App\Price;

class PricesController extends BackendController
{
    protected $_aclResource = 'prices';
    
    public function index()
    {
        $prices = Price::all();
        return view('stores.prices.index', compact('prices'));
    }

    
    public function form($id)
    {
        $price = $id ? Price::find($id) : null;
    	return view('stores.prices.form', compact('price'));
    }
    
    public function store(PricesRequest $request, $id)
    {
        $price = $id ? Price::find($id) : null;
    	
        if (!$price) {
            $price = new Price();
            $price->created_by = Auth::id();
            $price->created_date = date('Y-m-d H:i:s');
	    }
	    $price->fill($request->all());
        
	    $price->modified_date = date('Y-m-d H:i:s');
	    $price->modified_by = Auth::id();
	    $price->save();
	    
	    return redirect()->route('prices.index')->with('success', 'Price group has been saved');
    }
    
    public function delete($id)
    {
        $price = Price::find($id);
        $price->delete();
    	
    	return redirect()->route('prices.index')
    	   ->with('success', 'Price group has been deleted Successfully');
    }
    
}
