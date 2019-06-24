<?php

namespace App;


class IposUserRights extends AppModelList {
    
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
    
    public function getRightsValues()
    {
        $values = array();
        $accessLevels = (new IposAccessLevels())->asOptions();
        $dashboardLevels = (new IposDashboardLevels())->asOptions();
        $rights = $this->findAll();
        foreach ($rights as $right) {
            switch ($right->id) {
                case self::CLIENT_SEARCH:
                case self::ITEM_SEARCH:
                case self::ACTIVITIES:
                case self::ITEM_REQUESTS:
                    $values[$right->id] = $accessLevels;
                    break;
                case self::DASHBOARD:
                    $values[$right->id] = $dashboardLevels;
                    break;
            }
        }
        return $values;
    }
    
}

