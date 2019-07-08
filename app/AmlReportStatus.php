<?php

namespace App;


class AclResources extends AppModelList {
    
    protected function _init() 
    {
        $this->_add('backendAccess', 'Доступ к OmniPOS BackOffice');
        
        $this->_add('users', 'Управление пользователями');
        $this->_add('userGroups', 'Настройка групп пользователей');
        
        $this->_add('settings', 'Доступ к общим настройкам');

        $this->_add('stores', 'Настройка магазинов');
        $this->_add('storeGroups', 'Настройка групп магазинов');
        $this->_add('prices', 'Настройка типов цен');
        
    }
    
}

