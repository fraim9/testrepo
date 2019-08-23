<?php

namespace App;

class AclResourceGroups extends AppModelList 
{
    const MAIN = 'main';
    const USERS = 'users';
    const STORES = 'stores';
    const COMPANY = 'company';
    const CRM = 'crm';
    const AML = 'aml';
    const SETTINGS = 'settings';

    const API = 'api';
    
    protected function _init()
    {
        $this->_add(self::MAIN, 'Common functions');
        $this->_add(self::SETTINGS, 'General settings');
        $this->_add(self::USERS, 'Users');
        $this->_add(self::STORES, 'Stores');
        $this->_add(self::COMPANY, 'Company');
        $this->_add(self::CRM, 'CRM');
        $this->_add(self::AML, 'AML');

        $this->_add(self::API, 'API');
        
    }
    
}

