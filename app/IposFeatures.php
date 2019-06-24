<?php

namespace App;


class IposFeatures extends AppModelList 
{
    const CLIENT_SEARCH = 'clientSearch'; 
    const ITEM_SEARCH = 'itemSearch'; 
    const ACTIVITIES = 'activities'; 
    const DASHBOARD = 'dashboard'; 
    const ITEM_REQUESTS = 'itemRequests'; 
    
    protected function _init() 
    {
        $this->_add(self::CLIENT_SEARCH, 'Поиск и создание клиентов');
        $this->_add(self::ITEM_SEARCH, 'Поиск артикула и просмотр остатков');
        $this->_add(self::ACTIVITIES, 'Активности (контакты с клиентами)');
        $this->_add(self::DASHBOARD, 'Аналитика');
        $this->_add(self::ITEM_REQUESTS, 'Запросы товара со склада');
    }
    
}

