<?php

namespace App;


class IposDashboardLevels extends AppModelList {
    
    const NONE = 'none'; 
    const MY = 'my'; 
    const STORE = 'store'; 
    const ALL = 'all'; 
    
    protected function _init() 
    {
        $this->_add(self::NONE, __('Раздел не отображается'));
        $this->_add(self::MY, __('Просмотр личной статистики'));
        $this->_add(self::STORE, __('Просмотр статистики магазина и всех продавцов магазина'));
        $this->_add(self::ALL, __('Просмотр статистики всех магазинов и всех продавцов магазина'));
    }
    
}

