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
     * Defines the gates for various actions and permissions.
     *
     * @return void
     */
    public function boot(): void
    {
        Gate::define('action-entity', fn($user, $entity) => class_basename($user) === class_basename($entity) && $user->id === $entity->id);

        /**
         * Check if Auth entity is Teacher
         */
        Gate::define('teacher', fn($user) => $user instanceof Teacher);


        Gate::define('abc', fn($user) => true);

        /**
         * Check if Auth entity is Teacher and have permission for update period
         */
        Gate::define('actions-period', fn($user, Period $period) => $user instanceof Teacher && $user->id === $period->teacher_id);

    }

}
