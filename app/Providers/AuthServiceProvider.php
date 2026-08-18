<?php

namespace App\Providers;

use App\Models\Budget;
use App\Models\Entry;
use App\Models\Record;
use App\Policies\BudgetPolicy;
use App\Policies\EntryPolicy;
use App\Policies\RecordPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Entry::class => EntryPolicy::class,
        Budget::class => BudgetPolicy::class,
        Record::class => RecordPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
