<?php

namespace App\Services;

use App\Exceptions\ApiExceptionFactory as AEF;

use Illuminate\Support\Facades\Auth;

use App\ProductSection;
use Illuminate\Support\Facades\Validator;
use App\Client;

class DataImport 
{
    const MAX_ROWS_LIMIT = 1000;
    
    protected $_userId = null;
    
    public function __construct($userId)
    {
        $this->_userId = $userId;
    }
    
    public function productSections($data)
    {
        $this->_checkDataAsArray($data);
        
        foreach ($data as $row) {
            $validator = Validator::make($row, [
                    'id' => 'nullable|integer',
                    'code' => 'required|string|max:32',
                    'parentId' => 'nullable|integer',
                    'parentCode' => 'required|string|max:32',
                    'name' => 'required|string|max:150',
            ]);
            if ($validator->fails()) {
                $details = $validator->errors()->first() . ' [' . json_encode($row) . ']';
                throw AEF::create(AEF::DATA_VALIDATION_ERROR, $details);
            }
        }
        $ids = [];
        foreach ($data as $row) {
            
            $section = null;
            if ($row['id']) {
                $section = ProductSection::find($row['id']);
            } else {
                $section = ProductSection::whereCode($row['code'])->first();
            }
            if (!$section) {
                $section = new ProductSection();
                $section->created_by = $this->_userId;
                $section->created_date = date('Y-m-d H:i:s');
            }
            
            $parent = null;
            if ($row['parentId']) {
                $parent = ProductSection::find($row['parentId']);
            } else if ($row['parentCode']) {
                $parent = ProductSection::whereCode($row['parentCode'])->first();
            }
            
            $section->code = $row['code'];
            $section->parent_id = $parent ? $parent->id : 0;
            $section->name = $row['name'];
            
            $section->modified_by = $this->_userId;
            $section->modified_date = date('Y-m-d H:i:s');
            
            $section->save();
            
            
            $ids[] = ['id' => $section->id, 'code' => $section->code];
        }
        
        return $ids;
    }
    
    public function clients($data)
    {
        $this->_checkDataAsArray($data);
        
        foreach ($data as $row) {
            $validator = Validator::make($row, [
                    'id' => 'nullable|integer',
                    'code' => 'required|string|max:32',
                    'firstName' => 'nullable|string|max:50',
                    'middleName' => 'nullable|string|max:50',
                    'lastName' => 'nullable|string|max:50',
                    'firstNameLat' => 'nullable|string|max:50',
                    'lastNameLat' => 'nullable|string|max:50',
                    'gender' => 'nullable|string|size:1',
                    'comment' => 'nullable|string|max:500',
                    'phone' => 'nullable|string|max:26',
                    'email' => 'nullable|email|max:100',
                    
                    'bdDay' => 'nullable|int|between:1,31',
                    'bdMonth' => 'nullable|int|between:1,12',
                    'bdYear' => 'nullable|int|between:1900,' . date('Y'),
                    'birthPlace' => 'nullable|string|max:150',
                    
                    'timeZoneId' => 'nullable|int',
                    'timeZoneCode' => 'nullable|string|max:32',
                    
                    'countryCode' => 'required|string|size:3',
                    
                    'postcode' => 'nullable|string|max:30',
                    'city' => 'nullable|string|max:40',
                    'address' => 'nullable|string|max:255',
                    'citizenshipCode' => 'nullable|string|size:3',
                    
                    'passportSeries' => 'nullable|string|max:20',
                    'passportNumber' => 'nullable|string|max:20',
                    'passportIssuedDate' => 'nullable|string',
                    'passportIssuedBy' => 'nullable|string|max:150',
                    'passportSubdivisionCode' => 'nullable|string|max:10',
                    'inn' => 'nullable|string|max:12',
                    'registrationAddress' => 'nullable|string|max:255',
                    
                    
                    'postalOptIn' => 'boolean',
                    'voiceOptIn' => 'boolean',
                    'emailOptIn' => 'boolean',
                    'msgOptIn' => 'boolean',
                    'consentSigned' => 'boolean',
                    
                    'employeeId' => 'nullable|int',
                    'employeeCode' => 'nullable|string|max:32',
                    
                    'responsibleId' => 'nullable|int',
                    'responsibleCode' => 'nullable|string|max:32',
                    
                    'createdEmployeeId' => 'nullable|int',
                    'createdEmployeeCode' => 'nullable|string|max:32',
                    
                    'createdStoreId' => 'nullable|int',
                    'createdStoreCode' => 'nullable|string|max:32',
                    
                    'attachedStoreId' => 'nullable|int',
                    'attachedStoreCode' => 'nullable|string|max:32',
                    
            ]);
            if ($validator->fails()) {
                $details = $validator->errors()->first() . ' [' . json_encode($row) . ']';
                throw AEF::create(AEF::DATA_VALIDATION_ERROR, $details);
            }
        }
        
        
        $ids = [];
        foreach ($data as $row) {
            
            $client = null;
            if ($row['id']) {
                $client = Client::find($row['id']);
            } else {
                $client = Client::whereCode($row['code'])->first();
            }
            if (!$client) {
                $client = new Client();
                $client->created_by = $this->_userId;
                $client->created_date = date('Y-m-d H:i:s');
            }
            
            
            $client->code = $row['code'];
            $client->parent_id = $parent ? $parent->id : 0;
            $client->name = $row['name'];
            
            
            
            
            
            $client->modified_by = $this->_userId;
            $client->modified_date = date('Y-m-d H:i:s');
            $client->save();
            
            
            $ids[] = ['id' => $client->id, 'code' => $client->code];
        }
        
        return $ids;
    }
    
    protected function _checkDataAsArray($data)
    {
        if (!is_array($data)) {
            throw AEF::create(AEF::INVALID_REQUEST_PARAMETERS);
        }
        
        if (!count($data)) {
            throw AEF::create(AEF::DATA_NOT_FOUND);
        }
        
        if (count($data) > self::MAX_ROWS_LIMIT) {
            throw AEF::create(AEF::DATA_TOO_MUCH, ' > ' . self::MAX_ROWS_LIMIT);
        }
    }
    

    
}