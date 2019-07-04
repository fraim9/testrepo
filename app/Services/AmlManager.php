<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\AmlReport;
use App\AmlReportStatus;

class AmlManager
{
    
    public function getReport($amlMini)
    {
        $report = AmlReport::where('mini_quest_id', '=', $amlMini->id)->first();
        if (!$report) {
            $report = $this->createReport($amlMini);
        }
        return $report;
    }
    
    public function createReport($amlMini)
    {
        $report = new AmlReport();
        $report->mini_quest_id = $amlMini->id;
        $report->store_id = $amlMini->store_id;
        $report->initiator_id = $amlMini->initiator_id;
        //$report->responsible_id = 0;
        
        $report->last_name = $amlMini->last_name;
        $report->first_name = $amlMini->first_name;
        $report->middle_name = $amlMini->middle_name;
       
        $report->birth_date = $amlMini->birth_date;
        
        $report->client_id = $amlMini->client_id;
        $report->citizenship_id = $amlMini->citizenship_id;
        
        $report->passport_series = $amlMini->passport_series;
        $report->passport_number = $amlMini->passport_number;
        $report->passport_issued_date = $amlMini->passport_issued_date;
        $report->passport_issued_by = $amlMini->passport_issued_by;
        $report->passport_subdivision_code = $amlMini->passport_subdivision_code;

        $report->inn = $amlMini->inn;
        $report->registration_address = $amlMini->registration_address;
        $report->residence_address = $amlMini->residence_address;

        $report->migration_series = $amlMini->migration_series;
        $report->migration_number = $amlMini->migration_number;
        $report->migration_stay_from = $amlMini->migration_stay_from;
        $report->migration_stay_to = $amlMini->migration_stay_to;
        
        $report->permission_series = $amlMini->permission_series;
        $report->permission_number = $amlMini->permission_number;
        $report->permission_stay_from = $amlMini->permission_stay_from;
        $report->permission_stay_to = $amlMini->permission_stay_to;
        
        $report->questionnaire = '';
        $report->status = AmlReportStatus::DRAFT;
        $report->check_number = 0;
        $report->check_date = now();
        $report->qty = 0;
        $report->amount = 0;
        $report->amount_no_disc = 0;
        $report->sales_id = null;
        
        $report->created_by = Auth::id();
        $report->created_date = date('Y-m-d H:i:s');
        $report->modified_by = Auth::id();
        $report->modified_date = date('Y-m-d H:i:s');
        $report->save();
        
        return $report;
    }
    
}