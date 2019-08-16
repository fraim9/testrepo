<?php

namespace App;

class UserSessionTypes extends AppModelList {
    
    const WEB = 0;
    const API = 1;
    
    protected function _init()
    {
        $this->_add(self::WEB, 'Web');
        $this->_add(self::API, 'API');
    }
    
}


