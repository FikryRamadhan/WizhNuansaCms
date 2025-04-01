<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CoffeResource\Pages;
use App\Filament\Resources\CoffeResource\RelationManagers;
use App\Models\Coffe;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CoffeResource extends Resource
{
    protected static ?string $model = Coffe::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationLabel = "Coffe Shop";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCoffes::route('/'),
            'create' => Pages\CreateCoffe::route('/create'),
            'view' => Pages\ViewCoffe::route('/{record}'),
            'edit' => Pages\EditCoffe::route('/{record}/edit'),
        ];
    }
}
