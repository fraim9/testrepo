<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\UserAction;

class TerroristLoader extends XmlFileLoader
{
    protected $_tableName = 'aml_terrorist';
    
    
    public function loadToDb($xml)
    {
        
        $conn = DB::connection('omnipos');
        $conn->statement('TRUNCATE ' . $this->_tableName);
        
        $conn->statement('ALTER TABLE ' . $this->_tableName . ' DISABLE KEYS');

        if (!$xml->TERRORISTS) {
            throw new \Exception('Wrong file!');
        }
        
        foreach ($xml->TERRORISTS as $obj) {
            $matches = array();
            $passport = $this->clearValue($obj->PASSPORT);
            if ($passport && preg_match_all("/([0-9]{4}) ([0-9]{6})/", $passport, $matches)) {
                for ($i=0; $i<count($matches[0]); $i++) {
                    
                    $row = array();
                    //$row->id = $this->clearValue($obj->ID_NEW);
                    $row['name'] = $this->clearValue($obj->TERRORISTS_NAME, 150);
                    $date = $this->toAtom($this->clearValue($obj->BIRTH_DATE));
                    if ($date) {
                        $row['birth_date'] = $date;
                    }
                    $row['inn'] = $this->clearValue($obj->INN, 12);
                    $row['passport'] = $this->clearValue($obj->PASSPORT, 255);
                    
                    $row['passport_series'] = $matches[1][$i];
                    $row['passport_number'] = $matches[2][$i];
                    
                    $row['description'] = $this->clearValue($obj->DESCRIPTION, 255);
                    $row['address'] = $this->clearValue($obj->ADDRESS, 255);
                    $row['resolution'] = $this->clearValue($obj->TERRORISTS_RESOLUTION, 255);
                    $row['birth_place'] = $this->clearValue($obj->BIRTH_PLACE, 150);
                    
                    $this->store($conn, $row);
                }
            } else {
                $row = array();
                //$row->id = $this->clearValue($obj->ID_NEW);
                $row['name'] = $this->clearValue($obj->TERRORISTS_NAME, 150);
                $date = $this->toAtom($this->clearValue($obj->BIRTH_DATE));
                if ($date) {
                    $row['birth_date'] = $date;
                }
                $row['inn'] = $this->clearValue($obj->INN, 12);
                $row['passport'] = $this->clearValue($obj->PASSPORT, 255);
                
                $row['passport_series'] = '';
                $row['passport_number'] = '';
                
                $row['description'] = $this->clearValue($obj->DESCRIPTION, 255);
                $row['address'] = $this->clearValue($obj->ADDRESS, 255);
                $row['resolution'] = $this->clearValue($obj->TERRORISTS_RESOLUTION, 255);
                $row['birth_place'] = $this->clearValue($obj->BIRTH_PLACE, 150);
                
                $this->store($conn, $row);
            }
            
        }
        
        
        $conn->statement('ALTER TABLE ' . $this->_tableName . ' ENABLE KEYS');
        
        $userActions = new UserAction();
        $userActions->setDate(UserAction::TERRORIST_LOADED, date('Y-m-d H:i:s'), Auth::id());
        
    }
    
    
}