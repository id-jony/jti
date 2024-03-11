<?php
namespace App\MoonShine\Fields;

use Illuminate\Database\Eloquent\Model;
use MoonShine\Fields\BelongsTo as FieldsBelongsTo;

class BelongsTo extends FieldsBelongsTo
{
    public function beforeSave(Model $item): void
    {
    }
}
