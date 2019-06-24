<?php

namespace App;


class IposAccessLevels extends AppModelList {
    
    const NO_ACCESS = 'NoAccess'; 
    const READ_ONLY = 'Read'; 
    const MODIFY = 'Modify'; 
    
    protected function _init() 
    {
        $this->_add(self::NO_ACCESS, 'No access');
        $this->_add(self::READ_ONLY, 'Read only');
        $this->_add(self::MODIFY, 'Can modify');
    }
    
}

