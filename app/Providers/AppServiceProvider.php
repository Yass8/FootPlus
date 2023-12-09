<?php

namespace App\Providers;

use App\Http\ViewComposer\ChampionnatComposer;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

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
    public function boot()
    {
        Paginator::useBootstrap();

        // view()->composer('dashboard',function ($view){
        //     // $view->with('count', $this->users->count());
        //     // $view->with('champs', Auth::user()->championnats->get());
        //     $view->with('user', User::find(1));

        // });
    }
}
