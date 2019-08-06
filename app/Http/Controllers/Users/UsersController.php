<?php

namespace App\Http\Controllers\Users;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\BackendController;
use App\Http\Requests\User as UserRequest;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\User;
use App\UserGroup;
use App\Employee;
use App\AclRole;
use App\Store;

class UsersController extends BackendController
{
    protected $_aclResource = 'users';
    
    protected $_filterFields = [
            'fActive',
            'fDisplayName',
            'fEmail',
            'fUserGroupId',
            'fRoleId',
            'fEmailSubscribe',
    ];
    
    public function index(Request $request)
    {
        $filter = $this->_getFilter($request);
        $userGroups = UserGroup::orderBy('name')->get();
        $roles = AclRole::orderBy('name')->get();
        
        return view('users.users.index', compact('userGroups', 'roles', 'filter'));
    }

    
    public function form(Request $request, $id)
    {
        $user = $id ? User::find($id) : null;
        $userGroups = UserGroup::orderBy('name')->get();
        $employees = Employee::orderBy('name')->where('active', '=', 1)->get();
        $roles = AclRole::orderBy('name')->get();
        $stores = Store::orderBy('name')->get();
        $userStores = $user ? array_column($user->stores->toArray(), 'name', 'id') : [];
        
        $filter = $this->_getFilter($request);
        
        $token = $request->session()->pull('userToken');
        
    	return view('users.users.form', compact('user', 'userGroups', 'employees', 
    	        'roles', 'stores', 'userStores', 'token', 'filter'));
    }
    
    public function store(UserRequest $request, $id)
    {
        $user = $id ? User::find($id) : null;
    	
        if (!$user) {
            $user = new User();
            $user->created_by = (int) Auth::id();
            $user->created_date = date('Y-m-d H:i:s');
	    }
	    $user->fill($request->all());
	    
	    $token = false;
        $password = $request->input('password');
        if (strlen($password)) {
            $user->password = Hash::make($password);
            
            if ($request->input('qrcode')) {
                // {"login": "salesman1@mail.ru","password": "test12345678"}
                $forToken = new \stdClass();
                $forToken->login = $request->input('email');
                $forToken->password = $password;
                $strToken = json_encode($forToken);
                $token = str_random(3) . base64_encode($strToken);
                $request->session()->put('userToken', $token);
            }
        }
        
	    $user->modified_date = date('Y-m-d H:i:s');
	    $user->modified_by = (int) Auth::id();
	    $user->save();
	    
	    $user->stores()->sync($request->stores);
	    
	    if ($token) {
	        return redirect()->route('users.form', $user->id)->with('success', 'User has been saved');
	    }
	    return redirect()->route('users.index')->with('success', 'User has been saved');
    }
    
    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
    	
    	return redirect()->route('users.index')
    	   ->with('success', 'User has been deleted Successfully');
    }
    
    public function data(Request $request)
    {
        //return Datatables::of(User::query())->make(true);
        
        $filter = $this->_getFilter($request);
        
        $model = User::query();
        
        return DataTables::of($model)
            ->escapeColumns([])
            ->only(['active','display_name', 'email', 'group_id', 'role_id', 'email_subscribe', 'created_date'])
            ->addColumn('actions', 'actions {{ $id }}')
            ->editColumn('active', function($user) {
                return view('helpers.viewBool', array('value' => $user->active));
            })
            ->editColumn('display_name', function($user) {
                return view('users.users.name-column', array('user' => $user));
            })
            ->editColumn('email', function($user) {
                return view('helpers.viewEmail', array('value' => $user->email));
            })
            ->editColumn('group_id', function($user) {
                return $user->group->name;
            })
            ->editColumn('role_id', function($user) {
                return $user->role->name;
            })
            ->editColumn('email_subscribe', function($user) {
                return view('helpers.viewBool', array('value' => $user->email_subscribe));
            })
            ->editColumn('created_date', function($user) {
                return view('helpers.viewDate', array('value' => $user->created_date));
            })
            ->filter(function ($query) use ($filter, $request) {
                if ($filter->fActive) {
                    $query->where('active', '=', ($filter->fActive == 1) ? '1': '0');
                }
                if ($filter->fDisplayName) {
                    $query->where('display_name', 'like', "%" . $filter->fDisplayName . "%");
                }
                if ($filter->fEmail) {
                    $query->where('email', 'like', "%" . $filter->fEmail . "%");
                }
                if ($filter->fUserGroupId) {
                    $query->where('group_id', '=', $filter->fUserGroupId);
                }
                if ($filter->fRoleId) {
                    $query->where('role_id', '=', $filter->fRoleId);
                }
                if ($filter->fEmailSubscribe) {
                    $query->where('email_subscribe', '=', ($filter->fEmailSubscribe == 1) ? '1': '0');
                }
                
                $search = $request->get('search');
                if ($search['value']) {
                    $query->where(function ($query) use ($search) {
                        $query->orWhere('username', 'like', "%" . $search['value'] . "%")
                            ->orWhere('display_name', 'like', "%" . $search['value'] . "%")
                            ->orWhere('email', 'like', "%" . $search['value'] . "%");
                    });
                }
            })
            ->toJson();
            
    }
    
    public function filter(Request $request)
    {
        $filter = $this->_getFilter($request);
        foreach ($this->_filterFields as $filterField) {
            if ($request->has($filterField)) {
                $filter->{$filterField} = $request->get($filterField);
            }
        }
        $request->session()->put('usersFilter', $filter);
    }
    
    protected function _getFilter(Request $request)
    {
        if ($request->session()->has('usersFilter')) {
            $filter = $request->session()->get('usersFilter');
        } else {
            $filter = new \stdClass();
            foreach ($this->_filterFields as $filterField) {
                $filter->{$filterField} = '';
            }
        }
        return $filter;
    }
    
}
