<?php

namespace App\Http\Controllers\Stores;

use App\Employee;
use App\Http\Controllers\Filter;
use App\Services\ReturnHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BackendController;
use App\Http\Requests\Store as StoreRequest;
use App\Store;
use App\StoreGroup;
use App\Country;
use App\City;
use App\TimeZone;
use App\Price;
use App\Company;
use Yajra\DataTables\DataTables;

class StoresController extends BackendController
{
    use Filter;
    
    protected $_aclResource = 'stores';
    
    public function __construct()
    {
        parent::__construct();
        
        $this->_setFilterFields([
            'fName',
            'fCode',
            'fPhone',
        ]);
    }
    public function index(Request $request)
    {
        ReturnHelper::set('stores.index', 'amlReportStore');
    
        $filter = $this->_getFilter($request);
    
        return view('stores.stores.index', compact('filter'));
    }
    
    public function form($id)
    {
        $store = $id ? Store::find($id) : null;
        $storeGroups = StoreGroup::orderBy('name')->get();
        $countries = Country::orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $timeZoneModel = new TimeZone();
        $timeZones = $timeZoneModel->asOptions();
        $prices = Price::orderBy('name')->get();
        $companyInfo = Company::getInfo();

    	return view('stores.stores.form', compact('store', 'storeGroups', 'countries',
    	        'cities', 'timeZones', 'prices', 'companyInfo'));
    }
    
    public function store(StoreRequest $request, $id)
    {
        $store = $id ? Store::find($id) : null;
    	
        if (!$store) {
            $store = new Store();
            $store->created_by = Auth::id();
            $store->created_date = date('Y-m-d H:i:s');
	    }
	    $store->fill($request->all());
	    
	    $store->modified_date = date('Y-m-d H:i:s');
	    $store->modified_by = Auth::id();
	    $store->save();
	    
	    return redirect()->route('stores.index')->with('success', 'Store has been saved');
    }
    
    public function delete($id)
    {
        $store = Store::find($id);
        $store->delete();
    	
    	return redirect()->route('stores.index')
    	   ->with('success', 'Store has been deleted Successfully');
    }
    
    public function data(Request $request)
    {
        $filter = $this->_getFilter($request);
        
        $model = Store::query();
        
        return DataTables::of($model)
             ->escapeColumns([])
             ->only(['id', 'name', 'code', 'phone', 'group', 'currency', ])
             ->editColumn('name', function($model) {
                 return view('helpers.viewLink', array(
                     'link' => route('stores.form', $model->id),
                     'content' => $model->name));
             })
             ->editColumn('code', function($model) {
                 return $model->code;
             })
             ->editColumn('phone', function($model) {
                 return $model->phone;
             })
             ->editColumn('group', function($model) {
                 return $model->group->name;
             })
             ->editColumn('currency', function($model) {
                 return $model->currency;
             })
             
             ->filter(function ($query) use ($filter, $request) {
                 if ($filter->fName) {
                     $query->where('name', 'like', "%" . $filter->fName . "%");
                 }
                 if ($filter->fCode) {
                     $query->where('code', 'like', "%" . $filter->fCode . "%");
                 }
                 if ($filter->fPhone) {
                     $query->where('phone', 'like', "%" . $filter->fPhone . "%");
                 }
                 
                 $search = $request->get('search');
                 if (strlen(trim($search['value']))) {
                     $query->where(function ($query) use ($search) {
                         $query->orWhere('name', 'like', "%" . $search['value'] . "%")
                               ->orWhere('code', 'like', "%" . $search['value'] . "%")
                               ->orWhere('phone', 'like', "%" . $search['value'] . "%")
                         ;
                     });
                 }
             })
             ->toJson();
        
    }
}
