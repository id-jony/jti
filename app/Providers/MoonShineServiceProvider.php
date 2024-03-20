<?php

namespace App\Providers;

use App\MoonShine\Resources\DepartmentResource;
use App\MoonShine\Resources\EmployeeResource;
use App\MoonShine\Resources\ReferalResource;

use App\MoonShine\Resources\UserRoleResource;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use MoonShine\MoonShine;
use MoonShine\Menu\MenuGroup;
use MoonShine\Menu\MenuItem;
use MoonShine\Resources\MoonShineUserResource;

class MoonShineServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        app(MoonShine::class)->menu([
            MenuItem::make('moonshine::ui.resource.employees', new EmployeeResource())
                ->translatable()
                ->icon('heroicons.identification'),
            MenuItem::make('moonshine::ui.resource.refs', new ReferalResource())
                ->translatable()
                ->icon('heroicons.identification'),
            MenuItem::make('moonshine::ui.resource.deparments', new DepartmentResource())
                ->translatable()
                ->icon('heroicons.bars-3')
                ->canSee(function(Request $request) {
                    return $request->user('moonshine')?->moonshine_user_role_id === 1;
                }),
            MenuItem::make('moonshine::ui.resource.admins_title', new MoonShineUserResource())
                ->translatable()
                ->icon('users')
                ->canSee(function(Request $request) {
                    return $request->user('moonshine')?->moonshine_user_role_id === 1;
                }),
            MenuItem::make('moonshine::ui.resource.role_title', new UserRoleResource())
                ->translatable()
                ->icon('bookmark')
                ->canSee(function(Request $request) {
                    return $request->user('moonshine')?->moonshine_user_role_id === 1;
                }),
        ]);
    }
}
