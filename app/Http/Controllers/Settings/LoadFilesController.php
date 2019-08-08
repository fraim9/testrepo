<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;

use \App\Services\PersonMassDestructionLoader;
use \App\Services\PersonBlockedLoader;
use \App\Services\TerroristLoader;

use App\UserAction;

class LoadFilesController extends BackendController
{
    protected $_aclResource = 'settings';
    
    public function index()
    {
        $data = [];
        $actions = [
                UserAction::PERSON_MASS_DESTRUCTION_LOADED,
                UserAction::PERSON_BLOCKED_LOADED,
                UserAction::TERRORIST_LOADED,
        ];
        $userActions = new UserAction();
        foreach ($actions as $actionCode) {
            $data[$actionCode] = $userActions->find($actionCode);
        }
        
    	return view('settings.loadFiles.index', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $file = $request->file('xmlfile');
            $path = $file->getRealPath();
            
            $xml = simplexml_load_file($path, NULL, LIBXML_NOCDATA);
            if (!$xml) {
                throw new \ErrorException('Can\'t open XML file');
            }
            
            $fileType = $request->typeOfFile;
            
            switch ($fileType) {
                case 'PersonMassDestruction': 
                    $loader = new PersonMassDestructionLoader();
                    $loader->loadToDb($xml);
                    break;
                case 'PersonBlocked': 
                    $loader = new PersonBlockedLoader();
                    $loader->loadToDb($xml);
                    break;
                case 'Terrorist': 
                    $loader = new TerroristLoader();
                    $loader->loadToDb($xml);
                    break;
            }
            
            
            return redirect()->route('loadFiles.index')->with('success', 'Data from file has been loaded');
        } catch (\Exception $e) {
            return redirect()->route('loadFiles.index')->with('danger', $e->getMessage());
        }
        
    }
    
   
    
    
}
