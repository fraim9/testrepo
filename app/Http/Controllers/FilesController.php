<?php

namespace App\Http\Controllers;


class FilesController extends BackendController
{

    
    public function view($filename)
    {
        $fullFilename = $this->_getFullName($filename);
        return response()->file($fullFilename);
    }
    
    public function download($filename)
    {
        $fullFilename = $this->_getFullName($filename);
        return response()->download($fullFilename, $filename);
    }
    
    protected function _getFullName($filename)
    {
        $path = '/Users/roman/WebServers/clt-omnipos2/files';
        $path = '/home/cltmobiftp/htdocs/omnipos/files';
        
        $fullFilename = $path . DIRECTORY_SEPARATOR . $filename;
        if (!is_readable($fullFilename)) {
            abort(404);
        }
        return $fullFilename;
    }
    
}
