<?php

namespace App;


class StorageTypes extends AppModelList
{
    const LOCAL = 'Local';
    const S3_OBJECT_STORAGE = 'S3ObjectStorage';
    
    protected function _init()
    {
        $this->_add(self::LOCAL, 'Local');
        $this->_add(self::S3_OBJECT_STORAGE, 'S3 object storage');
    }
    
}
