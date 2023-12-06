<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int id
 * @property string username
 * @property string full_name
 * @property int grade
 * @property string password
 */
class Student extends Authenticatable
{
    protected $fillable = ['username', 'full_name', 'grade', 'password'];

    use HasApiTokens, HasFactory, Notifiable;

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function periods(): BelongsToMany
    {
        return $this->belongsToMany(Period::class);
    }

}
