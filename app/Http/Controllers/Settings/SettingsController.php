<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Settings;
use App\BarcodeTypes;
use App\StorageTypes;

class SettingsController extends BackendController
{
    protected $_aclResource = 'settings';
    
    public function index()
    {
        $settingsList = Settings::all();
    	return view('settings.settings.index', compact('settingsList'));
    }

    public function form($id)
    {
        $settings = Settings::findOrFail($id);
        $storageTypes = StorageTypes::all();
        $barcodes = BarcodeTypes::all();
        
        return view('settings.settings.form', compact('settings', 'barcodes', 'storageTypes'));
    }
    
    
    public function store(Request $request, $id)
    {
        $settings = Settings::findOrFail($id);
        $settings->fill($request->all());
        $settings->save();
	    
	    return redirect()->route('settings.index')->with('success', 'Settings has been saved');
    }
    
    
   
}
