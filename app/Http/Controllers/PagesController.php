<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;

/**
 * Data from static template / component like sidebar/navbar item already served.
 * Data served using Laravel View Composer
 * @link App\Providers\AppServiceProfider
 */

class PagesController extends Controller
{
    /**
     * Handle to home page request with latest product data
     * @return view
     */
    
    function index() {
        $latest_product = Product::orderBy('id', 'desc')
                                    ->limit(6)
                                    ->get();
        
        return view('plantshop.index')->with('latest_product', $latest_product);
    }

    /**
     * Handle to product by category page request with product data
     * @return view
     */
    
    function productByCategory($category_name) {
        $categories = Category::where('cat_slug', $category_name)->first();

        return view('plantshop.category')->with('categories', $categories);
    }

    /**
     * Handle to product detail page request with product data
     * @return view
     */
    
    function productDetail($product_name) {
        $time_now = date('Y-m-d');

        $resultProduct = Product::where('slug', $product_name)->first();

        // Update Counter / Most View
        if ($resultProduct->date_view != $time_now) {
            $resultProduct->counter = 0;
        }

        $counter = $resultProduct->counter;
        $resultProduct->counter = $counter + 1 ;
        $resultProduct->date_view = $time_now;
        $resultProduct->save();

        return view('plantshop.product')->with('detail_product', $resultProduct);
    }

    /**
     * Handle to search product page request with product data
     * @return view
     */
    
    function searchProduct(Request $request){
        $keyword = $request->keyword;
        $products = Product::where('name', 'like', '%' . $keyword . '%')
                                ->get()
                                ->map(function ($row) use ($keyword) {
                                    $row->name = preg_filter('/' . preg_quote($keyword, '/') . '/i', '<b>$0</b>', $row->name);
                                    return $row;
                                });;

        return view('plantshop.search')->with('products', $products)
                                    ->with('keyword', $keyword);
    }

    /**
     * Handle to cart page request
     * @return view
     */
    
    function cartPage() {
        return view('plantshop.cart');
    }
}
