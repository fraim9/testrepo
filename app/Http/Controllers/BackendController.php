<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;

class BackendController extends Controller
{
    protected $_aclResource = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Execute an action on the controller.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function callAction($method, $parameters)
    {
        if (Gate::denies('backendAccess')) {
            abort(403);
        }
        
        if (strlen($this->_aclResource)) {
            if (Gate::denies($this->_aclResource)) {
                abort(403);
            }
        }
        
        return call_user_func_array([$this, $method], $parameters);
    }

}
