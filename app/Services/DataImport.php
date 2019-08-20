<?php

namespace App\Services;

use App\Exceptions\ApiExceptionFactory as AEF;

use Illuminate\Support\Facades\Auth;

use App\ProductSection;
use Illuminate\Support\Facades\Validator;
use App\Client;
use App\TimeZone;
use App\Country;
use App\Employee;
use App\Store;
use App\Warehouse;
use App\ItemBarcode;
use App\ItemSerial;
use App\ItemStock;

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
            
            $client->first_name = $row['firstName'];
            $client->middle_name = $row['middleName'];
            $client->last_name = $row['lastName'];
            $client->name = trim(implode(' ', [$client->last_name, $client->first_name, $client->middle_name]));
            $client->first_name_lat = $row['firstNameLat'];
            $client->last_name_lat = $row['lastNameLat'];
            
            $client->gender = $row['gender'];
            $client->comment = $row['comment'];
            
            $client->phone = $row['phone'];
            $client->email = $row['email'];
            
            $client->bd_day = $row['bdDay'];
            $client->bd_month = $row['bdMonth'];
            $client->bd_year = $row['bdYear'];
            $client->birth_place = $row['birthPlace'];
            
            $client->time_zone_id = $this->_getTimeZoneId($row['timeZoneId'], $row['timeZoneCode']);
            $client->country_id = $this->_getCountryIdByIso3($row['countryCode']);
            $client->postcode = $row['postcode'];
            $client->city = $row['city'];
            $client->address = $row['address'];

            $client->citizenship_id = $this->_getCountryIdByIso3($row['citizenshipCode']);
            $client->passport_series = $row['passportSeries'];
            $client->passport_number = $row['passportNumber'];
            $client->passport_issued_date = $row['passportIssuedDate'];
            $client->passport_issued_by = $row['passportIssuedBy'];
            $client->passport_subdivision_code = $row['passportSubdivisionCode'];
            $client->registration_address = $row['registrationAddress'];
            $client->inn = $row['inn'];
            
            $client->discount = 0;
            $client->discount_auto_calc = 0;
            
            $client->postal_opt_in = $row['postalOptIn'];
            $client->voice_opt_in = $row['voiceOptIn'];
            $client->email_opt_in = $row['emailOptIn'];
            $client->msg_opt_in = $row['msgOptIn'];
            $client->consent_signed = $row['consentSigned'];
            
            $client->employee_id = $this->_getEmployeeId($row['employeeId'], $row['employeeCode']);
            $client->responsible_id = $this->_getEmployeeId($row['responsibleId'], $row['responsibleCode']);
            $client->created_employee_id = $this->_getEmployeeId($row['createdEmployeeId'], $row['createdEmployeeCode']);
                        
            $client->created_store_id = $this->_getStoreId($row['createdStoreId'], $row['createdStoreCode']);
            $client->attached_store_id = $this->_getStoreId($row['attachedStoreId'], $row['attachedStoreCode']);
            
            $client->modified_by = $this->_userId;
            $client->modified_date = date('Y-m-d H:i:s');
            $client->save();
            
            $ids[] = ['id' => $client->id, 'code' => $client->code];
        }
        
        return $ids;
    }
    
    
    public function warehouses($data)
    {
        $this->_checkDataAsArray($data);
        
        foreach ($data as $row) {
            $validator = Validator::make($row, [
                    'id' => 'nullable|integer',
                    'code' => 'required|string|max:32',
                    'name' => 'nullable|string|max:150',
                    'storeId' => 'nullable|integer',
                    'storeCode' => 'nullable|string|max:32',
            ]);
            if ($validator->fails()) {
                $details = $validator->errors()->first() . ' [' . json_encode($row) . ']';
                throw AEF::create(AEF::DATA_VALIDATION_ERROR, $details);
            }
        }
        
        $ids = [];
        foreach ($data as $row) {
            
            $warehouse = null;
            if ($row['id']) {
                $warehouse = Warehouse::find($row['id']);
            } else {
                $warehouse = Warehouse::whereCode($row['code'])->first();
            }
            if (!$warehouse) {
                $warehouse = new Warehouse();
                $warehouse->created_by = $this->_userId;
                $warehouse->created_date = date('Y-m-d H:i:s');
            }
            
            $warehouse->code = $row['code'];
            $warehouse->name = $row['name'];
            $warehouse->store_id = $this->_getStoreId($row['storeId'], $row['storeCode']);
            
            $warehouse->modified_by = $this->_userId;
            $warehouse->modified_date = date('Y-m-d H:i:s');
            $warehouse->save();
            
            $ids[] = ['id' => $warehouse->id, 'code' => $warehouse->code];
        }
        
        return $ids;
    }
    
    public function stock($data)
    {
        $this->_checkDataAsArray($data);
        
        foreach ($data as $row) {
            $validator = Validator::make($row, [
                    'warehouseId' => 'nullable|integer',
                    'warehouseCode' => 'required|string|max:32',
                    'barcode' => 'required|string|max:150',
                    'serialNumber' => 'nullable|string|max:32',
                    'physicalQty' => 'required|integer',
                    'availableQty' => 'required|integer',
                    'reservedQty' => 'required|integer',
                    'transferQty' => 'required|integer',
                    'deliveryQty' => 'required|integer',
            ]);
            if ($validator->fails()) {
                $details = $validator->errors()->first() . ' [' . json_encode($row) . ']';
                throw AEF::create(AEF::DATA_VALIDATION_ERROR, $details);
            }
        }
        
        $ids = [];
        foreach ($data as $row) {
            
            $warehouseId = $this->_getWarehouseId($row['warehouseId'], $row['warehouseCode']);
            if (!$warehouseId) {
                throw AEF::create(AEF::WAREHOUSE_NOT_FOUND, json_encode(['id' => $row['warehouseId'], 'code' => $row['warehouseCode']]));
            }
            
            $barcode = ItemBarcode::find($row['barcode']);
            if (!$barcode) {
                throw AEF::create(AEF::BARCODE_NOT_FOUND, $row['barcode']);
            }
            
            $serialNumber = ItemSerial::whereItemId($barcode->item_id)
                                        ->whereSerial($row['serialNumber'])->getFirst();
            
            $stock = ItemStock::whereWarehouseId($warehouseId)
                                ->whereItemId($barcode->item_id)
                                ->whereSerialId($serialNumber ? $serialNumber->id : 0);
            
            
            if (!$stock) {
                $stock = new Warehouse();
                $stock->warehouse_id = $warehouseId;
                $stock->item_id = $barcode->item_id;
                $stock->serial_id = $serialNumber ? $serialNumber->id : 0;
                $stock->created_by = $this->_userId;
                $stock->created_date = date('Y-m-d H:i:s');
            }
            
            $stock->physical_qty = $row['physicalQty'];
            $stock->available_qty = $row['availableQty'];
            $stock->reserved_qty = $row['reservedQty'];
            $stock->transfer_qty = $row['transferQty'];
            $stock->delivery_qty = $row['deliveryQty'];
            
            $stock->modified_by = $this->_userId;
            $stock->modified_date = date('Y-m-d H:i:s');
            $stock->save();
            
            $ids[] = ['id' => $stock->id, 'code' => $stock->code];
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
    
    protected function _getStoreId($id, $code)
    {
        $store = null;
        if ($id) {
            $store = Store::find($id);
        } else if ($code) {
            $store = Store::whereCode($code)->first();
        }
        return $store ? $store->id : null;
    }
    
    protected function _getEmployeeId($id, $code)
    {
        $employee = null;
        if ($id) {
            $employee = Employee::find($id);
        } else if ($code) {
            $employee = Employee::whereCode($code)->first();
        }
        return $employee ? $employee->id : null;
    }
    
    protected function _getClientId($id, $code)
    {
        $client = null;
        if ($id) {
            $client = Client::find($id);
        } else if ($code) {
            $client = Client::whereCode($code)->first();
        }
        return $client ? $client->id : null;
    }
    
    protected function _getCountryIdByIso3($iso3Code)
    {
        $country = null;
        if ($iso3Code) {
            $country = Country::whereIso3($iso3Code)->first();
        }
        return $country ? $country->id : null;
    }
    
    protected function _getTimeZoneId($id, $code)
    {
        $timeZone = null;
        if ($id) {
            $timeZone = TimeZone::find($id);
        } else if ($code) {
            $timeZone = TimeZone::whereCode($code)->first();
        }
        return $timeZone ? $timeZone->id : null;
    }
    
    protected function _getWarehouseId($id, $code)
    {
        $warehouse = null;
        if ($id) {
            $warehouse = Warehouse::find($id);
        } else if ($code) {
            $warehouse = Warehouse::whereCode($code)->first();
        }
        return $warehouse ? $warehouse->id : null;
    }
    
    
    
}