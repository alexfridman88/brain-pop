<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $name
 * @property int $teacher_id
 * @property-read Teacher $teacher
 * @property-read Student[]|Collection $students
 *
 * @method static Builder|Student filterByTeacher(int|null $teacherId) Scope to filter by teacher
 *
 */
class Period extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class);
    }

    /**
     * Filters the query by a specific teacher.
     *
     * @param Builder $query The query builder instance.
     * @param int|null $teacherId The ID of the teacher to filter by. If null, no filtering will be applied.
     * @return Builder The modified query builder instance.
     */
    public function scopeFilterByTeacher(Builder $query, int|null $teacherId): Builder
    {
        return $query->when($teacherId, fn($periods) => $periods
            ->where('teacher_id', $teacherId));
    }
}
