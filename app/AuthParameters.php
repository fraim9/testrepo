<?php

namespace App;


class AuthParameters extends AppModel 
{
	protected $table = 'parameters';
	
	protected $fillable = [];
	
	protected $connection = 'omnipos_auth';
	
	protected $_data = null;
	
	public function getSecretKey()
	{
	    $this->_load();
	    return $this->_data['secretKey'];
	}
	
	public function getPrimary()
	{
	    $this->_load();
	    return $this->_data['primary'];
	}
	
	public function setPrimary($value)
	{
	    $row = $this->find(1);
	    $row->primary = $value;
	    $row->save();
	}
	
	protected function _load()
	{
	    if ($this->_data === null) {
	        $row = $this->find(1);
	        $this->_data = [];
	        $this->_data['secretKey'] = $row ? $row->secret_key : '';
	        $this->_data['primary'] = $row ? $row->primary : '';
	    }
	}
	
}