<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;

class TranslationController extends BackendController
{

    public function index()
    {
        $lang = 'en';
        $filename = $this->_getFilename($lang);
        
        $translations = '';
        if (is_readable($filename)) {
            $data = json_decode(file_get_contents($filename));
            
            $rows = [];
            foreach ($data as $key => $value) {
                $rows[] = ($key) . ':' . ($value);
            }
            $translations = implode(PHP_EOL, $rows);
        }
    	return view('settings.translations.index', compact('translations', 'lang'));
    }

    

    public function store(Request $request)
    {
        $object = new \stdClass();
        $translations = $request->input('translations');
        $rows = explode("\n", str_replace("\r", "", $translations));
        if (is_array($rows)) {
            foreach ($rows as $row) {
                $row = trim($row);
                if (!strlen($row) || (strpos($row, ':') === false)) {
                    continue;
                }
                $pair = explode(':', $row);
                $object->{trim($pair[0])} = (trim($pair[1]));
            }
        }
        
        $filename = $this->_getFilename('en');
        file_put_contents($filename, json_encode($object));
	    
	    return redirect()->route('translations.index')->with('success', 'Translates has been saved');
    }
    
    protected function _getFilename($lang = 'en')
    {
        return realpath(__DIR__ . '/../../../../resources/lang/' . $lang . '.json');
    }
    
    
    
}
