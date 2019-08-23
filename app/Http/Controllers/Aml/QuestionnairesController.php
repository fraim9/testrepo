<?php

namespace App\Http\Controllers\Aml;

use Illuminate\Http\Request;
use App\Http\Controllers\BackendController;
use App\Client;
use App\Employee;
use App\Store;
use App\Services\AmlManager;
use App\Http\Controllers\Filter;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use App\Services\ReturnHelper;


class QuestionnairesController extends BackendController
{
    use Filter;
    
    protected $_aclResource = 'amlQuestionnaires';
    
    public function __construct()
    {
        parent::__construct();
        
        $this->_setFilterFields([
                'fMiniId',
                'fStore',
                'fInitiator',
                'fReportId',
                'fResponsible',
                'fClientId',
                'fClient',
        ]);
    }
    
    public function index(Request $request)
    {
        // запоминаем, куда нужно вернуться после редактирования AML отчета
        ReturnHelper::set('questionnaires.index', 'amlReportStore');
        
        $filter = $this->_getFilter($request);
        
        $clients = Client::orderBy('name')->get();
        $stores = Store::orderBy('name')->get();
        $employees = Employee::orderBy('name')->get();
        
        return view('aml.questionnaires.index', compact('filter', 'stores', 'employees', 'clients'));
        
    }
    
    
    public function data(Request $request)
    {
        $filter = $this->_getFilter($request);

        $model = DB::table('aml_mini_quest')
        ->leftJoin('store', 'aml_mini_quest.store_id', '=', 'store.id')
        ->leftJoin('employee as initiator', 'aml_mini_quest.initiator_id', '=', 'initiator.id')
        ->leftJoin('client', 'aml_mini_quest.client_id', '=', 'client.id')
        ->leftJoin('aml_report', 'aml_mini_quest.id', '=', 'aml_report.mini_quest_id')
        ->leftJoin('employee as responsible', 'aml_report.responsible_id', '=', 'responsible.id')
        ->select(
                'aml_mini_quest.*', 
                'store.name as storeName', 
                'initiator.name as initiatorName', 
                'client.name as clientName',
                'responsible.name as responsibleName',
                'aml_report.id as reportId',
                'aml_report.modified_date as reportModified'
                );
        
        return DataTables::of($model)
            ->escapeColumns([])
            ->only(['miniId','mini', 'store', 'initiator', 'created', 'idReport', 'report', 'responsible', 'modified',
                'clientId', 'clientName'])
                ->editColumn('miniId', function($mini) {
                    return $mini->id;
                })
                ->editColumn('mini', function($mini) {
                    $manager = new AmlManager();
                    $mini->report = $manager->getReport($mini);
                    
                    $html = '<div class="text-center">';
                    $html .= '<a href="' . route('file.view',  $mini->questionnaire_file_id) . '"><i class="fa fa-eye"></i></a> ';
                    $html .= '<a href="' . route('file.download',  $mini->questionnaire_file_id) . '"><i class="fa fa-download"></i></a>';
                    $html .= '</div>';
                    return $html;
                })
                ->editColumn('store', function($mini) {
                    return $mini->storeName;
                    //return $mini->store->name;
                })
                ->editColumn('initiator', function($mini) {
                    return $mini->initiatorName;
                    //return $mini->initiator->name;
                })
                ->editColumn('created', function($mini) {
                    return view('helpers.viewDate', array(
                            'value' => $mini->created_date, 'format' => 'd M Y, H:i'));
                })
                ->editColumn('idReport', function($mini) {
                    return $mini->report->id;
                })
                ->editColumn('report', function($mini) {
                    $html = '<div class="text-center">';
                    if ($mini->report->status()->id == \App\AmlReportStatus::COMPLETED) {
                        $html .= '<a href="' . route('clients.amlReportView', $mini->report->id) . '?from=questionnaires.index"><i class="fa fa-eye"></i></a>';
                    } else {
                        $html .= '<a href="' . route('clients.amlReport', $mini->report->id) . '?from=questionnaires.index"><i class="fa fa-edit"></i></a>';
                    }
                    $html .= '</div>';
                    return $html;
                })
                ->editColumn('responsible', function($mini) {
                    return $mini->responsibleName;
                    //return $mini->report->responsible->name;
                })
                ->editColumn('modified', function($mini) {
                    return view('helpers.viewDate', array(
                            'value' => $mini->reportModified, 'format' => 'd M Y, H:i'));
                })
                ->editColumn('clientId', function($mini) {
                    return $mini->client_id;
                })
                ->editColumn('clientName', function($mini) {
                    return view('helpers.viewLink', array(
                            'link' => route('clients.info', $mini->client_id),
                            'content' => $mini->clientName));
                    //return $mini->clientName;
                    //return $mini->client->name;
                })
                
                ->orderColumn('miniId', 'id $1')
                ->orderColumn('store', 'storeName $1')
                ->orderColumn('initiator', 'initiatorName $1')
                ->orderColumn('created', 'created_date $1')
                ->orderColumn('idReport', 'reportId $1')
                ->orderColumn('responsible', 'responsibleName $1')
                ->orderColumn('modified', 'reportModified $1')
                ->orderColumn('clientId', 'client_id $1')
                ->orderColumn('clientName', 'clientName $1')
                
                ->filter(function ($query) use ($filter, $request) {
                    if ($filter->fMiniId) {
                        $query->where('aml_mini_quest.id', 'like', "%" . $filter->fMiniId . "%");
                    }
                    if ($filter->fStore) {
                        $query->where('aml_mini_quest.store_id', '=', $filter->fStore);
                    }
                    if ($filter->fInitiator) {
                        $query->where('aml_mini_quest.initiator_id', '=', $filter->fInitiator);
                    }
                    if ($filter->fReportId) {
                        $query->where('aml_report.id', 'like', "%" . $filter->fReportId . "%");
                    }
                    if ($filter->fResponsible) {
                        $query->where('aml_report.responsible_id', $filter->fResponsible);
                    }
                    if ($filter->fClientId) {
                        $query->where('aml_mini_quest.client_id', 'like', "%" . $filter->fClientId . "%");
                    }
                    if ($filter->fClient) {
                        $query->where('aml_mini_quest.client_id', '=', $filter->fClient);
                    }
                    
                    $search = $request->get('search');
                    if (strlen(trim($search['value']))) {
                        $query->where(function ($query) use ($search) {
                            $query->orWhere('aml_mini_quest.id', 'like', "%" . $search['value'] . "%")
                            ->orWhere('aml_mini_quest.client_id', 'like', "%" . $search['value'] . "%")
                            ->orWhere('store.name', 'like', "%" . $search['value'] . "%")
                            ->orWhere('initiator.name', 'like', "%" . $search['value'] . "%")
                            ->orWhere('client.name', 'like', "%" . $search['value'] . "%")
                            ->orWhere('responsible.name', 'like', "%" . $search['value'] . "%")
                            ->orWhere('aml_report.id', 'like', "%" . $search['value'] . "%")
                            ;
                        });
                    }
                })
                ->toJson();
                
    }
}
