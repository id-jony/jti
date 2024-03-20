<?php

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
use MoonShine\Actions\ExportAction;
use MoonShine\Resources\Resource;
use MoonShine\Fields\ID;
use MoonShine\Actions\FiltersAction;
use MoonShine\Actions\ImportAction;
use MoonShine\Fields\BelongsTo;
use MoonShine\Fields\HasMany;
use MoonShine\Fields\Email;
use MoonShine\Fields\NoInput;
use MoonShine\Fields\SwitchBoolean;
use MoonShine\Fields\Text;
use MoonShine\Filters\BelongsToFilter;
use MoonShine\Filters\SelectFilter;
use MoonShine\FormComponents\ChangeLogFormComponent;

class EmployeeResource extends Resource
{
	public static string $model = Employee::class;

	public static string $orderType = 'ASC';
    public string $titleField = 'name'; 

    public static array $activeActions = ['show', 'edit'];

    public static array $with = [
        'department',
    ];

    public function title(): string
    {
        return trans('moonshine::ui.resource.employees');
    }

    public function getActiveActions(): array
    {
        if (auth()->user()->moonshine_user_role_id === 1) {
            return array_merge(static::$activeActions, ['delete', 'create']);
        }
        return static::$activeActions;
    }

	public function fields(): array
	{
		return [
            ID::make()
            ->sortable(),

            Text::make(trans('moonshine::ui.resource.employee_name'), 'name')
                ->required()
                ->useOnImport()
                ->showOnExport(),

          
            

                HasMany::make(trans('moonshine::ui.resource.ref'), 'referal', new ReferalResource())

            ->fields([
                ID::make(),
                Text::make('name')->required(),
                Text::make('phone')->required(),
                Text::make('email')->required(),

            ])
            ->resourceMode()
            ->hideOnIndex()
            ->hideOnDetail(),


            // Email::make(trans('moonshine::ui.resource.email'),'email')
            //     ->nullable(true)
            //     ->useOnImport()
            //     ->showOnExport(),

            // SwitchBoolean::make(trans('moonshine::ui.resource.is_registered'), 'is_registered')
            //     ->hideOnForm()
            //     ->autoUpdate(false),

            // NoInput::make(trans('moonshine::ui.resource.is_registered'), 'is_registered', static fn($item) => $item->is_registered ? 'Да' : 'Нет')
            //     ->hideOnForm()
            //     ->hideOnDetail()
            //     ->hideOnIndex()
            //     ->showOnExport(),

            // NoInput::make(trans('moonshine::ui.resource.registered'), 'registered', static fn($item) => $item->registered?->diffForHumans())
            //     ->hideOnForm(),

            // NoInput::make(trans('moonshine::ui.resource.registered'), 'registered', static fn($item) => $item->registered)
            //     ->hideOnForm()
            //     ->hideOnDetail()
            //     ->hideOnIndex()
            //     ->showOnExport(),

            SwitchBoolean::make(trans('moonshine::ui.resource.is_passed'), 'is_passed')
                ->hideOnForm(),

            NoInput::make(trans('moonshine::ui.resource.is_passed'), 'is_passed', static fn($item) => $item->is_passed ? 'Да' : 'Нет')
                ->hideOnForm()
                ->hideOnDetail()
                ->hideOnIndex()
                ->showOnExport(),

            NoInput::make(trans('moonshine::ui.resource.passed'), 'passed', static fn($item) => $item->passed?->diffForHumans())
                ->hideOnForm(),

            NoInput::make(trans('moonshine::ui.resource.passed'), 'passed', static fn($item) => $item->passed)
                ->hideOnForm()
                ->hideOnDetail()
                ->hideOnIndex()
                ->showOnExport(),
        ];
	}

	public function rules(Model $item): array
	{
        return [
            'name' => ['required', 'string', 'min:1', 'max:255'],
            'email' => ['nullable', 'sometimes', 'bail', 'email', 'unique:employees,email' . ($item->exists ? ",$item->id" : '')],
        ];
    }

    public function search(): array
    {
        return [
            'id',
            'name',
            'department.name'
        ];
    }

    public function filters(): array
    {
        return [
            BelongsToFilter::make(trans('moonshine::ui.resource.department'), 'department', new DepartmentResource())
                ->nullable()
                ->searchable(),

            SelectFilter::make(trans('moonshine::ui.resource.all_passed'), 'is_passed')
                ->options([
                    '1' => trans('moonshine::ui.yes'),
                    '0' => trans('moonshine::ui.no')
                ])
                ->nullable(),

            // SelectFilter::make(trans('moonshine::ui.resource.all_registered'), 'is_registered')
            //     ->options([
            //         '1' => trans('moonshine::ui.yes'),
            //         '0' => trans('moonshine::ui.no')
            //     ])
            //     ->nullable()
        ];
    }

    public function actions(): array
    {
        return [
            FiltersAction::make(trans('moonshine::ui.filters')),
            ExportAction::make('Экспорт'),
            // ImportAction::make('Импорт')
        ];
    }

    public function components(): array
    {
        return [
            ChangeLogFormComponent::make('История действий'),
        ];
    }
}
