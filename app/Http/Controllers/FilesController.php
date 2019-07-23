<?php

namespace App\Http\Controllers;

use App\Services\Files as FileService;

class FilesController extends BackendController
{

    
    public function view($fileId)
    {
        $fullFilename = FileService::getFullName($fileId);
        
        if (!$fullFilename || !is_readable($fullFilename)) {
            abort(404);
        }
        
        return response()->file($fullFilename);
    }
    
    public function download($fileId)
    {
        $fullFilename = FileService::getFullName($fileId);
        
        if (!$fullFilename || !is_readable($fullFilename)) {
            abort(404);
        }
        
        return response()->download($fullFilename, pathinfo($fullFilename, PATHINFO_BASENAME));
    }
    
   
    
}
