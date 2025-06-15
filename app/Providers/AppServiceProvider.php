<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\NotifikasiModel;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    // hahahah
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        if(env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }

        Blade::directive('getStatusColor', function ($status) {
            return "<?php 
                switch ($status) {
                    case 'selesai': echo 'success'; break;
                    case 'proses': echo 'warning'; break;
                    case 'menunggu': echo 'danger'; break;
                    case 'ditolak': echo 'info'; break;
                    default: echo 'secondary';
                }
            ?>";
        });

        Blade::directive('getStatusIcon', function ($status) {
            return "<?php 
                switch ($status) {
                    case 'selesai': echo 'check-circle'; break;
                    case 'proses': echo 'time'; break;
                    case 'menunggu': echo 'error'; break;
                    case 'ditolak': echo 'x-circle'; break;
                    default: echo 'help-circle';
                }
            ?>";
        });

        View::composer('*', function ($view) {
            if (Auth::check()) {
                $userId = Auth::id();
                $notifikasiList = NotifikasiModel::where('user_id', $userId)->latest()->take(5)->get();
                $unreadCount = NotifikasiModel::where('user_id', $userId)->where('is_read', false)->count();
    
                $view->with('notifikasiList', $notifikasiList)->with('unreadCount', $unreadCount);
            }
        });
    }
}
