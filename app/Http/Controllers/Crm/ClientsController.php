<?php

namespace App\Http\Controllers\Crm;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BackendController;
use App\Http\Requests\Client as ClientRequest;
use App\Http\Requests\AmlReport as AmlReportRequest;
use App\Client;
use App\Country;
use App\TimeZone;
use App\Employee;
use App\Store;
use App\AmlMini;
use App\Services\AmlManager;
use App\AmlReport;
use App\AmlReportQuestion;
use App\AmlReportStatus;


class ClientsController extends BackendController
{
    protected $_aclResource = 'clients';
    
    
    public function index()
    {
        $clients = Client::all();
        return view('crm.clients.index', compact('clients'));
    }

    
    public function info($id)
    {
        $client = $id ? Client::find($id) : null;
        
        if (!$client) {
            abort(404);
        }
        
        $amlMiniList = AmlMini::where('client_id', '=', $client->id)->orderBy('created_date', 'desc')->get();
        if ($amlMiniList) {
            $manager = new AmlManager();
            foreach ($amlMiniList as $amlMini) {
                $amlMini->report = $manager->getReport($amlMini);
            }
        }
        
        /*
        $countries = Country::orderBy('name')->get();
        $timeZoneModel = new TimeZone();
        $timeZones = $timeZoneModel->asOptions();
        $employees = Employee::orderBy('name')->where('active', '=', 1)->get();
        $stores = Store::orderBy('name')->get();
        */
        
        return view('crm.clients.info', compact('client', 'amlMiniList'));
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
	    
	    return redirect()->route('clients.info', ['clientId' => $client->id])->with('success', 'Client has been saved');
    }
    
    public function delete($id)
    {
        $client = Client::find($id);
        $client->delete();
    	
    	return redirect()->route('clients.index')
    	   ->with('success', 'Client has been deleted Successfully');
    }
    
    public function amlReport($id)
    {
        $amlReport = AmlReport::find($id);
        $amlMini = $amlReport->miniQuest;
        $client = $amlReport->client;
        $countries = Country::orderBy('name')->get();
        $amlReportQuestions = new AmlReportQuestion();
        $amlReportQuestions->setAmlMini($amlMini);
        $questions = $amlReportQuestions->findAll();
        $dateText = (new \DateTime($amlMini->created_date))->format('d.m.Y');
        $statusList = (new AmlReportStatus())->findAll();
        $currentEmployee = Auth::user()->employee;
        return view('crm.clients.amlReport', compact('amlReport', 'amlMini', 
                'client', 'countries', 'questions', 'dateText', 'statusList', 'currentEmployee'));
    }
    
    public function amlReportView($id)
    {
        $amlReport = AmlReport::find($id);
        $amlMini = $amlReport->miniQuest;
        $client = $amlReport->client;
        $countries = Country::orderBy('name')->get();
        $questions = (new AmlReportQuestion())->findAll();
        return view('crm.clients.amlReportView', compact('amlReport', 'amlMini',
                'client', 'countries', 'questions'));
    }
    
    public function amlReportStore(AmlReportRequest $request, $id)
    {
        $amlReport = AmlReport::find($id);
        if (!$amlReport) {
            abort(404);
        }
        
        $amlReport->fill($request->all());
                
        $user = Auth::user();
        $amlReport->responsible_id = $user->employee_id ?: null; 
        $amlReport->check_date = date('Y-m-d H:i:s');
        
        $amlReport->modified_date = date('Y-m-d H:i:s');
        $amlReport->modified_by = Auth::id();
        $amlReport->save();
        
        return redirect()->route('clients.info', ['clientId' => $amlReport->client])->with('success', __('messages.reportAmlSaved'));
    }
    
    
}
