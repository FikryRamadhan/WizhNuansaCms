<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TourResource\Pages;
use App\Filament\Resources\TourResource\RelationManagers;
use App\Models\Tour;
use Filament\Actions\ActionGroup;
use Filament\Forms;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup as ActionsActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use NumberFormatter;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;

class TourResource extends Resource
{
    protected static ?string $model = Tour::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = "Menu";

    protected static ?string $modelLabel = "Wisata";

    protected static ?string $navigationLabel = "Objek Wisata";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make("Informasi Data Wisata")
                    ->description("Isi Dasar Data Objek Wisata")
                    ->collapsible()
                    ->icon('heroicon-o-information-circle')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label("Nama Objek Wisata")
                            ->placeholder("Masukan Nama Objek Wisata")
                            ->rules(['required', 'string']),

                        TextInput::make("contact")
                            ->label('Kontak Informasi')
                            ->placeholder("Masukan Kontak Informasi")
                            ->rules(['string', 'required']),

                        Textarea::make('description')
                            ->columnSpan(2)
                            ->label("Deskripsi")
                            ->placeholder("Masukan Descripsi Wisata")
                            ->rules(['required', 'max:255']),
                    ]),

                Section::make("Informasi Alamat Wisata")
                    ->description("Isi Data Alamat Objek Wisata")
                    ->collapsed()
                    ->columns(2)
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        Textarea::make('address')
                            ->label("Alamat")
                            ->rows(3)
                            ->columnSpan(2)
                            ->placeholder("Masukan Alamat Wisata disini")
                            ->maxLength(255),

                        TextInput::make('longtitude')
                            ->label("Longtitude")
                            ->integer()
                            ->columnSpan(1)
                            ->placeholder("Cari Lingtitude di gogle maps")
                            ->required(false),

                        TextInput::make('latitude')
                            ->label("Latitude")
                            ->columnSpan(1)
                            ->placeholder("Cari Latitude di gogle maps")
                            ->integer()
                            ->required(false),
                    ]),

                Section::make("Informasi Tambahan")
                    ->description("Isi Informasi Tambahan Mengenai Objek Wisata")
                    ->collapsed()
                    ->icon('heroicon-o-information-circle')
                    ->columns(3)
                    ->schema([
                        TimePicker::make('opened')
                            ->label("Jam Buka")
                            ->seconds(false)
                            ->required(false),

                        TimePicker::make('closed')
                            ->label("Jam Tutup")
                            ->seconds(false)
                            ->required(false),

                        MoneyInput::make('price')
                            ->label('Harga')
                            ->currency('IDR')
                            ->locale('id_ID')
                            ->minValue(100)
                            ->formatStateUsing(function ($state) {
                                return NumberFormatter::create('id_ID', NumberFormatter::CURRENCY)
                                    ->format((float) $state * 1000);
                            })
                            ->mutateDehydratedStateUsing(function ($state) {
                                return (float) $state / 100000;
                            }),

                        FileUpload::make("image")
                            ->label("Gambar")
                            ->columnSpan(3)
                            ->downloadable()
                            ->multiple()
                            ->acceptedFileTypes(['image/*'])
                            ->image()
                            ->maxFiles(5)
                            ->reorderable()
                            ->label('Upload Gambar')
                            ->directory('tours'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("name")
                    ->label('Nama Wisata'),

                TextColumn::make("price")
                    ->label("Harga")
                    ->formatStateUsing(function ($state) {
                        return NumberFormatter::create('id_ID', NumberFormatter::CURRENCY)->format($state * 1000);
                    })
                    ->sortable()
                    ->sortable()
                    ->searchable(),

                TextColumn::make("description")
                    ->label("Deskripsi")
                    ->limit(20)
                    ->sortable(false)
                    ->searchable(false),

                TextColumn::make("address")
                    ->label("Alamat")
                    ->limit(10),
            ])
            ->filters([
                // Filter Rentang Harga
                Tables\Filters\Filter::make('price')
                    ->label('Rentang Harga')
                    ->query(
                        fn(Builder $query, array $data) =>
                        $query->when($data['min'] ?? null, fn($q, $min) => $q->where('price', '>=', $min))
                            ->when($data['max'] ?? null, fn($q, $max) => $q->where('price', '<=', $max))
                    )
                    ->form([
                        Forms\Components\TextInput::make('min')
                            ->numeric()
                            ->label('Harga Minimal')
                            ->placeholder('Rp 0'),
                        Forms\Components\TextInput::make('max')
                            ->numeric()
                            ->label('Harga Maksimal')
                            ->placeholder('Rp 1.000.000')
                    ]),

                // Filter Berdasarkan Waktu Buka & Tutup
                Tables\Filters\Filter::make('opened')
                    ->label('Jam Buka')
                    ->query(
                        fn(Builder $query, array $data) =>
                        $query->when(
                            $data['opened'] ?? null,
                            fn($q, $opened) =>
                            $q->where('opened', '>=', $opened)
                        )
                    )
                    ->form([
                        Forms\Components\TimePicker::make('opened')
                            ->label('Jam Buka')
                    ]),

                Tables\Filters\Filter::make('closed')
                    ->label('Jam Tutup')
                    ->query(
                        fn(Builder $query, array $data) =>
                        $query->when(
                            $data['closed'] ?? null,
                            fn($q, $closed) =>
                            $q->where('closed', '<=', $closed)
                        )
                    )
                    ->form([
                        Forms\Components\TimePicker::make('closed')
                            ->label('Jam Tutup')
                    ]),

                // Filter Berdasarkan Lokasi (Bisa untuk cari di daerah tertentu)
                Tables\Filters\Filter::make('address')
                    ->label('Lokasi')
                    ->query(
                        fn(Builder $query, array $data) =>
                        $query->when(
                            $data['address'] ?? null,
                            fn($q, $address) =>
                            $q->where('address', 'like', "%{$address}%")
                        )
                    )
                    ->form([
                        Forms\Components\TextInput::make('address')
                            ->label('Cari Lokasi')
                            ->placeholder('Masukkan alamat/kecamatan')
                    ]),
            ])
            ->actions([
                ActionsActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                ])
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
            'index' => Pages\ListTours::route('/'),
            'create' => Pages\CreateTour::route('/create'),
            'view' => Pages\ViewTour::route('/{record}'),
            'edit' => Pages\EditTour::route('/{record}/edit'),
        ];
    }
}
