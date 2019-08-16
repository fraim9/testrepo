<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\User;
use App\Http\Controllers\Filter;
use App\UserSession;
use App\UserSessionTypes;

class UserSessionsController extends BackendController
{
    use Filter; 
    
    
    protected $_aclResource = 'users';
    
    public function __construct()
    {
        parent::__construct();
        
        $this->_setFilterFields([
                'fUser',
                'fType',
                'fAppName',
                'fAppVersion',
                'fDeviceName',
        ]);
    }
    
    public function index()
    {
        $filter = $this->_getFilter();
        $types = UserSessionTypes::all();
        $users = User::orderBy('display_name')->get();
        $appNames = UserSession::orderBy('app_name')->pluck('app_name', 'app_name');
        $appVersions = UserSession::orderBy('app_version')->pluck('app_version', 'app_version');
        $deviceNames = UserSession::orderBy('device_name')->pluck('device_name', 'device_name');
        
        return view('users.userSessions.index', compact('types', 'users', 'appNames', 'appVersions', 'deviceNames', 'filter'));
    }
    
    public function data(Request $request)
    {
        //return Datatables::of(User::query())->make(true);
        
        $filter = $this->_getFilter();
        
        $model = UserSession::query();
        
        return DataTables::of($model)
            ->escapeColumns([])
            ->only(['date', 'type', 'user', 'app_name', 'app_version', 'device_name'])
            ->editColumn('date', function($session) {
                return $session->date; //view('helpers.viewDate', array('value' => $session->date, 'format' => 'Y-m-d'));
            })
            ->editColumn('type', function($session) {
                $type = UserSessionTypes::getInstance()->find($session->type);
                return $type ? $type->name : '---';
            })
            ->editColumn('user', function($session) {
                return $session->user->display_name;
            })
            ->filter(function ($query) use ($filter, $request) {
                if ($filter->fType) {
                    $query->where('type', $filter->fType - 1);
                }
                if ($filter->fUser) {
                    $query->where('user_id', $filter->fUser);
                }
                if ($filter->fAppName) {
                    $query->where('app_name', $filter->fAppName);
                }
                if ($filter->fAppVersion) {
                    $query->where('app_version', $filter->fAppVersion);
                }
                if ($filter->fDeviceName) {
                    $query->where('device_name', $filter->fDeviceName);
                }
                
                $search = $request->get('search');
                if (strlen(trim($search['value']))) {
                    $query->where(function ($query) use ($search) {
                        $query->orWhere('app_name', 'like', "%" . $search['value'] . "%")
                            ->orWhere('app_version', 'like', "%" . $search['value'] . "%")
                            ->orWhere('device_name', 'like', "%" . $search['value'] . "%");
                    });
                }
            })
            ->toJson();
            
    }
    
}
