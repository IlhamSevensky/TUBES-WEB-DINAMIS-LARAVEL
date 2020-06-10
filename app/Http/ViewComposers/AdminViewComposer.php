<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class AdminViewComposer 
{
    function compose(View $view){
        
        // Indonesian Time Zone
        $timezone = time() + (60 * 60 * 7);
        $year_now = gmdate('Y', $timezone);

        $view->with('year', $year_now);

    }
}
