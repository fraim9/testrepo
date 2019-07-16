<?php

namespace App\Http\Controllers;

use App\FileSequence;
use App\Settings;

class FilesController extends BackendController
{

    
    public function view($fileId)
    {
        $fullFilename = $this->_getFullName($fileId);
        return response()->file($fullFilename);
    }
    
    public function download($fileId)
    {
        $fullFilename = $this->_getFullName($fileId);
        return response()->download($fullFilename,  pathinfo($fullFilename, PATHINFO_BASENAME));
    }
    
    protected function _getFullName($fileId)
    {
        $settings = Settings::Storage();
        $file = FileSequence::findOrFail($fileId);
        
        if ($file->cold) {
            $path = $settings->doc['localStorage']['folderPathCold'];
        } else {
            $path = $settings->doc['localStorage']['folderPath'];
        }
        
        $fullFilename = rtrim($path, '\\/') . DIRECTORY_SEPARATOR . sprintf("%010d", intval($file->id)) . '.' . $file->extension;
        if (!is_readable($fullFilename)) {
            abort(404);
        }
        return $fullFilename;
    }
    
}
