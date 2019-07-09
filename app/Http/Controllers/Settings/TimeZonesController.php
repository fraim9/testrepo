<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\BackendController;
use App\Http\Requests\TimeZone as TimeZoneRequest;
use App\TimeZone;

class TimeZonesController extends BackendController
{
    protected $_aclResource = 'settings';
    
    public function index()
    {
        $zones = TimeZone::orderBy('name')->get();
    	return view('settings.timeZones.index', compact('zones'));
    }

    
    public function form($id)
    {
        $zone = $id ? TimeZone::find($id) : null;
    	return view('settings.timeZones.form', compact('zone'));
    }
    
    public function store(TimeZoneRequest $request, $id)
    {
        $zone = $id ? TimeZone::find($id) : null;
    	
        if (!$zone) {
            $zone = new TimeZone();
	    }
	    $zone->fill($request->all());
	    $zone->save();
	    
	    return redirect()->route('timeZones.index')->with('success', 'Time zone has been saved');
    }
    
    public function delete($id)
    {
        $zone = TimeZone::find($id);
        $zone->delete();
    	
    	return redirect()->route('timeZones.index')
    	   ->with('success', 'Time zone has been deleted Successfully');
    }
    
}
