<?php

namespace App;


class BarcodeTypes extends AppModelList {
    
    
    protected function _init()
    {
        $this->_add('aztec', 'aztec');
        $this->_add('code128', 'code128');
        $this->_add('code39', 'code39');
        $this->_add('code39Mod43', 'code39Mod43');
        $this->_add('code93', 'code93');
        $this->_add('dataMatrix', 'dataMatrix');
        $this->_add('ean13', 'ean13');
        $this->_add('ean8', 'ean8');
        $this->_add('interleaved2of5', 'interleaved2of5');
        $this->_add('itf14', 'itf14');
        $this->_add('pdf417', 'pdf417');
        $this->_add('qr', 'qr');
        $this->_add('upce', 'upce');
    }
    
}
