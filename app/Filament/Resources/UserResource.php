<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = "Menu";
    protected static ?string $modelLabel = "Data Pengguna";
    protected static ?string $navigationLabel = "Pengguna";


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Diri')
                    ->description('Silahkan isi data diri anda')
                    ->icon('heroicon-o-user')
                    ->collapsible()
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label('Nama Lengkap')
                            ->placeholder('Masukkan nama lengkap anda')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->required()
                            ->email()
                            ->label('Email')
                            ->placeholder('Masukkan email anda')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->required()
                            ->label('No. Telepon')
                            ->placeholder('Masukkan no. telepon anda')
                            ->maxLength(15),

                        Forms\Components\Textarea::make('address')
                            ->label('Alamat')
                            ->placeholder('Masukkan alamat anda')
                            ->maxLength(255)
                            ->rows(3)
                            ->columnSpan(3),
                    ]),

                Section::make('Infromasi Akun')
                    ->description('Silahkan isi data akun anda')
                    ->columns(3)
                    ->icon('heroicon-o-user-circle')
                    ->collapsed()
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->required()
                            ->password()
                            ->label('Password')
                            ->placeholder('Masukkan password anda')
                            ->maxLength(255)
                            ->dehydrated(fn($state) => ! blank($state))
                            ->visibleOn('create'),
                        Forms\Components\TextInput::make('password_confirmation')
                            ->required()
                            ->password()
                            ->same('password')
                            ->placeholder('Masukkan konfirmasi password anda')
                            ->label('Konfirmasi Password')
                            ->maxLength(255)
                            ->dehydrated(fn($state) => ! blank($state))
                            ->visibleOn('create'),

                        Forms\Components\Select::make('roles')
                            ->relationship('roles', 'name')
                            ->preload()
                            ->options(
                                Role::all()->pluck('name', 'id')->mapWithKeys(function ($name, $id) {
                                    return [$id => \Illuminate\Support\Str::title($name)];
                                })
                            )
                            ->label('Roles'),
                    ]),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('No. Telepon')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Roles')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([

            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                ])
                ->icon('heroicon-o-cog-6-tooth')
                ->label('Aksi')
                ->color('primary')
                ->tooltip('Aksi')
            ])
            ->bulkActions([
                Tables\Actions\ActionGroup::make([
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
