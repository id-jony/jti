<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use MoonShine\Traits\Models\HasMoonShineChangeLog;

class Referal extends Model
{
    use HasFactory, HasMoonShineChangeLog;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'ref_id'
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'ref_id');
    }
}
