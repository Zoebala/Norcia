<?php

namespace App\Filament\Widgets;

use App\Models\Departement;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatAdminOverview extends BaseWidget
{

    protected static bool $isLazy = false;
    protected function getStats(): array
    {
        return [
            //
            Stat::make("Departements", Departement::where("annee_id",session("Annee_id")??1)->count())
            ->description("Nos Départements")
            ->color("success")
            ->chart([34,2,5,23])
            ->Icon("heroicon-o-home-modern"),
        ];
    }
}
