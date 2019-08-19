<?php

namespace App\Services;

use App\Exceptions\ApiExceptionFactory as AEF;

use Illuminate\Support\Facades\Auth;

use App\ProductSection;
use Illuminate\Support\Facades\Validator;

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