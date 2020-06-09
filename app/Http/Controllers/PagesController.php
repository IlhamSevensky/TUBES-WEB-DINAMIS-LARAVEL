<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Detail;
use App\Sale;
use App\User;
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

    /**
     * Admin Section
     */

     function adminPage() {
         // Indonesian Time Zone
        $timezone = time() + (60 * 60 * 7);
        $year_now = gmdate('Y', $timezone);

        return redirect('/admin/month/' . $year_now);
     }

     function dashboard($year) {
        // Indonesian Time Zone
        $timezone = time() + (60 * 60 * 7);
        $date_now = gmdate('Y-m-d', $timezone);
        
        if ($year < 2015) {
            $year = 2015;
        }

        if ($year > 2065) {
            $year = 2065;
        }

        // Total Sales
        $details = Detail::all();

        $total_sales = 0;
        foreach ($details as $detail ) {
            $subtotal = $detail->product->price * $detail->quantity;
            $total_sales += $subtotal;
        }

        // Total Sales Today
        $sales = Sale::where('sales_date', '=', $date_now)->get();
        
        $today_total_sales = 0;
        foreach ($sales as $sale ) {
            $details = $sale->details;

            foreach ($details as $detail ) {
                $subtotal_today = $detail->product->price * $detail->quantity;
                $today_total_sales += $subtotal_today;
            }   
        }

        // Number of products
        $number_of_product = Product::count();

        // Number of users
        $number_of_user = User::where('type', '=', 0)->count();

        // Monthly total sales report data and month data
        $monthly_total_sales = array();
        $month_name = array();

        for ($month = 1; $month  <= 12; $month++) { 
            $sales_per_month = Sale::whereMonth('sales_date', $month)
                                ->whereYear('sales_date', $year)
                                ->get();
            
            $month_name[] = date('M', mktime(0,0,0, $month, 1));
            $total_per_month = 0;            

            foreach ($sales_per_month as $sale_per_month ) {
                $details_per_month = $sale_per_month->details;

                $subtotal = 0;
                foreach ($details_per_month as $detail_per_month ) {
                    $subtotal = $detail_per_month->product->price * $detail_per_month->quantity;
                    $total_per_month += $subtotal;
                }
            }

            $monthly_total_sales[] = $total_per_month;
        }        
        
        // Year must be send to all view
        return view('admin.home')->with('year', $year)
                                ->with('total_sales', $total_sales)
                                ->with('number_of_product', $number_of_product)
                                ->with('number_of_user', $number_of_user)
                                ->with('today_total_sales', $today_total_sales)
                                ->with('month_name_data', $month_name)
                                ->with('monthly_total_sales', $monthly_total_sales);
     }

     function salesPage(){

        $transaction_data = array();

        $sales = Sale::orderBy('id', 'desc')->get();

        foreach ($sales as $sale) {
            $details = $sale->details;
            $total_sale = 0;
            foreach ($details as $detail) {
                $subtotal = $detail->product->price * $detail->quantity;
                $total_sale += $subtotal;
            }

            $transaction_data[] = [
                'sale_id' => $sale->id,
                'sale_date' => $sale->getSaleDate(),
                'sale_buyer_firstname' => $sale->user->firstname,
                'sale_buyer_lastname' => $sale->user->lastname,
                'pay_id' => $sale->pay_id,
                'total_sale' => $total_sale
            ];
        }

         return view('admin.sales')->with('transaction_data', $transaction_data);
     }

    function usersPage(){
        $users = User::all();
        return view('admin.users')->with('users', $users);
    }

    function productPage() {
        return redirect('/admin/products/all');
    }

    function product($category_slug) {
        
        // Default category
        $cat_slug = 'all';
        // Default list product
        $list_product = array();
        
        // Check category option
        if (Category::where('cat_slug', '=', $category_slug)->exists()) {
            $category = Category::where('cat_slug', '=', $category_slug)->first();
            $cat_slug = $category_slug;

            // Check product by category
            if (Product::where('category_id', '=', $category->id)->exists()) {
            $list_product = Product::where('category_id', '=', $category->id)->orderBy('id', 'desc')->get();
            }
        } else {
            $list_product = Product::orderBy('id', 'desc')->get();
        }

        // List Category
        $list_category = Category::all();

        return view('admin.products')->with('cat_slug', $cat_slug)
                                    ->with('list_product', $list_product)
                                    ->with('list_category', $list_category);
    }

    function categoryPage() {
        $list_category = Category::all();

        return view('admin.category')->with('list_category', $list_category);
    }
}
