<?php

namespace App\Filament\Resources\CoffeResource\Pages;

use App\Filament\Resources\CoffeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCoffe extends ViewRecord
{
    protected static string $resource = CoffeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
