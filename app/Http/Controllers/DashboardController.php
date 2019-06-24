<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends BackendController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('dashboard/index');
    }
}
