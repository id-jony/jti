<?php

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Department;

use MoonShine\Resources\Resource;
use MoonShine\Fields\ID;
use MoonShine\Actions\FiltersAction;
use MoonShine\Fields\BelongsToMany;
use MoonShine\Fields\HasMany;
use MoonShine\Fields\Text;

class DepartmentResource extends Resource
{
	public static string $model = Department::class;

    public static string $orderType = 'ASC';

    public string $titleField = 'name';

    public function title(): string
    {
        return trans('moonshine::ui.resource.deparments');
    }

	public function fields(): array
	{
		return [
            ID::make()->sortable(),
            Text::make(trans('moonshine::ui.resource.deparment_name'), 'name')
                ->required()
                ->showOnExport(),
            HasMany::make('Сотрудники','employees', new EmployeeResource())
                ->hideOnIndex()
                ->hideOnDetail()
                ->fullPage()
                ->resourceMode()
        ];
	}

	public function rules(Model $item): array
	{
        return [
            'name' => ['required', 'string', 'min:1', 'max:255'],
        ];
    }

    public function search(): array
    {
        return [
            'id',
            'name'
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
        ];
    }
}
