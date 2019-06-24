<?php

namespace App;


class IposDashboardLevels extends AppModelList {
    
    const NONE = 'none'; 
    const MY = 'my'; 
    const STORE = 'store'; 
    const ALL = 'all'; 
    
    protected function _init() 
    {
        $this->_add(self::NONE, 'Раздел не отображается');
        $this->_add(self::MY, 'Просмотр личной статистики');
        $this->_add(self::STORE, 'Просмотр статистики магазина и всех продавцов магазина');
        $this->_add(self::ALL, 'Просмотр статистики всех магазинов и всех продавцов магазина');
    }
    
}

