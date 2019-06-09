<?php

namespace App\Providers;

use App\Countries;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Lang;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
		Paginator::defaultView('vendor.pagination.bootstrap-4');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {        
        // App variables
        $appName = env('APP_NAME', Lang::get('app.appname'));
        $lrvLocale = \App::getLocale();
        $dtbLocale = Countries::where('cca2', 'like', $lrvLocale)->first();
        $locale = strtolower($dtbLocale->cca3);
        view::share('appName', $appName);
        view::share('currentLocale', $locale);
        
        Blade::directive('datetime', function ($expression) {
            return "<?php echo ($expression)->format('d/m/Y H:i'); ?>";
        });
        Blade::directive('ucfirst', function ($expression) {
            return "<?php echo ucfirst($expression); ?>";
        });
        Blade::directive('lowercase', function ($expression) {
            return "<?php echo strtolower($expression); ?>";
        });
        Blade::directive('uppercase', function ($expression) {
            return "<?php echo strtoupper($expression); ?>";
        });
        Blade::directive('slug', function ($expression) {
            return "<?php echo str_replace('-', '', $expression); ?>";
        });
    }
}
