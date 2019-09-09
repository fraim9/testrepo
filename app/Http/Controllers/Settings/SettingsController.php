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
        
        $values = $this->_castValues($request->all());
        $settings->fill($values);
        $settings->save();
	    
	    //return redirect()->route('settings.index')->with('success', 'Settings has been saved');
        return redirect()->route('settings.form', $settings->_id)->with('success', 'Settings has been saved');
    }
    
    protected function _castValues($values)
    {
        if (is_array($values)) {
            $result = [];
            foreach ($values as $key => $value) {
                switch ($key) {
                    case 'nameLat': 
                        $result[$key] = (boolean) $value;
                        break;
                    default:
                        $result[$key] = $this->_castValues($value);
                }
            }
            return $result;
        } else {
            return $values;
        }
    }
    
   
}
