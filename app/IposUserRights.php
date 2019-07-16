<?php

namespace App;


class IposUserRights extends AppModelList {
    
    const CLIENT_SEARCH = 'clientSearch'; 
    const ITEM_SEARCH = 'itemSearch'; 
    const ACTIVITIES = 'activities'; 
    const DASHBOARD = 'dashboard'; 
    const ITEM_REQUESTS = 'itemRequests'; 
    const MOBILE_CHECKOUT = 'mobileCheckout';
    const AML = 'aml';
    
    protected function _init() 
    {
        $this->_add(self::CLIENT_SEARCH, __('Поиск и создание клиентов'));
        $this->_add(self::ITEM_SEARCH, __('Поиск артикула и просмотр остатков'));
        $this->_add(self::ACTIVITIES, __('Активности (контакты с клиентами)'));
        $this->_add(self::DASHBOARD, __('Аналитика'));
        $this->_add(self::ITEM_REQUESTS, __('Запросы товара со склада'));
        $this->_add(self::MOBILE_CHECKOUT, __('Отправка заказа на кассу'));
        $this->_add(self::AML, __('AML'));
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
                case self::MOBILE_CHECKOUT:
                case self::AML:
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

