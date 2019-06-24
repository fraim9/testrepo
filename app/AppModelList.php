<?php

namespace App;

class AppModelList
{
    protected $_items = [];
    
    public function __construct()
    {
        $this->_init();
    }
    
    public function findAll()
    {
        return $this->_items;
    }
    
    public function find($id)
    {
        return $this->_items[$id] ?? false;
    }
    
    public function asOptions()
    {
        $items = $this->findAll();
        if (!$items) {
            return false;
        }
        $options = array();
        foreach ($items as $item) {
            $options[$item->id] = $item->name;
        }
        return $options;
    }
    
    protected function _init()
    {
    }
    
    protected function _add($id, $name)
    {
        $item = new \stdClass();
        $item->id = $id;
        $item->name = $name;
        $this->_items[$item->id] = $item;
    }
	
}
