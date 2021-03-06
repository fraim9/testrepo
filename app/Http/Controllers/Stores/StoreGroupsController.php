<?php

namespace App\Http\Controllers\Stores;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BackendController;
use App\Http\Requests\StoreGroup as StoreGroupRequest;
use App\StoreGroup;
use App\IposFeatures;

class StoreGroupsController extends BackendController
{
    protected $_aclResource = 'storeGroups';

    public function index()
    {
        $groups = StoreGroup::all();
        $iposFeatures = (new IposFeatures())->findAll();
        return view('stores.storeGroups.index', compact('groups', 'iposFeatures'));
    }

    
    public function form($id)
    {
        $group = $id ? StoreGroup::find($id) : null;
        $iposFeatures = IposFeatures::all();
    	return view('stores.storeGroups.form', compact('group', 'iposFeatures'));
    }
    
    public function store(StoreGroupRequest $request, $id)
    {
        $group = $id ? StoreGroup::find($id) : null;
    	
        if (!$group) {
            $group = new StoreGroup();
            $group->created_by = Auth::id();
            $group->created_date = date('Y-m-d H:i:s');
	    }
	    $group->fill($request->all());
	    
	    $iposFeatures = (new IposFeatures())->findAll();
	    $settings = [];
	    foreach ($iposFeatures as $iposFeature) {
	        $settings[$iposFeature->id] = ($request->input('ipos_settings.' . $iposFeature->id) == 1) ? true : false;
	    }
	    $group->ipos_settings = $settings;
        
	    $group->modified_date = date('Y-m-d H:i:s');
	    $group->modified_by = Auth::id();
	    $group->save();
	    
	    return redirect()->route('storeGroups.index')->with('success', 'Store group has been saved');
    }
    
    public function delete($id)
    {
        $group = StoreGroup::find($id);
        $group->delete();
    	
    	return redirect()->route('storeGroups.index')
    	   ->with('success', 'Store group has been deleted Successfully');
    }
    
}
