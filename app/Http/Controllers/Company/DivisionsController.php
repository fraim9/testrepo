<?php

namespace App\Http\Controllers\Company;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BackendController;
use App\Http\Requests\Division as DivisionRequest;
use App\Division;
use App\ProductColor;
use App\Services\DataImport;
use App\ProductImage;


class DivisionsController extends BackendController
{
    protected $_aclResource = 'divisions';
    
    public function index()
    {
        $query = ProductImage::query();
        $query->whereProductId(2);
        $query->whereCode('W');
        $productImage2 = $query->get();
        
        echo '<pre>';
        print_r($productImage2);
        echo '</pre>';
        exit;
        
        $divisions = Division::all(); 
        return view('company.divisions.index', compact('divisions'));
    }

    
    public function form($id)
    {
        $division = $id ? Division::find($id) : null;
        
    	return view('company.divisions.form', compact('division'));
    }
    
    public function store(DivisionRequest $request, $id)
    {
        $division = $id ? Division::find($id) : null;
    	
        if (!$division) {
            $division = new Division();
            $division->created_by = Auth::id();
            $division->created_date = date('Y-m-d H:i:s');
	    }
	    $division->fill($request->all());
	    
	    $division->modified_date = date('Y-m-d H:i:s');
	    $division->modified_by = Auth::id();
	    $division->save();
	    
	    return redirect()->route('divisions.index')->with('success', 'Division has been saved');
    }
    
    public function delete($id)
    {
        try {
            
            $division = Division::find($id);
            $division->delete();
        	
        	return redirect()->route('divisions.index')
        	   ->with('success', 'Divisions has been deleted Successfully');
        	   
        } catch (\Exception $e) {
            return $this->deleteErrorHandler($e);
        }
    }
    
}
