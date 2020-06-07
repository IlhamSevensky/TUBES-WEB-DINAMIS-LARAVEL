<?php

namespace App\Http\ViewComposers;

use App\Category;
use App\Product;
use Illuminate\View\View;

class PlantShopViewComposer 
{
    function compose(View $view){
        
        $time_now = date('Y-m-d');
        $navbar_category = Category::limit(6)->get();
        $sidebar_most_viewed = Product::where('date_view', $time_now)
                                    ->orderBy('counter', 'desc')
                                    ->limit(5)
                                    ->get();
                                    
        $view->with('sidebar_most_viewed', $sidebar_most_viewed)
            ->with('navbar_category', $navbar_category);

    }
}
