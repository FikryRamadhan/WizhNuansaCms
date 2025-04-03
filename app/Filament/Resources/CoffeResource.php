<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CoffeResource\Pages;
use App\Models\Coffe;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter as FiltersFilter;
use Filament\Tables\Table;


class CoffeResource extends Resource
{
    protected static ?string $model = Coffe::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = "Menu";

    protected static ?string $navigationLabel = "Coffe & Resto";

    protected static ?string $breadcrumb = 'Data Coffe & Resto';

    protected static ?string $modelLabel = "Coffe & Restaurant";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make("Informasi Resto")
                    ->description("Detail Informasi Coffe & resto")
                    ->collapsible()
                    ->icon('heroicon-o-information-circle')
                    ->columns(2)
                    ->schema([
                        TextInput::make("name")
                            ->label("Nama Coffe/Resto")
                            ->placeholder("Masukan Nama Coffe Shop & Resto")
                            ->string()
                            ->required(),

                        Select::make('category')
                            ->label('Kategori')
                            ->placeholder("Pilih Kategori")
                            ->searchable()
                            ->options([
                                'Coffe Shop & Resto' => 'Coffe Shop & Resto',
                                'Coffe Shop' => 'Resto',
                                'Resto' => 'Resto'
                            ]),

                        Textarea::make('description')
                            ->label("Deskripsi")
                            ->rows(3)
                            ->columnSpan(2)
                            ->placeholder("Masukan Tentang coffe shop & resto disini")
                            ->maxLength(255),
                    ]),


                Section::make("Informasi Alamat")
                    ->description("Detail Infromasi Alamat Coffe & Resto")
                    ->collapsed()
                    ->icon('heroicon-o-information-circle')
                    ->columns(2)
                    ->schema([
                        Textarea::make('address')
                            ->label("Alamat")
                            ->rows(3)
                            ->columnSpan(2)
                            ->placeholder("Masukan Alamat coffe shop & resto disini")
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
                    ->description("Detail Infromasi Kontak Coffe & Resto")
                    ->collapsed()
                    ->icon('heroicon-o-information-circle')
                    ->columns(2)
                    ->schema([
                        TextInput::make('contact')
                            ->label("Kontak")
                            ->placeholder("Masukan No Hp Disini")
                            ->columnSpan(2)
                            ->rules([
                                'numeric',
                                'required'
                            ]),

                        TimePicker::make('opened')
                            ->label("Jam Buka")
                            ->seconds(false)
                            ->required(false),

                        TimePicker::make('closed')
                            ->label("Jam Tutup")
                            ->seconds(false)
                            ->required(false),

                        TextArea::make('menus')
                            ->label("Menu")
                            ->columnSpan(2)
                            ->rules('required')
                            ->helperText('Pisahkan setiap menu dengan koma (,)')
                            ->afterStateHydrated(function ($state, callable $set) {
                                // Ubah string dari database menjadi array
                                $set('menus', is_string($state) ? explode(',', $state) : $state);
                            })
                            ->dehydrateStateUsing(function ($state) {
                                // Ubah array menjadi string sebelum disimpan
                                return is_array($state) ? implode(',', $state) : $state;
                            }),

                        FileUpload::make("image")
                            ->label("Gambar")
                            ->columnSpan(2)
                            ->downloadable()
                            ->multiple()
                            ->image()
                            ->maxFiles(5)
                            ->reorderable()
                            ->label('Upload Gambar')
                            ->directory('coffes')
                            ->dehydrateStateUsing(function ($state, $get) {
                                $name = $get('name'); // Ambil nilai input dari TextInput "name"

                                if (is_array($state)) {
                                    // Proses jika multiple file di-upload
                                    return array_map(function ($index, $file) use ($name) {
                                        // Pastikan $file adalah instance dari UploadedFile
                                        if ($file instanceof \Illuminate\Http\UploadedFile) {
                                            // Mengambil nama file asli
                                            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                                            // Mengganti spasi dengan tanda hubung
                                            $formattedName = str_replace(' ', '-', $name);
                                            // Menambahkan nomor urut jika lebih dari satu file
                                            return $formattedName . '-' . ($index + 1) . '.' . $file->getClientOriginalExtension();
                                        }
                                        return $file; // Jika bukan instance dari UploadedFile, kembalikan nama file asal
                                    }, array_keys($state), $state);
                                }

                                // Jika hanya satu file yang diunggah
                                if ($state instanceof \Illuminate\Http\UploadedFile) {
                                    return str_replace(' ', '-', $name) . '.' . $state->getClientOriginalExtension();
                                }

                                return $state; // Jika tidak ada file, kembalikan state apa adanya
                            }),

                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("name")
                    ->label("Nama")
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

                TextColumn::make("category")
                    ->label("Kategori")
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('category')
                    ->label('Kategori')
                    ->options([
                        'coffee_shop_resto' => 'Coffee Shop & Resto',
                        'coffee_shop' => 'Coffee Shop',
                        'resto' => 'Resto',
                    ])
                    ->attribute('category'),

                FiltersFilter::make('opened')
                    ->label('Jam Buka')
                    ->form([
                        TimePicker::make('from')->label('Dari Jam'),
                        TimePicker::make('to')->label('Sampai Jam'),
                    ])
                    ->query(function ($query, $data) {
                        // Cek apakah waktu 'from' dan 'to' dipilih
                        return $query->when($data['from'], fn($query) => $query->where('opened', '>=', $data['from']))
                            ->when($data['to'], fn($query) => $query->where('closed', '<=', $data['to']));
                    }),
            ])
            ->actions([
                ActionGroup::make([
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
            'index' => Pages\ListCoffes::route('/'),
            'create' => Pages\CreateCoffe::route('/create'),
            'view' => Pages\ViewCoffe::route('/{record}'),
            'edit' => Pages\EditCoffe::route('/{record}/edit'),
        ];
    }
}
