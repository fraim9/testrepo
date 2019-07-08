<?php

namespace App;

class AclResources extends AppModelList {
    
    protected function _init()
    {
        $this->_add('backendAccess', 'Access to OmniPOS BackOffice');
        
        $this->_add('users', 'User management');
        $this->_add('userGroups', 'Setting up user groups');
        
        $this->_add('settings', 'Access to general settings');
        
        $this->_add('stores', 'Setting stores');
        $this->_add('storeGroups', 'Setting up store groups');
        $this->_add('prices', 'Setting price types');

        $this->_add('employees', 'Access to company employees');
        $this->_add('divisions', 'Access to company divisions');
        
        $this->_add('clients', 'Access to clients');
        
    }
    
}

