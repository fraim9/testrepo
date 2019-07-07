<?php

namespace App\Services;

use App\AuthParameters;

class ExpiredPassportManager
{
    const PRIMARY_TABLE = 'expired_passport_primary';
    const SECONDARY_TABLE = 'expired_passport_secondary';
    
    protected $_authParameters = null;
    
    public function getActiveTablename()
    {
        if ($this->_getAuthParameters()->getPrimary() == 1) {
            return self::PRIMARY_TABLE;
        }
        return self::SECONDARY_TABLE;
    }
    
    public function getInactiveTablename()
    {
        if ($this->_getAuthParameters()->getPrimary() == 1) {
            return self::SECONDARY_TABLE;
        }
        return self::PRIMARY_TABLE;
    }
    
    public function switchTables()
    {
        $model = $this->_getAuthParameters();
        $current = $model->getPrimary();
        $model->setPrimary(($current == 1) ? 0 : 1);
    }
    
    
    protected function _getAuthParameters()
    {
        if ($this->_authParameters === null) {
            $this->_authParameter = new AuthParameters();
        }
        return $this->_authParameter;
    }
    
}