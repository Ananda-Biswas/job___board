<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

// ADD THESE:
use App\Models\Employer;
use App\Policies\EmployerPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Employer::class => EmployerPolicy::class,
    ];

    public function boot(): void
    {
        //
    }
}