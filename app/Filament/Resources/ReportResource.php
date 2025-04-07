<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Resources\ReportResource\RelationManagers;
use App\Models\Report;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = "Menu";

    protected static ?string $modelLabel = "Data Berita";

    protected static ?string $navigationLabel = "Berita";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Umum')
                ->description('Masukkan informasi utama terkait laporan')
                ->icon('heroicon-o-information-circle')
                ->schema([
                    TextInput::make('title')
                        ->label('Judul')
                        ->nullable()
                        ->required()
                        ->placeholder('Contoh: Laporan Kegiatan Bakti Sosial'),

                    TextInput::make('source')
                        ->label('Sumber Informasi')
                        ->nullable()
                        ->placeholder('Contoh: Desa Kertawangunan'),
                ])
                ->columns(2),

            Section::make('Isi Laporan')
                ->description('Tulis detail laporan di sini')
                ->icon('heroicon-o-document-text')
                ->schema([
                    RichEditor::make('report')
                        ->label('Isi Laporan')
                        ->nullable()
                        ->required()
                        ->placeholder('Tulis isi laporan secara lengkap dan rinci di sini...'),
                ]),

            Section::make('Detail Tambahan')
                ->description('Tambahkan informasi pelengkap seperti tanggal dan gambar')
                ->icon('heroicon-o-calendar-days')
                ->schema([
                    DateTimePicker::make('date')
                        ->label('Tanggal Laporan')
                        ->nullable()
                        ->placeholder('Pilih tanggal laporan'),

                    FileUpload::make("image")
                        ->label("Upload Gambar")
                        ->columnSpan(3)
                        ->downloadable()
                        ->multiple()
                        ->acceptedFileTypes(['image/*'])
                        ->image()
                        ->maxFiles(5)
                        ->reorderable()
                        ->directory('reports')
                        ->placeholder('Unggah gambar pendukung (maks. 5 file)'),
                ])
                ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('source')
                    ->label('Sumber')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('date')
                    ->label('Tanggal')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\ImageColumn::make('image')
                    ->label('Gambar')
                    ->circular()
                    ->height(60)
                    ->width(60),
            ])
            ->filters([
                Tables\Filters\Filter::make('source')
                    ->query(fn($query) => $query->whereNotNull('source'))
                    ->label('Hanya yang punya sumber'),

                Tables\Filters\TernaryFilter::make('image')
                    ->label('Ada Gambar')
                    ->column('image'),
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
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}
