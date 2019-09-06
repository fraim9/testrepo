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
use App\Sale;
use App\SaleLine;
use App\CashDesk;
use App\Brand;
use Illuminate\Support\Facades\DB;
use App\Collection;
use App\Product;
use App\Division;
use App\ProductColor;
use App\ProductConfig;
use App\ProductSize;
use App\ProductSeason;
use App\Item;
use App\ProductImage;

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
                    'id' => 'required_without:code|integer',
                    'code' => 'required_without:id|string|max:32',
                    'parentId' => 'nullable|integer',
                    'parentCode' => 'required|string|max:32',
                    'name' => 'required|string|max:150',
            ]);
            if ($validator->fails()) {
                $details = $validator->errors()->first() . ' [' . json_encode($row, JSON_UNESCAPED_UNICODE) . ']';
                throw AEF::create(AEF::DATA_VALIDATION_ERROR, $details);
            }
        }
        $ids = [];
        foreach ($data as $row) {
            
            $section = null;
            if (isset($row['id']) && $row['id']) {
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
            if (isset($row['parentId']) && $row['parentId']) {
                $parent = ProductSection::find($row['parentId']);
            } else if ($row['parentCode']) {
                $parent = ProductSection::whereCode($row['parentCode'])->first();
            }
            
            $section->code = $row['code'] ?? null;
            $section->parent_id = $parent ? $parent->id : 0;
            $section->name = $row['name'];
            
            $section->modified_by = $this->_userId;
            $section->modified_date = date('Y-m-d H:i:s');
            
            $section->save();
            
            
            $ids[] = ['id' => $section->id, 'code' => $section->code];
        }
        
        return $ids;
    }
    
    public function brands($data)
    {
        $this->_checkDataAsArray($data);
        
        foreach ($data as $row) {
            $validator = Validator::make($row, [
                    'id' => 'required_without:code|integer',
                    'code' => 'required_without:id|string|max:32',
                    'name' => 'required|string|max:150',
                    'logo' => 'string',
                    'logoFormat' => 'required_with:logo|in:png,jpg',
            ]);
            if ($validator->fails()) {
                $details = $validator->errors()->first() . ' [' . json_encode($row, JSON_UNESCAPED_UNICODE) . ']';
                throw AEF::create(AEF::DATA_VALIDATION_ERROR, $details);
            }
        }
        $ids = [];
        foreach ($data as $row) {
            
            $brand = null;
            if (isset($row['id']) && $row['id']) {
                $brand = Brand::find($row['id']);
            } else {
                $brand = Brand::whereCode($row['code'])->first();
            }
            if (!$brand) {
                $brand = new Brand();
                $brand->created_by = $this->_userId;
                $brand->created_date = date('Y-m-d H:i:s');
            } else if ($brand->logo_id) {
                $this->_deleteFile($brand->logo_id);
                $brand->logo_id = null;
            }
            
            $brand->code = $row['code'] ?? null;
            $brand->name = $row['name'];
            
            if (isset($row['logo']) && isset($row['logoFormat'])) {
                $brand->logo_id = $this->_storeFile($row['logo'], $row['logoFormat']);
            }
            
            $brand->modified_by = $this->_userId;
            $brand->modified_date = date('Y-m-d H:i:s');
            
            $brand->save();
            
            
            $ids[] = ['id' => $brand->id, 'code' => $brand->code];
        }
        
        return $ids;
    }
    
    public function collections($data)
    {
        $this->_checkDataAsArray($data);
        
        foreach ($data as $row) {
            $validator = Validator::make($row, [
                    'id' => 'required_without:code|integer',
                    'code' => 'required_without:id|string|max:32',
                    'name' => 'required|string|max:150',
                    'description' => 'nullable|string|max:255',
                    'year' => 'nullable|integer',
                    'brandId' => 'nullable|integer',
                    'brandCode' => 'nullable|string|max:32',
            ]);
            if ($validator->fails()) {
                $details = $validator->errors()->first() . ' [' . json_encode($row, JSON_UNESCAPED_UNICODE) . ']';
                throw AEF::create(AEF::DATA_VALIDATION_ERROR, $details);
            }
        }
        
        $ids = [];
        foreach ($data as $row) {
            
            $collection = null;
            if (isset($row['id']) && $row['id']) {
                $collection = Collection::find($row['id']);
            } else {
                $collection = Collection::whereCode($row['code'])->first();
            }
            if (!$collection) {
                $collection = new Collection();
                $collection->created_by = $this->_userId;
                $collection->created_date = date('Y-m-d H:i:s');
            }
            
            $collection->code = $row['code'] ?? null;
            $collection->name = $row['name'];
            $collection->description = $row['description'] ?? null;
            $collection->year = $row['year'] ?? null;
            $brandId = $row['brandId'] ?? null;
            $brandCode = $row['brandCode'] ?? null;
            if ($brandId || $brandCode) {
                $collection->brand_id = $this->_getBrandId($brandId, $brandCode);
            } else {
                $collection->brand_id = null;
            }
            
            $collection->modified_by = $this->_userId;
            $collection->modified_date = date('Y-m-d H:i:s');
            
            $collection->save();
            
            $ids[] = ['id' => $collection->id, 'code' => $collection->code];
        }
        
        return $ids;
    }
    

    public function products($data)
    {
        $this->_checkDataAsArray($data);
        
        foreach ($data as $row) {
            $validator = Validator::make($row, [
                    'id' => 'required_without:code|integer',
                    'code' => 'required_without:id|string|max:32',
                    'manufactureCode' => 'nullable|string|max:32',
                    'name' => 'required|string|max:255',
                    'shortDescription' => 'nullable|string|max:255',
                    'description' => 'nullable|string|max:16000',
                    'composition' => 'nullable|string|max:500',
                    'brandId' => 'nullable|integer',
                    'brandCode' => 'nullable|string|max:32',
                    'collectionId' => 'nullable|integer',
                    'collectionCode' => 'nullable|string|max:32',
                    'divisionId' => 'nullable|integer',
                    'divisionCode' => 'nullable|string|max:32',
                    'model' => 'nullable|string|max:50',
                    'colors' => 'nullable|array',
                    'configs' => 'nullable|array',
                    'sizes' => 'nullable|array',
                    'seasons' => 'nullable|array',
                    'sections' => 'nullable|array',
                    'items' => 'nullable|array',
            ]);
            if ($validator->fails()) {
                $details = $validator->errors()->first() . ' [' . json_encode($row, JSON_UNESCAPED_UNICODE) . ']';
                throw AEF::create(AEF::DATA_VALIDATION_ERROR, $details);
            }
        }
        
        $ids = [];
        foreach ($data as $row) {
            
            $product = null;
            if (isset($row['id']) && $row['id']) {
                $product = Product::find($row['id']);
            } else {
                $product = Product::whereCode($row['code'])->first();
            }
            if (!$product) {
                $product = new Product();
                $product->created_by = $this->_userId;
                $product->created_date = date('Y-m-d H:i:s');
            }
            
            $product->code = $row['code'] ?? null;
            $product->manufacture_code = $row['manufactureCode'] ?? null;
            $product->name = $row['name'];
            $product->short_description = $row['shortDescription'] ?? null;
            $product->description = $row['description'] ?? null;
            $product->composition = $row['composition'] ?? null;
            $product->model = $row['model'] ?? null;
            
            $product->brand_id = $this->_getBrandId($row['brandId'] ?? null, $row['brandCode'] ?? null);
            $product->collection_id = $this->_getCollectionId($row['collectionId'] ?? null, $row['collectionCode'] ?? null);
            $product->division_id = $this->_getCollectionId($row['divisionId'] ?? null, $row['divisionCode'] ?? null);

            
            $product->modified_by = $this->_userId;
            $product->modified_date = date('Y-m-d H:i:s');
            
            $product->save();
            
            $colors = [];
            if (isset($row['colors']) && is_array($row['colors']) && count($row['colors'])) {
                $colors = $this->productColors($product->id, $row['colors']);
            }
            
            $configs = [];
            if (isset($row['configs']) && is_array($row['configs']) && count($row['configs'])) {
                $configs = $this->productConfigs($product->id, $row['configs']);
            }
            
            $sizes = [];
            if (isset($row['sizes']) && is_array($row['sizes']) && count($row['sizes'])) {
                $sizes = $this->productSizes($product->id, $row['sizes']);
            }
            
            $seasons = [];
            if (isset($row['seasons']) && is_array($row['seasons']) && count($row['seasons'])) {
                $seasons = $this->productSeasons($product->id, $row['seasons']);
            }
            
            if (isset($row['sections']) && is_array($row['sections']) && count($row['sections'])) {
                $product->sections()->sync($row['sections']);
            }
            
            if (isset($row['items']) && is_array($row['items']) && count($row['items'])) {
                $this->items($product->id, $row['items'], $colors, $configs, $sizes, $seasons);
            }
            
            $ids[] = ['id' => $product->id, 'code' => $product->code];
        }
        
        return $ids;
    }
    
    
    public function productColors($productId, $data)
    {
        foreach ($data as $row) {
            $validator = Validator::make($row, [
                    'code' => 'required|string|max:32',
                    'name' => 'nullable|string|max:50',
                    'hex' => 'nullable|string|max:6',
                    'image' => 'nullable|string',
                    'imageFormat' => 'required_with:image|in:png,jpg',
            ]);
            if ($validator->fails()) {
                $details = $validator->errors()->first() . ' [' . json_encode($row, JSON_UNESCAPED_UNICODE) . ']';
                throw AEF::create(AEF::DATA_VALIDATION_ERROR, $details);
            }
        }
        
        $newColors = collect($data)->keyBy('code');
        $colors = ProductColor::whereProductId($productId)->get()->keyBy('code');
        
        // удаляем цвета, которых нет в новом наборе
        $toDelete = $colors->diffKeys($newColors);
        foreach ($toDelete as $color) {
            $color->delete();
        }
 
        $result = [];
        foreach ($newColors as $newColor) {
            
            $color = $colors->get($newColor['code']);
            if (!$color) {
                $color = new ProductColor();
                $color->product_id = $productId;
                $color->code = $newColor['code'];
                $color->created_by = $this->_userId;
                $color->created_date = date('Y-m-d H:i:s');
            }
            $color->name = $newColor['name'] ?? null;
            $color->hex = $newColor['hex'] ?? null;
            
            if ($color->image_id) {
                $this->_deleteFile($color->image_id);
                $color->image_id = null;
            }
            if (isset($newColor['image']) 
                    && strlen($newColor['image']) 
                    && isset($newColor['imageFormat']) 
                    && strlen($newColor['imageFormat'])) {
                $color->image_id = $this->_storeFile($newColor['image'], $newColor['imageFormat'], 0);
            }
            
            $color->modified_by = $this->_userId;
            $color->modified_date = date('Y-m-d H:i:s');
            
            $color->save();
            
            $result[$color->code] = $color;
        }
        return $result;
    }
    
    public function productConfigs($productId, $data)
    {
        foreach ($data as $row) {
            $validator = Validator::make($row, [
                    'code' => 'required|string|max:32',
                    'name' => 'nullable|string|max:50',
            ]);
            if ($validator->fails()) {
                $details = $validator->errors()->first() . ' [' . json_encode($row, JSON_UNESCAPED_UNICODE) . ']';
                throw AEF::create(AEF::DATA_VALIDATION_ERROR, $details);
            }
        }
        
        $newConfigs = collect($data)->keyBy('code');
        $configs = ProductConfig::whereProductId($productId)->get()->keyBy('code');
        
        // удаляем цвета, которых нет в новом наборе
        $toDelete = $configs->diffKeys($newConfigs);
        foreach ($toDelete as $config) {
            $config->delete();
        }
        
        $result = [];
        foreach ($newConfigs as $newConfig) {
            
            $config = $configs->get($newConfig['code']);
            if (!$config) {
                $config = new ProductConfig();
                $config->product_id = $productId;
                $config->code = $newConfig['code'];
                $config->created_by = $this->_userId;
                $config->created_date = date('Y-m-d H:i:s');
            }
            $config->name = $newConfig['name'] ?? null;
            
            $config->modified_by = $this->_userId;
            $config->modified_date = date('Y-m-d H:i:s');
            
            $config->save();
            
            $result[$config->code] = $config;
        }
        return $result;
    }
    
    public function productSizes($productId, $data)
    {
        foreach ($data as $row) {
            $validator = Validator::make($row, [
                    'code' => 'required|string|max:32',
                    'name' => 'nullable|string|max:50',
            ]);
            if ($validator->fails()) {
                $details = $validator->errors()->first() . ' [' . json_encode($row, JSON_UNESCAPED_UNICODE) . ']';
                throw AEF::create(AEF::DATA_VALIDATION_ERROR, $details);
            }
        }
        
        $newSizes = collect($data)->keyBy('code');
        $sizes = ProductSize::whereProductId($productId)->get()->keyBy('code');
        
        // удаляем размеры, которых нет в новом наборе
        $toDelete = $sizes->diffKeys($newSizes);
        foreach ($toDelete as $config) {
            $config->delete();
        }
        
        $result = [];
        $i = 1;
        foreach ($newSizes as $newSize) {
            
            $size = $sizes->get($newSize['code']);
            if (!$size) {
                $size = new ProductSize();
                $size->product_id = $productId;
                $size->code = $newSize['code'];
                $size->created_by = $this->_userId;
                $size->created_date = date('Y-m-d H:i:s');
            }
            $size->name = $newSize['name'] ?? null;
            $size->sort = $i++;
            
            $size->modified_by = $this->_userId;
            $size->modified_date = date('Y-m-d H:i:s');
            
            $size->save();
            
            $result[$size->code] = $size;
        }
        return $result;
    }
    
    public function productSeasons($productId, $data)
    {
        foreach ($data as $row) {
            $validator = Validator::make($row, [
                    'code' => 'required|string|max:32',
                    'name' => 'nullable|string|max:50',
            ]);
            if ($validator->fails()) {
                $details = $validator->errors()->first() . ' [' . json_encode($row, JSON_UNESCAPED_UNICODE) . ']';
                throw AEF::create(AEF::DATA_VALIDATION_ERROR, $details);
            }
        }
        
        $newSeasons = collect($data)->keyBy('code');
        $seasons = ProductSeason::whereProductId($productId)->get()->keyBy('code');
        
        // удаляем сезоны, которых нет в новом наборе
        $toDelete = $seasons->diffKeys($newSeasons);
        foreach ($toDelete as $config) {
            $config->delete();
        }
        
        $result = [];
        $i = 1;
        foreach ($newSeasons as $newSeason) {
            
            $season = $seasons->get($newSeason['code']);
            if (!$season) {
                $season = new ProductSeason();
                $season->product_id = $productId;
                $season->code = $newSeason['code'];
                $season->created_by = $this->_userId;
                $season->created_date = date('Y-m-d H:i:s');
            }
            $season->name = $newSeason['name'] ?? null;
            $season->sort = $i++;
            
            $season->modified_by = $this->_userId;
            $season->modified_date = date('Y-m-d H:i:s');
            
            $season->save();
            
            $result[$season->code] = $season;
        }
        return $result;
    }
    
    public function items($productId, $data, $colors, $configs, $sizes, $seasons)
    {
        $newItems = [];
        foreach ($data as $row) {
            $validator = Validator::make($row, [
                    'colorCode' => 'nullable|string|max:32',
                    'sizeCode' => 'nullable|string|max:32',
                    'configCode' => 'nullable|string|max:32',
                    'seasonCode' => 'nullable|string|max:32',
                    'barcodes' => 'nullable|array',
                    'serials' => 'nullable|array',
            ]);
            if ($validator->fails()) {
                $details = $validator->errors()->first() . ' [' . json_encode($row, JSON_UNESCAPED_UNICODE) . ']';
                throw AEF::create(AEF::DATA_VALIDATION_ERROR, $details);
            }
            $colorCode = $row['colorCode'] ?? 'none';
            $sizeCode = $row['sizeCode'] ?? 'none';
            $configCode = $row['configCode'] ?? 'none';
            $seasonCode = $row['seasonCode'] ?? 'none';
            $key = md5($colorCode . $sizeCode . $configCode . $seasonCode);
            $row['key'] = $key;
            $newItems[$key] = $row;
        }
        
        $items = Item::whereProductId($productId)->get()->map(function($item) {
            $item->key = md5($item->color->code . $item->size->code . $item->config->code . $item->season->code);
            return $item;
        })->keyBy('key');
        
        // удаляем элементы, которых нет в новом наборе
        $toDelete = $items->diffKeys($newItems);
        foreach ($toDelete as $item) {
            $item->delete();
        }
        
        foreach ($newItems as $newItem) {
            
            $item = $items->get($newItem['key']);
            if (!$item) {
                $item = new Item();
                $item->product_id = $productId;
                $item->created_by = $this->_userId;
                $item->created_date = date('Y-m-d H:i:s');
            }

            if ($newItem['colorCode']) {
                $color = $colors[$newItem['colorCode']];
                if ($color) {
                    $item->color_id = $color->id;
                }
            }
            if ($newItem['sizeCode']) {
                $size = $sizes[$newItem['sizeCode']];
                if ($size) {
                    $item->size_id = $size->id;
                }
            }
            if ($newItem['configCode']) {
                $config = $configs[$newItem['configCode']];
                if ($config) {
                    $item->config_id = $config->id;
                }
            }
            if ($newItem['seasonCode']) {
                $season = $seasons[$newItem['seasonCode']];
                if ($season) {
                    $item->season_id = $season->id;
                }
            }
            
            $item->gtin = $newItem['gtin'] ?? null;
            
            $item->modified_by = $this->_userId;
            $item->modified_date = date('Y-m-d H:i:s');
            unset($item->key);
            $item->save();
            
            ItemBarcode::whereItemId($item->id)->delete();
            if (isset($newItem['barcodes']) && is_array($newItem['barcodes'])) {
                foreach ($newItem['barcodes'] as $barcode) {
                    $itemBarcode = new ItemBarcode();
                    $itemBarcode->barcode = $barcode;
                    $itemBarcode->item_id = $item->id;
                    $itemBarcode->created_by = $this->_userId;
                    $itemBarcode->created_date = date('Y-m-d H:i:s');
                    $itemBarcode->modified_by = $this->_userId;
                    $itemBarcode->modified_date = date('Y-m-d H:i:s');
                    $itemBarcode->save();
                }
            }
            
            $serials = ItemSerial::whereItemId($item->id)->get()->keyBy('serial');
            if (isset($newItem['serials']) && is_array($newItem['serials'])) {
                $newSerials = [];
                foreach ($newItem['serials'] as $serial) {
                    $newSerials[$serial] = $serial;
                }
                $toDelete = $serials->diffKeys($newSerials);
                foreach ($toDelete as $serial) {
                    $serial->delete();
                }
                
                foreach ($newSerials as $newSerial) {
                    $itemSerial = $serials->get($newSerial);
                    if (!$itemSerial) {
                        $itemSerial = new ItemSerial();
                        $itemSerial->item_id = $item->id;
                        $itemSerial->created_by = $this->_userId;
                        $itemSerial->created_date = date('Y-m-d H:i:s');
                        $itemSerial->serial = $newSerial;
                        $itemSerial->modified_by = $this->_userId;
                        $itemSerial->modified_date = date('Y-m-d H:i:s');
                        
                        $itemSerial->save();
                    }
                }
            }
            
        }
    }
    

    public function productImage($data)
    {
        $validator = Validator::make($data, [
                'productId' => 'required_without:code|integer',
                'productCode' => 'required_without:id|string|max:32',
                'colorCode' => 'nullable|string|max:32',
                'sizeCode' => 'nullable|string|max:32',
                'configCode' => 'nullable|string|max:32',
                'seasonCode' => 'nullable|string|max:32',
                'image' => 'required|string',
                'imageFormat' => 'required|in:png,jpg',
        ]);
        if ($validator->fails()) {
            $details = $validator->errors()->first() . ' [' . json_encode($data) . ']';
            throw AEF::create(AEF::DATA_VALIDATION_ERROR, $details);
        }
        
        $productId = $this->_getProductId($data['productId'] ?? null, $data['productCode'] ?? null);
        if (!$productId) {
            throw AEF::create(AEF::PRODUCT_NOT_FOUND);
        }
        
        $query = ProductImage::query();
        $query->whereProductId($productId);
        
        $color = null;
        if (isset($data['colorCode']) && strlen($data['colorCode'])) {
            $color = ProductColor::whereProductId($productId)->whereCode($data['colorCode'])->first();
            if (!$color) {
                throw AEF::create(AEF::PRODUCT_COLOR_NOT_FOUND, $data['colorCode']);
            }
            $query->whereColorId($color->id);
        }
        $size = null;
        if (isset($data['sizeCode']) && strlen($data['sizeCode'])) {
            $size = ProductSize::whereProductId($productId)->whereCode($data['sizeCode'])->first();
            if (!$size) {
                throw AEF::create(AEF::PRODUCT_SIZE_NOT_FOUND, $data['sizeCode']);
            }
            $query->whereSizeId($size->id);
        }
        $config = null;
        if (isset($data['configCode']) && strlen($data['configCode'])) {
            $config = ProductConfig::whereProductId($productId)->whereCode($data['configCode'])->first();
            if (!$config) {
                throw AEF::create(AEF::PRODUCT_CONFIG_NOT_FOUND, $data['configCode']);
            }
            $query->whereConfigId($config->id);
        }
        $season = null;
        if (isset($data['seasonCode']) && strlen($data['seasonCode'])) {
            $season = ProductSeason::whereProductId($productId)->whereCode($data['seasonCode'])->first();
            if (!$season) {
                throw AEF::create(AEF::PRODUCT_SEASON_NOT_FOUND, $data['seasonCode']);
            }
            $query->whereSeasonId($season->id);
        }
        
        $productImage = $query->first();
        if (!$productImage) {
            $productImage = new ProductImage();
            $productImage->product_id = $productId;
            $productImage->created_by = $this->_userId;
            $productImage->created_date = date('Y-m-d H:i:s');
            if ($color) {
                $productImage->color_id = $color->id;
            }
            if ($size) {
                $productImage->size_id = $size->id;
            }
            if ($config) {
                $productImage->config_id = $config->id;
            }
            if ($season) {
                $productImage->season_id = $season->id;
            }
        }
        
        $productImage->image_id = $this->_storeFile($data['image'], $data['imageFormat'], 0, $productImage->image_id);
        
        $productImage->modified_by = $this->_userId;
        $productImage->modified_date = date('Y-m-d H:i:s');
        
        //echo '<pre>';
        //print_r($productImage);
        //echo '</pre>';
        //exit;
        $productImage->save();
        
    }
    
    
    
    public function clients($data)
    {
        $this->_checkDataAsArray($data);
        
        foreach ($data as $row) {
            $validator = Validator::make($row, [
                    'id' => 'required_without:code|integer',
                    'code' => 'required_without:id|string|max:32',
                    'firstName' => 'nullable|string|max:50',
                    'middleName' => 'nullable|string|max:50',
                    'lastName' => 'nullable|string|max:50',
                    'firstNameLat' => 'nullable|string|max:50',
                    'lastNameLat' => 'nullable|string|max:50',
                    'gender' => 'nullable|string|size:1|in:M,F',
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
                $details = $validator->errors()->first() . ' [' . json_encode($row, JSON_UNESCAPED_UNICODE) . ']';
                throw AEF::create(AEF::DATA_VALIDATION_ERROR, $details);
            }
        }
        
        
        $ids = [];
        foreach ($data as $row) {
            
            $client = null;
            if (isset($row['id']) && $row['id']) {
                $client = Client::find($row['id']);
            } else {
                $client = Client::whereCode($row['code'])->first();
            }
            if (!$client) {
                $client = new Client();
                $client->created_by = $this->_userId;
                $client->created_date = date('Y-m-d H:i:s');
            }
            
            $client->code = $row['code'] ?? null;
            
            $client->first_name = $row['firstName'] ?? null;
            $client->middle_name = $row['middleName'] ?? null;
            $client->last_name = $row['lastName'] ?? null;
            $client->name = trim(implode(' ', [$client->last_name, $client->first_name, $client->middle_name]));
            $client->first_name_lat = $row['firstNameLat'] ?? null;
            $client->last_name_lat = $row['lastNameLat'] ?? null;
            
            $client->gender = $row['gender'] ?? null;
            $client->comment = $row['comment'] ?? null;
            
            $client->phone = $row['phone'] ?? null;
            $client->email = $row['email'] ?? null;
            
            $client->bd_day = $row['bdDay'] ?? null;
            $client->bd_month = $row['bdMonth'] ?? null;
            $client->bd_year = $row['bdYear'] ?? null;
            $client->birth_place = $row['birthPlace'] ?? null;
            
            $client->time_zone_id = $this->_getTimeZoneId($row['timeZoneId'] ?? null, $row['timeZoneCode'] ?? null);
            $client->country_id = $this->_getCountryIdByIso3($row['countryCode']);
            $client->postcode = $row['postcode'] ?? null;
            $client->city = $row['city'] ?? null;
            $client->address = $row['address'] ?? null;

            $client->citizenship_id = $this->_getCountryIdByIso3($row['citizenshipCode'] ?? null);
            $client->passport_series = $row['passportSeries'] ?? null;
            $client->passport_number = $row['passportNumber'] ?? null;
            $client->passport_issued_date = $row['passportIssuedDate'] ?? null;
            $client->passport_issued_by = $row['passportIssuedBy'] ?? null;
            $client->passport_subdivision_code = $row['passportSubdivisionCode'] ?? null;
            $client->registration_address = $row['registrationAddress'] ?? null;
            $client->inn = $row['inn'] ?? null;
            
            $client->discount = 0;
            $client->discount_auto_calc = 0;
            
            $client->postal_opt_in = $row['postalOptIn'] ?? false;
            $client->voice_opt_in = $row['voiceOptIn'] ?? false;
            $client->email_opt_in = $row['emailOptIn'] ?? false;
            $client->msg_opt_in = $row['msgOptIn'] ?? false;
            $client->consent_signed = $row['consentSigned'] ?? false;
            
            $client->employee_id = $this->_getEmployeeId($row['employeeId'] ?? null, $row['employeeCode'] ?? null);
            $client->responsible_id = $this->_getEmployeeId($row['responsibleId'] ?? null, $row['responsibleCode'] ?? null);
            $client->created_employee_id = $this->_getEmployeeId($row['createdEmployeeId'] ?? null, $row['createdEmployeeCode'] ?? null);
                        
            $client->created_store_id = $this->_getStoreId($row['createdStoreId'] ?? null, $row['createdStoreCode'] ?? null);
            $client->attached_store_id = $this->_getStoreId($row['attachedStoreId'] ?? null, $row['attachedStoreCode'] ?? null);
            
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
                    'id' => 'required_without:code|integer',
                    'code' => 'required_without:id|string|max:32',
                    'name' => 'nullable|string|max:150',
                    'storeId' => 'nullable|integer',
                    'storeCode' => 'nullable|string|max:32',
            ]);
            if ($validator->fails()) {
                $details = $validator->errors()->first() . ' [' . json_encode($row, JSON_UNESCAPED_UNICODE) . ']';
                throw AEF::create(AEF::DATA_VALIDATION_ERROR, $details);
            }
        }
        
        $ids = [];
        foreach ($data as $row) {
            
            $warehouse = null;
            if (isset($row['id']) && $row['id']) {
                $warehouse = Warehouse::find($row['id']);
            } else {
                $warehouse = Warehouse::whereCode($row['code'])->first();
            }
            if (!$warehouse) {
                $warehouse = new Warehouse();
                $warehouse->created_by = $this->_userId;
                $warehouse->created_date = date('Y-m-d H:i:s');
            }
            
            $warehouse->code = $row['code'] ?? null;
            $warehouse->name = $row['name'] ?? null;
            $warehouse->store_id = $this->_getStoreId($row['storeId'] ?? null, $row['storeCode'] ?? null);
            
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
                    'warehouseId' => 'required_without:code|integer',
                    'warehouseCode' => 'required_without:id|string|max:32',
                    'barcode' => 'required|string|max:150',
                    'serialNumber' => 'nullable|string|max:32',
                    'physicalQty' => 'required|integer',
                    'availableQty' => 'required|integer',
                    'reservedQty' => 'required|integer',
                    'transferQty' => 'required|integer',
                    'deliveryQty' => 'required|integer',
            ]);
            if ($validator->fails()) {
                $details = $validator->errors()->first() . ' [' . json_encode($row, JSON_UNESCAPED_UNICODE) . ']';
                throw AEF::create(AEF::DATA_VALIDATION_ERROR, $details);
            }
        }
        
        foreach ($data as $row) {
            
            $warehouseId = $this->_getWarehouseId($row['warehouseId'] ?? null, $row['warehouseCode'] ?? null);
            if (!$warehouseId) {
                throw AEF::create(AEF::WAREHOUSE_NOT_FOUND, json_encode(['id' => $row['warehouseId'] ?? null, 'code' => $row['warehouseCode'] ?? null]));
            }
            
            $barcode = ItemBarcode::find($row['barcode']);
            if (!$barcode) {
                throw AEF::create(AEF::BARCODE_NOT_FOUND, $row['barcode']);
            }
            
            if (isset($row['serialNumber']) && strlen($row['serialNumber'])) {
                $serialNumber = ItemSerial::whereItemId($barcode->item_id)
                                            ->whereSerial($row['serialNumber'])->first();
            }
            
            $stock = ItemStock::whereWarehouseId($warehouseId)
                                ->whereItemId($barcode->item_id)
                                ->whereSerialId($serialNumber ? $serialNumber->id : 0)->first();
            
            
            if (!$stock) {
                $stock = new ItemStock();
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
            
        }
        
    }
    
    public function sales($data)
    {
        $this->_checkDataAsArray($data);
        
        foreach ($data as $row) {
            $validator = Validator::make($row, [
                    'id' => 'required_without:code|integer',
                    'code' => 'required_without:id|string|max:32',
                    'checkNumber' => 'nullable|integer',
                    'date' => 'nullable|date_format:Y-m-d\TH:i:s',
                    'timeZone' => 'nullable|string|max:6',
                    'dateLocal' => 'nullable|date_format:Y-m-d\TH:i:s',
                    'storeCode' => 'required|string|max:32',
                    'clientId' => 'nullable|integer',
                    'clientCode' => 'required|string|max:32',
                    'employeeCode' => 'required|string|max:32',
                    'cashDeskCode' => 'nullable|string|max:32',
                    'lines' => 'required|array',
            ]);
            if ($validator->fails()) {
                $details = $validator->errors()->first() . ' [' . json_encode($row, JSON_UNESCAPED_UNICODE) . ']';
                throw AEF::create(AEF::DATA_VALIDATION_ERROR, $details);
            }
        }
        
        
        $ids = [];
        foreach ($data as $row) {
            
            $sale = null;
            if (isset($row['id']) && $row['id']) {
                $sale = Sale::find($row['id']);
            } else if ($row['code']) {
                $sale = Sale::whereCode($row['code'])->first();
            }
            
            if (!$sale) {
                $sale = new Sale();
                $sale->created_by = $this->_userId;
                $sale->created_date = date('Y-m-d H:i:s');
            }
            
            $sale->code = $row['code'] ?? null;
            $sale->check_number = $row['checkNumber'] ?? null;
            $store = $this->_getStoreId(0, $row['storeCode'], true);
            if (!$store) {
                throw AEF::create(AEF::STORE_NOT_FOUND);
            }
            $sale->store_id = $store->id;
            
            $storeTimeZone = TimeZone::find($store->time_zone_id);
            
            $row['date'] = $row['date'] ?? false;
            $row['timeZone'] = $row['timeZone'] ?? false;
            $row['dateLocal'] = $row['dateLocal'] ?? false;
            
            if ($row['date'] && !$row['timeZone'] && !$row['dateLocal']) {
                $date = new \DateTime($row['date']);
                $sale->date = $date->format('Y-m-d H:i:s');
                $sale->time_offset = $storeTimeZone->offset;
            } else if ($row['date'] && $row['timeZone'] && !$row['dateLocal']) {
                $date = new \DateTime($row['date']);
                $sale->date = $date->format('Y-m-d H:i:s');
                $sale->time_offset = $row['timeZone'];
            } else if (!$row['date'] && $row['timeZone'] && $row['dateLocal']) {
                $date = new \DateTime($row['dateLocal']);
                $timezone = new \DateTimeZone($row['timeZone']);
                $date->setTimezone($timezone);
                $sale->date = $date->format('Y-m-d H:i:s');
                $sale->time_offset = $row['timeZone'];
            } else if (!$row['date'] && !$row['timeZone'] && $row['dateLocal']) {
                $date = new \DateTime($row['dateLocal']);
                $timezone = new \DateTimeZone($storeTimeZone->offset);
                $date->setTimezone($timezone);
                $sale->date = $date->format('Y-m-d H:i:s');
                $sale->time_offset = $storeTimeZone->offset;
            } else {
                throw AEF::create(AEF::INVALID_DATE);
            }
            
            $clientId = $this->_getClientId($row['clientId'] ?? null, $row['clientCode']);
            if (!$clientId) {
                throw AEF::create(AEF::CLIENT_NOT_FOUND);
            }
            $sale->client_id = $clientId;
            
            $employeeId = $this->_getEmployeeId(0, $row['employeeCode']);
            if (!$employeeId) {
                throw AEF::create(AEF::EMPLOYEE_NOT_FOUND);
            }
            $sale->employee_id = $employeeId;
            
            if (isset($row['cashDeskCode']) && strlen($row['cashDeskCode'])) {
                $cashDesk = CashDesk::whereCode($row['cashDeskCode'])->first();
                if ($cashDesk) {
                    $sale->cash_desk_id = $cashDesk->id;
                }
            }
            
            $sale->modified_by = $this->_userId;
            $sale->modified_date = date('Y-m-d H:i:s');
            $sale->save();
            
            // удаляем все строки чека
            SaleLine::whereSalesId($sale->id)->delete();
            
            // добавлям строки чека и вычисляем суммарные показатели
            $sale->qty = 0;
            $sale->amount = 0;
            foreach ($row['lines'] as $i => $line) {
                $saleLine =  $this->salesLine($sale->id, $i, $line);
                $sale->qty += $saleLine->quantity;
                $sale->amount += $saleLine->amount;
            }
            $sale->status = 0;
            $sale->save();
            
            $ids[] = ['id' => $sale->id, 'code' => $sale->code];
        }
        
        return $ids;
    }
    
    public function salesLine($salesId, $lineNumber, $data)
    {
        
        $validator = Validator::make($data, [
                'lineNumber' => 'nullable|integer',
                'salespersonCode' => 'required|string|max:32',
                'warehouseCode' => 'required|string|max:32',
                'barcode' => 'required|string|max:30',
                'serialNumber' => 'nullable|string|max:32',
                'quantity' => 'required|integer',
                'price' => 'required|numeric',
                'discount' => 'nullable|numeric',
        ]);
        if ($validator->fails()) {
            $details = $validator->errors()->first() . ' [' . json_encode($data) . ']';
            throw AEF::create(AEF::DATA_VALIDATION_ERROR, $details);
        }
        
        $saleLine = new SaleLine();
        $saleLine->created_by = $this->_userId;
        $saleLine->created_date = date('Y-m-d H:i:s');
        
        $saleLine->sales_id = $salesId;
        $saleLine->line_number = isset($data['lineNumber']) ? $data['lineNumber'] : $lineNumber;
        
        $salespersonId = $this->_getEmployeeId(0, $data['salespersonCode']);
        if (!$salespersonId) {
            throw AEF::create(AEF::EMPLOYEE_NOT_FOUND, $data['salespersonCode']);
        }
        $saleLine->salesperson_id = $salespersonId;
        
        $warehouseId = $this->_getWarehouseId(0, $data['warehouseCode']);
        if (!$warehouseId) {
            throw AEF::create(AEF::WAREHOUSE_NOT_FOUND, $data['warehouseCode']);
        }
        $saleLine->warehouse_id = $warehouseId;
        
        $barcode = ItemBarcode::find($data['barcode']);
        if (!$barcode) {
            throw AEF::create(AEF::BARCODE_NOT_FOUND, $data['barcode']);
        }
        $saleLine->item_id = $barcode->item_id;
        $saleLine->barcode = $barcode->barcode;
        
        if (isset($data['serialNumber']) && strlen($data['serialNumber'])) {
            $serialNumber = ItemSerial::whereItemId($barcode->item_id)
                ->whereSerial($data['serialNumber'])->first();
            if ($serialNumber) {
                $saleLine->serial_id = $serialNumber->id;
            }
        }
        
        $saleLine->quantity = $data['quantity'];
        $saleLine->price = $data['price'];
        $saleLine->discount = $data['discount'] ?? 0;
        $saleLine->amount = $saleLine->quantity * $saleLine->price - $saleLine->discount;
        
        $saleLine->modified_by = $this->_userId;
        $saleLine->modified_date = date('Y-m-d H:i:s');
        $saleLine->save();
        
        return $saleLine;
    }
    
    public function employees($data)
    {
        $this->_checkDataAsArray($data);
        
        foreach ($data as $row) {
            $validator = Validator::make($row, [
                    'id' => 'required_without:code|integer',
                    'code' => 'required_without:id|string|max:32',
                    'name' => 'required|string|max:150',
                    'personnel_number' => 'nullable|string|max:32',
                    'position' => 'nullable|string|max:150',
                    'birth_day' => 'nullable|int|between:1,31',
                    'birth_month' => 'nullable|int|between:1,12',
                    'email' => 'nullable|email|max:100',
                    'phone' => 'nullable|string|max:26',
                    'phone_mobile' => 'nullable|string|max:26',
                    'phone_personal' => 'nullable|string|max:26',
                    'managerCode' => 'nullable|string|max:32',
                    'active' => 'boolean',
            ]);
            if ($validator->fails()) {
                $details = $validator->errors()->first() . ' [' . json_encode($row, JSON_UNESCAPED_UNICODE) . ']';
                throw AEF::create(AEF::DATA_VALIDATION_ERROR, $details);
            }
        }
        
        $ids = [];
        foreach ($data as $row) {
            
            $employee = null;
            if (isset($row['id']) && $row['id']) {
                $employee = Employee()::find($row['id']);
            } else {
                $employee = Employee::whereCode($row['code'])->first();
            }
            if (!$employee) {
                $employee = new Employee();
                $employee->created_by = $this->_userId;
                $employee->created_date = date('Y-m-d H:i:s');
            }
            
            $employee->code = $row['code'] ?? null;
            $employee->name = $row['name'];
            $employee->personnel_number = $row['personnel_number'] ?? null;
            $employee->position = $row['position'] ?? null;
            $employee->birth_day = $row['birth_day'] ?? null;
            $employee->birth_month = $row['birth_month'] ?? null;
            $employee->email = $row['email'] ?? null;
            $employee->phone = $row['phone'] ?? null;
            $employee->phone_mobile = $row['phone_mobile'] ?? null;
            $employee->phone_personal = $row['phone_personal'] ?? null;
            if (isset($row['managerCode']) && strlen($row['managerCode'])) {
                $manager = Employee::whereCode($row['managerCode'])->first();
                if ($manager) {
                    $employee->manager_id = $manager->id;
                }
            }
            $employee->active = (boolean) ($row['active'] ?? false);
            
            $employee->modified_by = $this->_userId;
            $employee->modified_date = date('Y-m-d H:i:s');
            $employee->save();
            
            $ids[] = ['id' => $employee->id, 'code' => $employee->code];
        }
        
        return $ids;
    }
    
    protected function _storeFile($data, $ext, $cold = 0, $fileId = false)
    {
        $data = base64_decode($data);
        $file = Files::storeFile($data, $ext, $cold, $this->_userId, $fileId);
        return $file->id;
    }

    protected function _deleteFile($fileId)
    {
        Files::deleteFile($fileId);
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
        
        if (!isset($data[0]) || !is_array($data[0])) {
            throw AEF::create(AEF::INVALID_REQUEST_PARAMETERS);
        }
    }
    
    protected function _getStoreId($id, $code, $asObject = false)
    {
        $store = null;
        if ($id) {
            $store = Store::find($id);
        } else if ($code) {
            $store = Store::whereCode($code)->first();
        }
        return $store ? ($asObject ? $store : $store->id) : null;
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
    
    protected function _getBrandId($id, $code)
    {
        $brand = null;
        if ($id) {
            $brand = Brand::find($id);
        } else if ($code) {
            $brand = Brand::whereCode($code)->first();
        }
        return $brand ? $brand->id : null;
    }
    
    protected function _getCollectionId($id, $code)
    {
        $collection = null;
        if ($id) {
            $collection = Collection::find($id);
        } else if ($code) {
            $collection = Collection::whereCode($code)->first();
        }
        return $collection ? $collection->id : null;
    }
    
    protected function _getDivisionId($id, $code)
    {
        $division = null;
        if ($id) {
            $division = Division::find($id);
        } else if ($code) {
            $division = Division::whereCode($code)->first();
        }
        return $division ? $division->id : null;
    }
    
    protected function _getProductId($id, $code)
    {
        $product = null;
        if ($id) {
            $product = Product::find($id);
        } else if ($code) {
            $product = Product::whereCode($code)->first();
        }
        return $product ? $product->id : null;
    }
    
    
    
}