<?php

namespace App\Services;

use App\FileSequence;
use App\Settings;

class Files 
{
    
    public static function getFullName($fileId)
    {
        if (is_numeric($fileId)) {
            $file = FileSequence::find($fileId);
            if (!$file) {
                return '';    
            }
        } else {
            $file = $fileId;
        }
        
        $path = self::getBasePath($file->cold);
        return rtrim($path, '\\/') . DIRECTORY_SEPARATOR . sprintf("%010d", intval($file->id)) . '.' . $file->extension;
    }
    
    
    
    public static function storeFile($data, $ext, $cold, $userId, $fileId = false)
    {
        $file = null;
        if ($fileId) {
            $file = FileSequence::find($fileId);
        }
        if ($file) {
            @unlink(self::getFullName($file));
        } else {
            $file = new FileSequence();
            $file->created_date = date('Y-m-d H:i:s');
            $file->created_by = $userId;
        }
        $file->extension = $ext;
        $file->cold = $cold;
        $file->save();
        
        $filename = self::getFullName($file);
        
        file_put_contents($filename, $data);
        
        return $file;
    }
    
    public static function deleteFile($fileId)
    {
        $file = FileSequence::find($fileId);
        if (!$file) {
            return '';
        }
        $filename = self::getFullName($file);
        @unlink($filename);
        
        $file->delete();
    }
    
    public static function getBasePath($cold)
    {
        $settings = Settings::Storage();
        if ($cold) {
            $path = $settings->doc['localStorage']['folderPathCold'];
        } else {
            $path = $settings->doc['localStorage']['folderPath'];
        }
        return $path;
    }
    
    
}