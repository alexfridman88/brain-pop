<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
 *
 * @mixin Builder
 * @method static Builder|Student filterByTeacher(int|null $teacherId) Scope to filter by teacher
 * @method static Builder|Student filterByPeriod(int|null $periodId) Scope to filter by period
 *
 *
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


    public function scopeFilterByTeacher(Builder $query, int|null $teacherId): Builder
    {
        return $query->when($teacherId, fn($students) => $students
            ->whereHas('periods', fn($periods) => $periods->where('teacher_id', $teacherId))
            ->with('periods'));
    }

    public function scopeFilterByPeriod(Builder $query, int|null $periodId): Builder
    {
        return $query->when($periodId, fn($students) => $students
            ->whereHas('periods', fn($periods) => $periods->where('id', $periodId)));
    }

}
