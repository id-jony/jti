<?php

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Referal;
use MoonShine\Actions\ExportAction;

use MoonShine\Resources\Resource;
use MoonShine\Fields\ID;
use MoonShine\Actions\FiltersAction;
use MoonShine\Fields\BelongsTo;
use MoonShine\Fields\BelongsToMany;

use MoonShine\Fields\HasMany;
use MoonShine\Fields\Text;
use MoonShine\Fields\Email;
use MoonShine\Fields\Phone;

class ReferalResource extends Resource
{
	public static string $model = Referal::class;

    public static string $orderType = 'ASC';

    public string $titleField = 'name';
    
    public static array $activeActions = ['create', 'show', 'edit', 'delete']; 

    public function title(): string
    {
        return trans('moonshine::ui.resource.ref');
    }



	public function fields(): array
	{
		return [
            // ID::make()->sortable(),
            Text::make('ФИО', 'name')
                ->required()
                ->showOnExport(),
            Phone::make('Телефон', 'phone')
                ->required()
                ->showOnExport(),

            Email::make('Email', 'email')
                ->required()
                ->showOnExport(),
                
            BelongsTo::make('Пригласил', 'employee', new EmployeeResource())
                ->required()
                ->hidden()
                ->hideOnIndex()
  
        ];
	}

	public function rules(Model $item): array
	{
        return [
            'name' => ['required', 'string', 'min:1', 'max:255'],
            'phone' => ['required', 'string', 'min:1', 'max:255'],
            'email' => ['required', 'string', 'min:1', 'max:255'],

        ];
    }

    public function search(): array
    {
        return [
      
        ];
    }

    public function filters(): array
    {
        return [];
    }

    public function actions(): array
    {
        return [
            FiltersAction::make(trans('moonshine::ui.filters')),
            ExportAction::make('Экспорт'),

        ];
    }
}
