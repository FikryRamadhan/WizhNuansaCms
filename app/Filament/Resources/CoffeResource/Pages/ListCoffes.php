<?php

namespace App\Filament\Resources\CoffeResource\Pages;

use App\Filament\Resources\CoffeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCoffes extends ListRecords
{
    protected static string $resource = CoffeResource::class;

    protected static ?string $breadcrumb = "Data Coffe & Resto";

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
