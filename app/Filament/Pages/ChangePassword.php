<?php

namespace App\Filament\Pages;

use Dotenv\Exception\ValidationException;
use Exception;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Form;
use Filament\Livewire\Notifications;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException as ValidationValidationException;

class ChangePassword extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $navigationLabel = "Ubah Password";

    protected static ?int $navigationSort = 999;

    protected ?string $heading = 'Ubah Password';

    protected static string $view = 'filament.pages.change-password';

    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    public function form(Form $form): Form
    {
        return $form
            ->columns(2)
            ->schema([
                Card::make()
                    ->columnSpan(1)
                    ->schema([
                        Forms\Components\TextInput::make('current_password')
                            ->label('Password Saat Ini')
                            ->password()
                            ->required()
                            ->dehydrateStateUsing(fn($state) => Hash::check($state, auth()->user->password) ? $state : null)
                            ->afterStateUpdated(function ($state, callable $set) {
                                if (!$state) {
                                    $set('current_password', '');
                                    throw ValidationValidationException::withMessages([
                                        'current_password' => 'Password saat ini tidak cocok.',
                                    ]);
                                }
                            }), // Validasi password lama

                        Forms\Components\TextInput::make('new_password')
                            ->label('Password Baru')
                            ->password()
                            ->required()
                            ->minLength(8)
                            ->confirmed(),

                        Forms\Components\TextInput::make('new_password_confirmation')
                            ->label('Konfirmasi Password Baru')
                            ->password()
                            ->required(),
                    ])
            ])
            ->statePath('data'); // Menyimpan data form
    }

    // public function save()
    // {
    //     try {
    //         $user = Auth::user();

    //         // Validasi data input
    //         $validatedData = $this->validate([
    //             'current_password' => 'required|current_password',
    //             'new_password' => 'required|min:8|confirmed',
    //         ]);

    //         // Update password
    //         $user->update([
    //             'password' => Hash::make($validatedData['new_password']),
    //         ]);

    //         // Notifikasi sukses
    //         Notification::make()
    //             ->title('Password berhasil diubah!')
    //             ->success()
    //             ->send();
    //     } catch (Exception $e) {
    //         Notification::make()
    //             ->title('Error Ada Kesalahan')
    //             ->warning()
    //             ->send();
    //     }
    // }
}
