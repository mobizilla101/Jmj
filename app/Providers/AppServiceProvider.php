<?php

namespace App\Providers;

use App\Models\Settings;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadSetttings();
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        foreach (glob(app_path().'/Helpers/*.php') as $filename){
            require_once($filename);
        }

        Paginator::defaultView('vendor.pagination.tailwind');
    }

    public function loadSetttings(){
        if (!Schema::hasTable('settings')) {
            return;
        }
        $settings = Cache::remember('app_settings', now()->addMonths(3), function () {
            return Settings::get()->pluck('value', 'key')->toArray(); // Cache as an associative array
        });

        App::singleton('settings', function() use ($settings){
            return $settings;
        });

        // Share the settings globally in all views
        View::share('settings', $settings);
    }
}
