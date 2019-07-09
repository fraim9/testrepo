<?php

namespace App\Http\Controllers\Company;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BackendController;
use App\Http\Requests\Employee as EmployeeRequest;
use App\Employee;
use App\Division;


class EmployeesController extends BackendController
{
    protected $_aclResource = 'employees';
    
    public function index()
    {
        $employees = Employee::all();
        return view('company.employees.index', compact('employees'));
    }

    
    public function form($id)
    {
        $employee = $id ? Employee::find($id) : null;
        $divisions = Division::orderBy('sort')->where('active', '=', 1)->get();
    	return view('company.employees.form', compact('employee', 'divisions'));
    }
    
    public function store(EmployeeRequest $request, $id)
    {
        $employee = $id ? Employee::find($id) : null;
    	
        if (!$employee) {
            $employee = new Employee();
            $employee->created_by = Auth::id();
            $employee->created_date = date('Y-m-d H:i:s');
	    }
	    $employee->fill($request->all());
	    
	    $employee->modified_date = date('Y-m-d H:i:s');
	    $employee->modified_by = Auth::id();
	    $employee->save();
	    
	    return redirect()->route('employees.index')->with('success', 'Employee has been saved');
    }
    
    public function delete($id)
    {
        $employee = Employee::find($id);
        $employee->delete();
    	
    	return redirect()->route('employees.index')
    	   ->with('success', 'Employee has been deleted Successfully');
    }
    
}
