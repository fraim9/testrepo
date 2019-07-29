<?php

namespace App\Services;

use App\Client;
use App\Amlmini;

class DataExport 
{
    const DATETIME_FORMAT = 'Y-m-d\TH:i:s';
    
    public function getClient($id)
    {
        $client = Client::find($id);
        return $client ? $this->_client2obj($client) : null;
    }
    
    public function getClients($modifiedFrom, $onlyCount, $page, $pageSize)
    {
        $select = Client::offset(($page-1) * $pageSize)->limit($pageSize);
        if ($modifiedFrom) {
            $select->where('modified_date', '>=', $modifiedFrom);
        }
        if ($onlyCount) {
            return $select->count();
        } else {
            $clients = $select->get();
            if ($clients) {
                $list = [];
                foreach ($clients as $client) {
                    $list[] = $this->_client2obj($client);
                }
                return $list;
            }
            return null;
        }
    }
    
    protected function _client2obj($client)
    {
        $obj = new \stdClass();
        $obj->id = $client->id;
        $obj->code = $client->code;
        $obj->firstName = $client->first_name;
        $obj->middleName = $client->middle_name;
        $obj->lastName = $client->last_name;
        $obj->firstNameLat = $client->first_name_lat;
        $obj->lastNameLat = $client->last_name_lat;
        $obj->gender = $client->gender;
        $obj->comment = $client->comment;
        $obj->phone = $client->phone;
        $obj->email = $client->email;
        $obj->bdDay = $client->bd_day;
        $obj->bdMonth = $client->bd_month;
        $obj->bdYear = $client->bd_year;
        $obj->birthPlace = $client->birth_place;
        $obj->timeZone = $this->_relVal($client->timeZone, 'offset');
        $obj->countryCode = $this->_relVal($client->country, 'iso3');
        $obj->postcode = $client->postcode;
        $obj->city = $client->city;
        $obj->address = $client->address;
        $obj->citizenshipCode = $this->_relVal($client->citizenship, 'iso3');
        $obj->passportSeries = $client->passport_series;
        $obj->passportNumber = $client->passport_number;
        $obj->passportIssuedDate = $client->passport_issued_date;
        $obj->passportIssuedBy = $client->passport_issued_by;
        $obj->passportSubdivisionCode = $client->id;
        $obj->inn = $client->inn;
        $obj->registrationAddress = $client->registration_address;
        $obj->postalOptIn = ($client->postal_opt_in == 1);
        $obj->voiceOptIn = ($client->voice_opt_in == 1);
        $obj->emailOptIn = ($client->email_opt_in == 1);
        $obj->msgOptIn = ($client->msg_opt_in == 1);
        $obj->consentFileId = $client->consent_file_id;
        $obj->agreementSigned = ($client->agreement_signed == 1);
        $obj->employeeId = $client->employee_id;
        $obj->employeeCode = $this->_relVal($client->employee, 'code');
        $obj->responsibleId = $client->responsible_id;
        $obj->responsibleCode = $this->_relVal($client->responsible, 'code');
        $obj->createdEmployeeId = $client->created_employee_id;
        $obj->createdEmployeeCode = $this->_relVal($client->createdEmployee, 'code');
        $obj->createdStoreId = $client->created_store_id;
        $obj->createdStoreCode = $this->_relVal($client->createdStore, 'code');
        $obj->attachedStoreId = $client->attached_store_id;
        $obj->attachedStoreCode = $this->_relVal($client->attachedStore, 'code');
        $obj->createdDate = $this->_datetime($client->created_date);
        $obj->createdBy = $client->created_by;
        $obj->modifiedDate = $this->_datetime($client->modified_date);
        $obj->modifiedBy = $client->modified_by;
        
        return $obj;
    }
    
    
    public function getAmlmini($id)
    {
        $amlmini = AmlMini::find($id);
        return $amlmini ? $this->_amlmini2obj($amlmini) : null;
    }
    
    public function getAmlminis($modifiedFrom, $clientId, $onlyCount, $page, $pageSize)
    {
        $select = AmlMini::offset(($page-1) * $pageSize)->limit($pageSize);
        if ($modifiedFrom) {
            $select->where('modified_date', '>=', $modifiedFrom);
        }
        if ($clientId) {
            $select->where('client_id', '=', $clientId);
        }
        if ($onlyCount) {
            return $select->count();
        } else {
            $amlminis = $select->get();
            if ($amlminis) {
                $list = [];
                foreach ($amlminis as $amlmini) {
                    $list[] = $this->_amlmini2obj($amlmini);
                }
                return $list;
            }
            return null;
        }
    }
    
    protected function _amlmini2obj($amlmini)
    {
        $obj = new \stdClass();
        $obj->id = $amlmini->id;
        $obj->clientId = $amlmini->client_id;
        $obj->storeId = $amlmini->store_id;
        $obj->storeCode = $this->_relVal($amlmini->store, 'code');
        $obj->initiatorId = $amlmini->initiator_id;
        $obj->initiatorCode = $this->_relVal($amlmini->initiator, 'code');
        $obj->firstName = $amlmini->first_name;
        $obj->middleName = $amlmini->middle_name;
        $obj->lastName = $amlmini->last_name;
        $obj->birthDate = $amlmini->birth_date;
        $obj->birthPlace = $amlmini->birth_place;
        $obj->citizenshipCode = $this->_relVal($amlmini->citizenship, 'iso3');
        $obj->passportSeries = $amlmini->passport_series;
        $obj->passportNumber = $amlmini->passport_number;
        $obj->passportIssuedDate = $amlmini->passport_issued_date;
        $obj->passportIssuedBy = $amlmini->passport_issued_by;
        $obj->passportSubdivisionCode = $amlmini->id;
        $obj->inn = $amlmini->inn;
        $obj->registrationAddress = $amlmini->registration_address;
        $obj->residenceAddress = $amlmini->residence_address;
        $obj->phone = $amlmini->phone;
        $obj->migrationSeries = $amlmini->migration_series;
        $obj->migrationNumber = $amlmini->migration_number;
        $obj->migrationStayFrom = $amlmini->migration_stay_from;
        $obj->migrationStayTo = $amlmini->migration_stay_to;
        $obj->permissionSeries = $amlmini->permission_series;
        $obj->permissionNumber = $amlmini->permission_number;
        $obj->permissionStayFrom = $amlmini->permission_stay_from;
        $obj->permissionStayTo = $amlmini->permission_stay_to;
        $obj->questionnaire = strlen($amlmini->questionnaire) ? json_decode($amlmini->questionnaire) : '';
        $obj->questionnaireFile = $amlmini->questionnaire_file;
        $obj->createdDate = $this->_datetime($amlmini->created_date);
        $obj->createdBy = $amlmini->created_by;
        $obj->modifiedDate = $this->_datetime($amlmini->modified_date);
        $obj->modifiedBy = $amlmini->modified_by;
        return $obj;
    }
    
    
    protected function _relVal($object, $field)
    {
        return $object ? $object->{$field} : null;
    }
    
    protected function _datetime($atom)
    {
        $date = new \DateTime($atom);
        return $date->format(self::DATETIME_FORMAT);
    }
    
}