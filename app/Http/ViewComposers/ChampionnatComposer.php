<?php

namespace App\Http\ViewComposer;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ChampionnatComposer
{
    public function compose(View $view)
    {
        // $view->with('champs',Auth::user()->championnats()->get());
    }
}