<?php

namespace App\Http\Controllers\Crm;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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
use App\Company;
use App\Http\Controllers\Filter;
use Yajra\Datatables\Datatables;
use App\Exceptions\AppException;


class ClientsController extends BackendController
{
    use Filter;
    
    protected $_aclResource = 'clients';
    
    public function __construct()
    {
        parent::__construct();
        
        $this->_setFilterFields([
                'fId',
                'fName',
                'fEmail',
                'fPhone',
                'fCountry',
                'fCity',
                'fVoiceOptIn',
                'fEmailOptIn',
                'fMsgOptIn',
                'fPostalOptIn',
                'fConsentSigned',
                'fResponsible',
                'fStore',
        ]);
    }
    
    public function index(Request $request)
    {
        //view()->getFinder()->getPaths()
        
        /*
        $clients = Client::all();
        if ($clients) {
            foreach  ($clients as $client) {
                $amlMini = AmlMini::where('client_id', '=', $client->id)->orderBy('created_date', 'desc')->first();
                if ($amlMini) {
                    $manager = new AmlManager();
                    $amlMini->report = $manager->getReport($amlMini);
                }
                $client->amlMini = $amlMini ?? null;
            }
        }
        compact('clients')
        */
        $filter = $this->_getFilter($request);
        
        $countries = Country::orderBy('name')->get();
        $stores = Store::orderBy('name')->get();
        $employees = Employee::orderBy('name')->get();
        
        return view('crm.clients.index', compact('filter', 'countries', 'stores', 'employees'));
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
    
    public function form(Request $request, $id)
    {
        $client = $id ? Client::find($id) : null;
        $countries = Country::orderBy('name')->get();
        $timeZoneModel = new TimeZone();
        $timeZones = $timeZoneModel->asOptions();
        $employees = Employee::orderBy('name')->where('active', '=', 1)->get();
        $stores = Store::orderBy('name')->get();
        $companyInfo = Company::getInfo();
        $currentUser = Auth::user();
        
        $filter = $this->_getFilter($request);
        
        return view('crm.clients.form', compact('client', 'countries', 'timeZones', 
                'employees', 'stores', 'companyInfo', 'currentUser', 'filter'));
    }
    
    public function store(ClientRequest $request, $id)
    {
        $client = $id ? Client::find($id) : null;
    	
        if (!$client) {
            $client = new Client();
            $client->created_by = Auth::id();
            $client->created_date = date('Y-m-d H:i:s');
	    }
	    $data = $request->all();
	    $data['discount'] = intval($data['discount']);
	    $client->fill($data);

	    $client->name = trim(implode(' ', [$client->last_name, $client->first_name, $client->middle_name]));
	    
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
                
        $client = Auth::user();
        $amlReport->responsible_id = $client->employee_id ?: null; 
        $amlReport->check_date = date('Y-m-d H:i:s');
        
        $amlReport->modified_date = date('Y-m-d H:i:s');
        $amlReport->modified_by = Auth::id();
        $amlReport->save();
        
        return redirect()->route('clients.info', ['clientId' => $amlReport->client])->with('success', __('messages.reportAmlSaved'));
    }
    
    public function data(Request $request)
    {
        $filter = $this->_getFilter($request);
        
        $model = Client::query();
        
        return DataTables::of($model)
        ->escapeColumns([])
        ->only(['id','name', 'email', 'phone', 'birthday', 'country', 'city', 'voice_opt_in', 'email_opt_in', 'msg_opt_in', 
                'postal_opt_in', 'consent_signed', 'consent_file_id', 'mini', 'aml', 'responsible', 'store'])
        ->editColumn('id', function($client) {
            return $client->id; //view('helpers.viewBool', array('value' => $client->active));
        })
        ->editColumn('name', function($client) {
            return view('helpers.viewLink', array(
                    'link' => route('clients.info', $client->id), 
                    'content' => $client->name));
        })
        ->editColumn('email', function($client) {
            return view('helpers.viewEmail', array(
                    'value' => $client->email));
        })
        ->editColumn('phone', function($client) {
            return view('helpers.viewPhone', array(
                    'value' => $client->phone));
        })
        ->editColumn('birthday', function($client) {
            return $client->bd_day . '/' . $client->bd_month . '/' . $client->bd_year;
        })
        ->editColumn('country', function($client) {
            return $client->country->name;
        })
        ->editColumn('city', function($client) {
            return $client->city;
        })
        ->editColumn('voice_opt_in', function($client) {
            return '<div class="text-center '. ($client->voice_opt_in ? 'text-success' : 'text-light-gray') . '"><i class="fa fa-phone-square"></i></div>';
        })
        ->editColumn('email_opt_in', function($client) {
            return '<div class="text-center '. ($client->email_opt_in ? 'text-success' : 'text-light-gray') . '"><i class="fa fa-envelope"></i></div>';
        })
        ->editColumn('msg_opt_in', function($client) {
            return '<div class="text-center '. ($client->msg_opt_in ? 'text-success' : 'text-light-gray') . '"><i class="fa fa-comment-alt"></i></div>';
        })
        ->editColumn('postal_opt_in', function($client) {
            return '<div class="text-center '. ($client->postal_opt_in ? 'text-success' : 'text-light-gray') . '"><i class="fa fa-home"></i></div>';
        })
        ->editColumn('consent_signed', function($client) {
            return view('helpers.viewBool', array('value' => $client->consent_signed));
        })
        ->editColumn('consent_file_id', function($client) {
            $html = '<div class="text-center">';
            if ($client->consent_file_id) {
                $html .= '<a href="' . route('file.view', $client->consent_file_id) . '"><i class="fa fa-eye"></i></a> ';
                $html .= '<a href="' . route('file.download', $client->consent_file_id) . '"><i class="fa fa-download"></i></a>';
            } else {
                $html .= '---';
            }
            $html .= '</div>';
            return $html;
        })
        ->editColumn('mini', function($client) {
            $amlMini = AmlMini::where('client_id', '=', $client->id)->orderBy('created_date', 'desc')->first();
            if ($amlMini) {
                $manager = new AmlManager();
                $amlMini->report = $manager->getReport($amlMini);
            }
            $client->amlMini = $amlMini ?? null;
            
            $html = '<div class="text-center">';
            if ($client->amlMini) {
                $html .= '<a href="' . route('file.view',  $client->amlMini->questionnaire_file_id) . '"><i class="fa fa-eye"></i></a> ';
                $html .= '<a href="' . route('file.download',  $client->amlMini->questionnaire_file_id) . '"><i class="fa fa-download"></i></a>';
            } else {
                $html .= '---';
            }
            $html .= '</div>';
            return $html;
        })
        ->editColumn('aml', function($client) {
            $html = '<div class="text-center">';
            if ($client->amlMini) {
                if ($client->amlMini->report->status()->id == \App\AmlReportStatus::COMPLETED) {
                    $html .= '<a href="' . route('clients.amlReportView', $client->amlMini->report->id) . '"><i class="fa fa-eye"></i></a>';
                } else {
                    $html .= '<a href="' . route('clients.amlReport', $client->amlMini->report->id) . '"><i class="fa fa-edit"></i></a>';
                }
            } else {
                $html .= '---';
            }
            $html .= '</div>';
            return $html;
        })
        ->editColumn('responsible', function($client) {
            return $client->responsible->name;
        })
        ->editColumn('store', function($client) {
            return $client->attachedStore->name;
        })
        
        ->orderColumn('birthday', 'CONCAT(bd_year, bd_month, bd_day) $1')
        
        ->filter(function ($query) use ($filter, $request) {
            if ($filter->fId) {
                $query->where('id', 'like', "%" . $filter->fId . "%");
            }
            if ($filter->fName) {
                $query->where('name', 'like', "%" . $filter->fName . "%");
            }
            if ($filter->fEmail) {
                $query->where('email', 'like', "%" . $filter->fEmail . "%");
            }
            if ($filter->fPhone) {
                $query->where('phone', 'like', "%" . $filter->fPhone . "%");
            }
            if ($filter->fCountry) {
                $query->where('country_id', $filter->fCountry);
            }
            if ($filter->fCity) {
                $query->where('city', 'like', "%" . $filter->fCity . "%");
            }
            if ($filter->fVoiceOptIn) {
                $query->where('voice_opt_in', '=', ($filter->fVoiceOptIn == 1) ? '1': '0');
            }
            if ($filter->fEmailOptIn) {
                $query->where('email_opt_in', '=', ($filter->fEmailOptIn == 1) ? '1': '0');
            }
            if ($filter->fMsgOptIn) {
                $query->where('msg_opt_in', '=', ($filter->fMsgOptIn == 1) ? '1': '0');
            }
            if ($filter->fPostalOptIn) {
                $query->where('postal_opt_in', '=', ($filter->fPostalOptIn == 1) ? '1': '0');
            }
            if ($filter->fResponsible) {
                $query->where('responsible_id', '=', $filter->fResponsible);
            }
            if ($filter->fStore) {
                $query->where('attached_store_id', '=', $filter->fStore);
            }
            
            $search = $request->get('search');
            if (strlen(trim($search['value']))) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('id', 'like', "%" . $search['value'] . "%")
                    ->orWhere('code', 'like', "%" . $search['value'] . "%")
                    ->orWhere('name', 'like', "%" . $search['value'] . "%")
                    ->orWhere('first_name_lat', 'like', "%" . $search['value'] . "%")
                    ->orWhere('last_name_lat', 'like', "%" . $search['value'] . "%")
                    ->orWhere('email', 'like', "%" . $search['value'] . "%")
                    ->orWhere('phone', 'like', "%" . $search['value'] . "%")
                    ->orWhere('comment', 'like', "%" . $search['value'] . "%")
                    ->orWhere('birth_place', 'like', "%" . $search['value'] . "%")
                    ->orWhere('postcode', 'like', "%" . $search['value'] . "%")
                    ->orWhere('city', 'like', "%" . $search['value'] . "%")
                    ->orWhere('address', 'like', "%" . $search['value'] . "%")
                    ->orWhere('passport_series', 'like', "%" . $search['value'] . "%")
                    ->orWhere('passport_number', 'like', "%" . $search['value'] . "%")
                    ->orWhere('passport_issued_by', 'like', "%" . $search['value'] . "%")
                    ->orWhere('passport_subdivision_code', 'like', "%" . $search['value'] . "%")
                    ->orWhere('inn', 'like', "%" . $search['value'] . "%")
                    ->orWhere('registration_address', 'like', "%" . $search['value'] . "%")
                    ;
                });
            }
        })
        ->toJson();
        
    }
}
