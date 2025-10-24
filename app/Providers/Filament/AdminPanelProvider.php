<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Actions\Action;
use Filament\Pages\Dashboard;
use App\Settings\GeneralSetting;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use App\Filament\Pages\PengaturanPage;
use Illuminate\Support\Facades\Schema;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\Facades\Storage;
use Filament\Navigation\NavigationGroup;
use Filament\Widgets\FilamentInfoWidget;
use Filament\Http\Middleware\Authenticate;
use App\Filament\Widgets\DataOverviewWidget;
use Asmit\ResizedColumn\ResizedColumnPlugin;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Http\Middleware\AuthenticateSession;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {

        $logo = null;
        $siteName = 'Eko Taqwa';

        if (Schema::hasTable('settings')) {
            $settings = app(GeneralSetting::class);
            $logo = $settings->logo_path
                ? Storage::disk('public')->url($settings->logo_path)
                : null;
            $siteName = $settings->site_name ?? 'Eko Taqwa';
        }


        return $panel
            ->default()
            ->sidebarFullyCollapsibleOnDesktop()
            ->id('admin')
            ->path('')
            ->favicon($logo ?? null)
            ->login()
            ->darkMode(false)
            ->brandName($settings->site_name ?? 'Eko Taqwa')
            ->brandLogo(fn () => view('components.custom-logo', [
                'brandLogo' => $logo,
            ]))
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->colors([
                'primary' => Color::Green,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->plugin(
                 ResizedColumnPlugin::make()->preserveOnDB()
            )
            ->navigationGroups([
            NavigationGroup::make('Tema'),
            NavigationGroup::make('Eko CP'),
            NavigationGroup::make('Eko Media'),
            NavigationGroup::make('Eko Kaidah'),
            NavigationGroup::make('Eko Ayat Hadist'),
            NavigationGroup::make('Eko Refleksi'),
            NavigationGroup::make('User Management'),
            ])
            ->navigationItems([
            NavigationItem::make('API Docs')
                ->icon('heroicon-o-book-open')
                ->url(url('/api/documentation'))
                ->sort(9)
                ->openUrlInNewTab(),
            NavigationItem::make('Logout')
                ->url(url('/logout'))
                ->sort(10)
                ->icon('heroicon-o-arrow-right-on-rectangle')
                ->openUrlInNewTab(false)
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                DataOverviewWidget::class,
            ])
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
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
