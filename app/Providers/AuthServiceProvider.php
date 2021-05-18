<?php

namespace App\Providers;

use App\Models\Gear;
use App\Models\Gearset;
use App\Policies\GearPolicy;
use App\Policies\GearsetPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Gear::class => GearPolicy::class,
        Gearset::class => GearsetPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
