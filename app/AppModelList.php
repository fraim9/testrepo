<?php

namespace App;

class AppModelList
{
    static protected $_instance = [];
    
    protected $_items = [];
    
    public static function getInstance()
    {
        if (!isset(static::$_instance[static::class])) {
            static::$_instance[static::class] = new static();
        }
        
        return static::$_instance[static::class];
    }
    
    public static function all()
    {
        return static::getInstance()->findAll();
    }
    
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
    
    protected function _add($id, $name, array $options = null)
    {
        $item = new \stdClass();
        $item->id = $id;
        $item->name = $name;
        if (is_array($options)) {
            foreach ($options as $key => $value) {
                $item->{$key} = $value;
            }
        }
        $this->_items[$item->id] = $item;
    }
	
}
