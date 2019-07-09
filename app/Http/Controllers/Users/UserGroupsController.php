<?php

namespace App\Http\Controllers\Users;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BackendController;
use App\Http\Requests\UserGroup as UserGroupRequest;
use App\UserGroup;
use App\IposUserRights;

class UserGroupsController extends BackendController
{
    protected $_aclResource = 'userGroups';
    
    public function index()
    {
        $groups = UserGroup::all();
        $iposUserRightsModel = new IposUserRights();
        $userRights = $iposUserRightsModel->findAll();
        $userRightValues = $iposUserRightsModel->getRightsValues();
        return view('users.userGroups.index', compact('groups', 'userRights', 'userRightValues'));
    }

    
    public function form($id)
    {
        $group = $id ? UserGroup::find($id) : null;
        $iposUserRightsModel = new IposUserRights();
        $userRights = $iposUserRightsModel->findAll();
        $userRightValues = $iposUserRightsModel->getRightsValues();
    	return view('users.userGroups.form', compact('group', 'userRights', 'userRightValues'));
    }
    
    public function store(UserGroupRequest $request, $id)
    {
        $group = $id ? UserGroup::find($id) : null;
    	
        if (!$group) {
            $group = new UserGroup();
            $group->created_by = Auth::id();
            $group->created_date = date('Y-m-d H:i:s');
	    }
	    $group->fill($request->all());
        
	    $group->modified_date = date('Y-m-d H:i:s');
	    $group->modified_by = Auth::id();
	    $group->save();
	    
	    return redirect()->route('userGroups.index')->with('success', 'User group has been saved');
    }
    
    public function delete($id)
    {
        $group = UserGroup::find($id);
        $group->delete();
    	
    	return redirect()->route('userGroups.index')
    	   ->with('success', 'User group has been deleted Successfully');
    }
    
}
