<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TourResource\Pages;
use App\Filament\Resources\TourResource\RelationManagers;
use App\Models\Tour;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
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

                        TextInput::make('price')
                            ->label('Harga')
                            ->required()
                            // ->currency('IDR')
                            // ->locale('id_ID')
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
                            ->image()
                            ->maxFiles(5)
                            ->reorderable()
                            ->label('Upload Gambar')
                            ->directory('tours')
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
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("name")
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
            'index' => Pages\ListTours::route('/'),
            'create' => Pages\CreateTour::route('/create'),
            'view' => Pages\ViewTour::route('/{record}'),
            'edit' => Pages\EditTour::route('/{record}/edit'),
        ];
    }
}
