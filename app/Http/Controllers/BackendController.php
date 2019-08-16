<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Database\QueryException;


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
        try {
            
            return call_user_func_array([$this, $method], $parameters);
            
        } catch (\Exception $e) {
            
            if ($method == 'delete') {
                return $this->deleteErrorHandler($e);
            }
            
            throw $e;
        }
    }

    public function deleteErrorHandler(\Exception $e)
    {
        if ($e instanceof QueryException) {
            if ($e->getCode() == 23000) {
                return redirect()->back()
                    ->with('error', __('Deletion failed because there is related data'));
            }
        }
        
        throw $e;
    }
    
}
