<?php

namespace App\Services;

class XmlFileLoader 
{
    
    function toAtom($date)
    {
        if (!strlen($date)) {
            return null;
        }
        if (is_numeric($date)) {
            $dd[2] = $date;
            $dd[1] = 1;
            $dd[0] = 1;
        } else {
            $dd = explode('.', $date);
            if (count($dd) != 3) {
                return false;
            }
        }
        
        $year = intval($dd[2]);
        if (!$year) {
            return null;
        }
        $month = intval($dd[1]);
        $month = $month ? $month : 1;
        $day = intval($dd[0]);
        $day = $day ? $day : 1;
        
        return $year . '-' . $month . '-' . $day;
    }
    
    
    function clearValue($value, $length = 0)
    {
        $value = str_replace(array('<![CDATA[', ']]>', "\r", "\n"), array('','', '', ''), (string) $value);
        return $length ? mb_substr($value, 0, $length) : $value;
    }
    
    
    function store($conn, $row)
    {
        $fields = array_map(function($value) { return '`' . $value . '`'; }, array_keys($row));
        $values = array_map(function($value) { return ($value === null) ? 'NULL' : '"' . addslashes($value) . '"'; }, $row);
        $sql = 'INSERT INTO `' . $this->_tableName . '` (' . implode(',', $fields) . ') VALUES (' . implode(',', $values) . ')';
        //echo $sql; exit;
        $conn->statement($sql);
    }
    
}