<?php

namespace App;


class AmlReportStatus extends AppModelList {
    
    const DRAFT = 1; 
    const COMPLETED = 2; 
    
    protected function _init() 
    {
        $this->_add(self::DRAFT, 'Черновик');
        $this->_add(self::COMPLETED, 'Подписан');
    }
    
}

