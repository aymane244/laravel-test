<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
use App\notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(){
        Schema::defaultStringLength(191);
         view()->composer('*', function ($view){
            if (Auth::check()) {
                if(Auth::user()->isAdmin==false){
                    $notifications = notification::where('to', Auth::id())->take(10)->orderBy('is_read', 'asc')->orderBy('date', 'desc')->get();
                    $count_unread_notifications = notification::where('to', Auth::id())->where('is_read',false)->count();
                    $view->with('notifications', $notifications)->with('count_unread_notifications',$count_unread_notifications);
                }
                else{

                }
            }
         });
        }
}
