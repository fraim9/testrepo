<?php

namespace App\Http\Controllers\Users;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BackendController;
use App\Http\Requests\AclRole as AclRoleRequest;
use App\AclRole;
use App\AclResources;
use App\AclResourceGroups;

class RolesController extends BackendController
{
    protected $_aclResource = 'aclRoles';

    public function index()
    {
        $roles = AclRole::all();
        $resources = (new AclResources())->findAll();
        $resourceByGroup = [];
        foreach ($resources as $resource) {
            $resourceByGroup[$resource->group][$resource->id] = $resource;
        }
        $groups = (new AclResourceGroups())->findAll();
        return view('users.roles.index', compact('roles', 'resourceByGroup', 'groups'));
    }

    
    public function form($id)
    {
        $role = $id ? AclRole::find($id) : null;
        $resources = (new AclResources())->findAll();
        $resourceByGroup = [];
        foreach ($resources as $resource) {
            $resourceByGroup[$resource->group][$resource->id] = $resource;
        }
        $groups = (new AclResourceGroups())->findAll();
    	return view('users.roles.form', compact('role', 'resourceByGroup', 'groups'));
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
	    
	    $resources = (new AclResources())->findAll();
	    $rights = [];
	    foreach ($resources as $resource) {
	        $rights[$resource->id] = ($request->input('rights.' . $resource->id) == 1) ? true : false;
	    }
	    $role->rights = $rights;
	    
	    
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
