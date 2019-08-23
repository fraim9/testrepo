<?php

namespace App\Services;


class ReturnHelper
{
    
    public static function set($url, $key = null)
    {
        $key = $key ?: 'default';
        $storage = session()->has('returnHelperStorage') ? session()->get('returnHelperStorage') : [];
        $storage[$key] = $url;
        session()->put('returnHelperStorage', $storage);
    }
    
    public static function get($key = null)
    {
        $key = $key ?: 'default';
        $storage = session()->has('returnHelperStorage') ? session()->get('returnHelperStorage') : [];
        return isset($storage[$key]) ? $storage[$key] : null;
    }
    
    public static function pull($key = null)
    {
        $key = $key ?: 'default';
        $storage = session()->has('returnHelperStorage') ? session()->get('returnHelperStorage') : [];
        if (isset($storage[$key])) {
            $value = $storage[$key];
            unset($storage[$key]);
            session()->put('returnHelperStorage', $storage);
            return $value;
        }
        return null;
    }
    
}