<?php

namespace Dlogon\QuickCrudForLaravel\Components;

use Dlogon\QuickCrudForLaravel\QuickCrudForLaravel;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;
use Illuminate\View\View;
use Illuminate\Support\Str;
class Navigation extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $allRoutes = Route::getroutes();
        $routesByName = \array_keys($allRoutes->getRoutesByName());
        $indexRoutes = \array_filter($routesByName, fn($route) => \str_contains($route, "index"));
        return view("quick-crud-for-laravel::layouts.navigation",
        [
            "indexRoutes" => $indexRoutes
        ]
    );
    }
}
