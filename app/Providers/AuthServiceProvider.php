<?php

namespace App\Providers;

use App\Models\Period;
use App\Models\Teacher;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
     * Boot method is used to define access control rules using Laravel Gate.
     */
    public function boot(): void
    {

        /**
         * Checks if the authenticated user and specified entity have the same class name and the same id.
         */
        Gate::define('action-entity', fn($user, $entity) => class_basename($user) === class_basename($entity) && $user->id === $entity->id);

        /**
         * Check if Auth entity is Teacher
         */
        Gate::define('teacher', fn($user) => $user instanceof Teacher);

        /**
         * Check if Auth entity is Teacher and have permission for update period
         */
        Gate::define('actions-period', fn($user, Period $period) => $user instanceof Teacher && $user->id === $period->teacher_id);

    }

}
