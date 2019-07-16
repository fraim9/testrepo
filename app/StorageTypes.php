<?php

namespace App;


class StorageTypes extends AppModelList
{
    const LOCAL = 'Local';
    const YANDEX = 'YandexObjectStorage';
    
    protected function _init()
    {
        $this->_add(self::LOCAL, 'Local');
        $this->_add(self::YANDEX, 'YandexObjectStorage');
    }
    
}
