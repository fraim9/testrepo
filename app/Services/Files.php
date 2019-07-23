<?php

namespace App\Services;

use App\FileSequence;
use App\Settings;

class Files 
{
    
    public static function getFullName($fileId)
    {
        $file = FileSequence::find($fileId);
        if (!$file) {
            return '';    
        }
        
        $settings = Settings::Storage();
        
        if ($file->cold) {
            $path = $settings->doc['localStorage']['folderPathCold'];
        } else {
            $path = $settings->doc['localStorage']['folderPath'];
        }
        
        $fullFilename = rtrim($path, '\\/') . DIRECTORY_SEPARATOR . sprintf("%010d", intval($file->id)) . '.' . $file->extension;
        
        return $fullFilename;
    }
    
    
}