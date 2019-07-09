<?php

namespace App\Providers;


use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\AclResources;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
            //Client::class => ClientPolicy::class,
    ];

    
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $resources = AclResources::all();
        foreach ($resources as $resource) {
            Gate::define($resource->id, function ($user) use ($resource) {
                // strong variant
                 return $user->role_id && $user->role && isset($user->role->rights[$resource->id]) && $user->role->rights[$resource->id];
                
                // soft variant
                /*
                if ($user->role_id && $user->role && isset($user->role->rights[$resource->id])) {
                    return $user->role->rights[$resource->id];
                } else {
                    return true;
                }
                */
            });
        }
        
    }
    
}
