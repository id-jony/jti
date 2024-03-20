<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

use MoonShine\Traits\Models\HasMoonShineChangeLog;

class Employee extends Model
{
    use HasFactory, HasMoonShineChangeLog;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'uuid',
        'email',
        'is_registered',
        'registered',
        'is_passed',
        'passed'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'registered' => 'datetime',
        'passed' => 'datetime',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function referal(): HasOne
    {
        return $this->hasOne(Referal::class, 'ref_id');
    }

}
