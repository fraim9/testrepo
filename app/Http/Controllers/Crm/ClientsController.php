<?php

namespace App\Http\Controllers\Crm;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BackendController;
use App\Http\Requests\Client as ClientRequest;
use App\Client;
use App\Country;
use App\TimeZone;
use App\Employee;
use App\Store;


class ClientsController extends BackendController
{

    public function index()
    {
        $clients = Client::all();
        return view('crm.clients.index', compact('clients'));
    }

    
    public function form($id)
    {
        $client = $id ? Client::find($id) : null;
        $countries = Country::orderBy('name')->get();
        $timeZoneModel = new TimeZone();
        $timeZones = $timeZoneModel->asOptions();
        $employees = Employee::orderBy('name')->where('active', '=', 1)->get();
        $stores = Store::orderBy('name')->get();
        return view('crm.clients.form', compact('client', 'countries', 'timeZones', 'employees', 'stores'));
    }
    
    public function store(ClientRequest $request, $id)
    {
        $client = $id ? Client::find($id) : null;
    	
        if (!$client) {
            $client = new Client();
            $client->created_by = Auth::id();
            $client->created_date = date('Y-m-d H:i:s');
	    }
	    $client->fill($request->all());

	    $client->name = implode(' ', [$client->last_name, $client->first_name, $client->middle_name]);
	    
	    $client->modified_date = date('Y-m-d H:i:s');
	    $client->modified_by = Auth::id();
	    $client->save();
	    
	    return redirect()->route('clients.index')->with('success', 'Client has been saved');
    }
    
    public function delete($id)
    {
        $client = Client::find($id);
        $client->delete();
    	
    	return redirect()->route('clients.index')
    	   ->with('success', 'Client has been deleted Successfully');
    }
    
}
