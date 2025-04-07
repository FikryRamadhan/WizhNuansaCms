<?php

namespace App\Providers\Filament;

use App\Filament\Pages\ChangePassword;
use App\Filament\Pages\EditProfile;
use App\Filament\Widgets\DashboardStats as WidgetsDashboardStats;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\EnsureUserIsAdmin;
use DashboardStats;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Spatie\Permission\Middleware\RoleMiddleware;
use TotalStat;

class AdminPanelProvider extends PanelProvider
{


    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->profile()
            ->passwordReset()
            ->colors([
                'primary' => Color::Teal,
            ])

            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                \App\Filament\Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                WidgetsDashboardStats::class
            ])
            ->userMenuItems([
                MenuItem::make()
                    ->label('Ubah Password')
                    ->url(fn (): string => ChangePassword::getUrl())
                    ->icon('heroicon-o-cog-6-tooth'),
                // ...
            ])
            ->brandName('Wizh Nuansa App')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                // RoleMiddleware::using('admin'),
            ])
            ->authMiddleware([
                // RoleMiddleware::using('admin'),
                Authenticate::class,
            ])
            // ->databaseNotifications()
            // ->databaseNotificationsPolling('30s')
            ->collapsibleNavigationGroups(true);
    }
}
