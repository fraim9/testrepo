<?php

namespace App\Services;

class Tools 
{
    public static function createIndexBy(array $objectList, $field = 'id', $field2 = null, $field3 = null)
    {
        $result = array();
        if (is_null($field2) && is_null($field3)) {
            foreach ($objectList as $obj) {
                $result[$obj->{$field}] = $obj;
            }
        } else if (is_null($field3)) {
            foreach ($objectList as $obj) {
                $result[$obj->{$field}][$obj->{$field2}] = $obj;
            }
        } else {
            foreach ($objectList as $obj) {
                $result[$obj->{$field}][$obj->{$field2}][$obj->{$field3}] = $obj;
            }
        }
        return $result;
    }
    
    
}