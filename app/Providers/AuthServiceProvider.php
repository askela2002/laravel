<?php

namespace App\Providers;

use App\Organization;
use App\Policies\OrganizationPolicy;
use App\Policies\StatPolicy;
use App\Policies\UserPolicy;
use App\Policies\VacancyPolicy;
use App\Vacancy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
//        'App\Model' => 'App\Policies\ModelPolicy',
//        'App\Organization' => 'App\Policies\OrganizationPolicy',
        User::class => UserPolicy::class,
        Organization::class => OrganizationPolicy::class,
        Vacancy::class => VacancyPolicy::class,
        StatPolicy::class => StatPolicy::class
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
