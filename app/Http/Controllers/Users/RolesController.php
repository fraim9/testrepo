<?php

namespace App\Http\Controllers\Users;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BackendController;
use App\Http\Requests\AclRole as AclRoleRequest;
use App\AclRole;
use App\AclResources;

class RolesController extends BackendController
{

    public function index()
    {
        $roles = AclRole::all();
        return view('users.roles.index', compact('roles'));
    }

    
    public function form($id)
    {
        $role = $id ? AclRole::find($id) : null;
        $resources = (new AclResources())->findAll();
    	return view('users.roles.form', compact('role', 'resources'));
    }
    
    public function store(AclRoleRequest $request, $id)
    {
        $role = $id ? AclRole::find($id) : null;
    	
        if (!$role) {
            $role = new AclRole();
            $role->created_by = (int) Auth::id();
            $role->created_date = date('Y-m-d H:i:s');
	    }
	    $role->fill($request->all());
	    
	    $role->modified_date = date('Y-m-d H:i:s');
	    $role->modified_by = (int) Auth::id();
	    $role->save();
	    
	    return redirect()->route('aclRoles.index')->with('success', 'Role has been saved');
    }
    
    public function delete($id)
    {
        $user = AclRole::find($id);
        $user->delete();
    	
    	return redirect()->route('aclRoles.index')
    	    ->with('success', 'Role has been deleted Successfully');
    }
    
}
