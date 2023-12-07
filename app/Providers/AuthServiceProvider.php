<?php

namespace App\Providers;

use App\Models\Period;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('delete-entity', function ($user, Student|Teacher $entity) {
            return basename($user) === basename($entity) && $user->id === $entity->id;
        });

        Gate::define('update-entity', function ($user, Student|Teacher $entity) {
            return class_basename($user) === class_basename($entity) && $user->id === $entity->id;
        });

        Gate::define('store-period', function ($user) {
            return $user instanceof Teacher;
        });

        Gate::define('update-period', function ($user, Period $period) {
            return $this->updateOrDeletePeriod($user, $period);
        });

        Gate::define('delete-period', function ($user, Period $period) {
            return $this->updateOrDeletePeriod($user, $period);
        });
    }

    /**
     * @param $user
     * @param Period $period
     * @return bool
     */
    function updateOrDeletePeriod($user, Period $period): bool
    {
        return $user instanceof Teacher && $user->id === $period->teacher_id;
    }
}
