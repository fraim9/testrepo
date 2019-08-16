<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

trait Filter
{
    protected $_filterFields = [];
    
    
    
    public function filter(Request $request)
    {
        $filter = $this->_getFilter($request);
        foreach ($this->_filterFields as $field) {
            if ($request->has($field)) {
                $filter->{$field} = $request->get($field);
            }
        }
        $key = $this->_key();
        session()->put($key, $filter);
    }
    
    protected function _getFilter()
    {
        $key = $this->_key();
        $filter = new \stdClass();
        $obj = null;
        if (session()->has($key)) {
            $obj = session()->get($key);
        }
        foreach ($this->_filterFields as $field) {
            $filter->{$field} = ($obj && isset($obj->{$field})) ? $obj->{$field} : '';
        }
        return $filter;
    }
    
    protected function _setFilterFields(array $fields)
    {
        $this->_filterFields = $fields;
    }
    
    protected function _key()
    {
        return __CLASS__ . '\Filter';
    }
    
    
    
}