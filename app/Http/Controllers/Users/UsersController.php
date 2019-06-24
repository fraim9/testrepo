<?php

namespace App\Http\Controllers\Users;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\BackendController;
use App\Http\Requests\User as UserRequest;
use App\User;
use App\UserGroup;

class UsersController extends BackendController
{

    public function index()
    {
        $users = User::all();
        return view('users.users.index', compact('users'));
    }

    
    public function form($id)
    {
        $user = $id ? User::find($id) : null;
        $userGroups = UserGroup::orderBy('name')->get();
    	return view('users.users.form', compact('user', 'userGroups'));
    }
    
    public function store(UserRequest $request, $id)
    {
        $user = $id ? User::find($id) : null;
    	
        if (!$user) {
            $user = new User();
            $user->created_by = Auth::id();
            $user->created_date = date('Y-m-d H:i:s');
	    }
	    $user->fill($request->all());
	    
        $password = $request->input('password');
        if (strlen($password)) {
            $user->password = Hash::make($password);
        }
        
	    $user->modified_date = date('Y-m-d H:i:s');
	    $user->modified_by = Auth::id();
	    $user->save();
	    
	    return redirect()->route('users.index')->with('success', 'User has been saved');
    }
    
    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
    	
    	return redirect()->route('users.index')
    	   ->with('success', 'User has been deleted Successfully');
    }
    
}
