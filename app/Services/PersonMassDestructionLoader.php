<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\UserAction;

class PersonMassDestructionLoader extends XmlFileLoader
{
    protected $_tableName = 'aml_person_mass_destruction';
    
    
    public function loadToDb($xml)
    {
        
        $conn = DB::connection('omnipos');
        $conn->statement('TRUNCATE ' . $this->_tableName);
        
        $conn->statement('ALTER TABLE ' . $this->_tableName . ' DISABLE KEYS');

        if (!$xml->АктуальныйСписок->Субъект) {
            throw new \Exception('Wrong file!');
        }
        
        foreach ($xml->АктуальныйСписок->Субъект as $obj) {
            
            $row = array();
            $faceType = '';
            
            // Юр Лицо
            if ($obj->ТипСубъекта->Идентификатор == 1) {
                $faceType = 'legal';
                
                $row['name'] = $this->clearValue($obj->ЮЛ->Наименование, 150);
                $row['name_lat'] = $this->clearValue($obj->ЮЛ->НаименованиеЛат, 150);
            }
            
            
            // Физ Лицо
            if ($obj->ТипСубъекта->Идентификатор == 2) {
                $faceType = 'natural';
                
                $row['name'] = $this->clearValue($obj->ФЛ->ФИО, 150);
                $row['name_lat'] = $this->clearValue($obj->ФЛ->ФИОЛат, 150);
                
                if ($obj->ФЛ->ДатаРождения) {
                    $row['birth_date'] = $this->clearValue($obj->ФЛ->ДатаРождения);
                }
                
                if ($obj->ФЛ->СписокДрНаименований->ДрНаименование) {
                    $altNames = array();
                    foreach ($obj->ФЛ->СписокДрНаименований->ДрНаименование as $altName) {
                        $altNames[] = $this->clearValue($altName->ФИО);
                    }
                    $row['name_alt'] = $this->clearValue(count($altNames) ? implode(', ', $altNames) : '', 255);
                }
                
                if ($obj->ФЛ->СписокДокументов->Документ) {
                    $docs = array();
                    foreach ($obj->ФЛ->СписокДокументов->Документ as $doc) {
                        $d = new \stdClass();
                        $d->number = $this->clearValue($doc->Номер);
                        $d->date = $this->clearValue($doc->ДатаВыдачи);
                        $d->issued = $this->clearValue($doc->ОрганВыдачи, 150);
                        $docs[] = $d;
                    }
                    $row['docs'] = $docs;
                }
            }
            
            if ($obj->СписокАдресов->Адрес) {
                $addresses = [];
                foreach ($obj->СписокАдресов->Адрес as $address) {
                    $addresses[] = $this->clearValue($address->ТекстАдреса);
                }
                $row['address'] = $this->clearValue(count($addresses) ? implode(', ', $addresses) : '', 255);
            }
            
            $row['description'] = $this->clearValue($obj->Примечание, 255);
            
            if ($faceType == 'legal') {
                $this->store($conn, $row);
            }
            
            if ($faceType == 'natural') {
                if (isset($row['docs'])) {
                    $docs = $row['docs'];
                    unset($row['docs']);
                    foreach ($docs as $doc) {
                        $row['passport_number'] = $doc->number ? $doc->number : null;
                        $row['passport_issued_date'] = strlen($doc->date) ? $doc->date : null;
                        $row['passport_issued_by'] = $doc->issued ? $doc->issued : null;
                        $this->store($conn, $row);
                    }
                } else {
                    $this->store($conn, $row);
                }
            }
            
        }
        
        
        $conn->statement('ALTER TABLE ' . $this->_tableName . ' ENABLE KEYS');
        
        
        $userActions = new UserAction();
        $userActions->setDate(UserAction::PERSON_MASS_DESTRUCTION_LOADED, date('Y-m-d H:i:s'), Auth::id());
    }
    
    
}