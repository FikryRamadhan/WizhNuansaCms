<?php

namespace App\Filament\Resources\CoffeResource\Pages;

use App\Filament\Resources\CoffeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCoffe extends EditRecord
{
    protected static string $resource = CoffeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
