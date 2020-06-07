<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Detail;
use App\Product;
use App\Sale;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    
    /**
     * Handle cart add request
     * @param product_id
     * @param quantity
     * @return json
     */
    
    function cartAdd(Request $request) {

        if (!Auth::check()) {
            return response()->json(['login' => false, 'error' => true, 'message' => 'You have to login first']);
        }

        if(Product::where('id', '=', $request->product_id)->exists()){

            if(User::where('email', '=', Auth::user()->email)->exists()){

                if(!Cart::where('user_id', '=', Auth::user()->id)
                        ->where('product_id', '=', $request->product_id)
                        ->exists()
                ){
                    Cart::create([
                        'user_id' => Auth::user()->id,
                        'product_id' => $request->product_id,
                        'quantity' => $request->quantity
                    ]);

                    return response()->json(['login' => true, 'error' => false, 'message' => 'Item added to cart']);
                }

                return response()->json(['login' => true, 'error' => true, 'message' => 'Product already in cart']);
            }

        }

    }

    /**
     * Handle cart fetch status and detail request
     * @return json
     */
    
    function cartFetch(){
        $response = array('list'=>'','count'=>0);

        if (Auth::check()) {
            
            $user = User::where('email', '=' , Auth::user()->email)->first();
            $carts = $user->carts()->get();
            foreach ($carts as $item) {
                $response['list'] .= "<li>
                                        <a href='/product/". $item->product->slug ."'>
                                            <div class='pull-left'>
                                                <img src='". $item->product->image() ."' class='thumbnail' alt='User Image'>
                                            </div>
                                            <h4>
                                                <b>". $item->product->name ."</b>
                                                <small>&times; ". $item->quantity ."</small>
                                            </h4>
                                            <p>". $item->product->category->name ."</p>
                                        </a>
                                    </li>";
                $response['count']++;
            }
            
            
        }
        return response()->json($response);
    }

    /**
     * Handle cart detail request
     * @return json
     */
    
    function cartDetail() {
        $response = "<tr>
                        <td colspan='6' align='center'>Shopping cart is empty</td>
                    <tr>";

        if (Auth::check()) {
            $total = 0;
            $user = User::where('email', '=' , Auth::user()->email)->first();

            if ($user) {
                if ($user->carts()->count() > 0) {
                    $response = '';
                    $carts = $user->carts()->get();
                    foreach ($carts as $item) {
                        $subtotal = $item->product->price * $item->quantity;
                        $total += $subtotal;
                        $response .= "<tr>
                                        <td><img src='". $item->product->image() ."' width='30px' height='30px'></td>
                                        <td>". $item->product->name ."</td>
                                        <td>Rp. ". $item->product->number_format_price() ."</td>
                                        <td class='input-group'>
                                            <span class='input-group-btn'>
                                                <button type='button' id='minus' class='btn btn-default minus' data-id='". $item->id ."'><i class='fa fa-minus'></i></button>
                                            </span>
                                            <input type='text' class='form-control' value='". $item->quantity ."' id='qty_". $item->id ."'>
                                            <span class='input-group-btn'>
                                                <button type='button' id='add' class='btn btn-default add' data-id='". $item->id ."'><i class='fa fa-plus'></i>
                                                </button>
                                            </span>
                                        </td>
                                        <td>Rp. ".number_format($subtotal)."</td>
                                        <td><button type='button' data-id='". $item->id ."' class='btn btn-danger cart_delete'><i class='fa fa-remove'></i></button></td>
                                    </tr>";
                    }
                    $response .= "<tr>
                                    <td colspan='5' align='right'><b>Total</b></td>
                                    <td><b>Rp. ".number_format($total)."</b></td>
                                  <tr>";   
    
                }

            }

        }

        return response()->json($response);

    }

    /**
     * Handle cart total price request
     * @return json
     */

    function cartTotal() {
        $total = 0;

        if (Auth::check()) {
            
            $user = User::where('email', '=' , Auth::user()->email)->first();

            if ($user) {
                $carts = $user->carts()->get();
                foreach ($carts as $cart) {
                    $subtotal = $cart->product->price * $cart->quantity;
                    $total += $subtotal;
                }
            }

        }

        return response()->json($total);

    }

    /**
     * Handle cart update quantity request
     * @param cart_id
     * @param product_quantity
     * @return json
     */
    
    function cartUpdate(Request $request) {

        $response = array('error'=> false,'message'=>'Error when updating');

        if (Auth::check()) {
            
            $user = User::where('email', '=' , Auth::user()->email)->first();

            if ($user) {
                Cart::where('id', '=', $request->id)
                    ->update(['quantity' => $request->qty]);
                
                    $response['message'] = "Updated";
            }

        }

        return response()->json($response);

    }

    /**
     * Handle cart delete request
     * @param cart_id
     * @return json
     */
    
    function cartDelete(Request $request) {

        $response = array('error'=> false,'message'=>'Error when deleting');

        if (Auth::check()) {
            
            $user = User::where('email', '=' , Auth::user()->email)->first();

            if ($user) {
                Cart::where('id', '=', $request->id)
                    ->delete();
                
                    $response['message'] = "Deleted";
            }

        }

        return response()->json($response);

    }

    /**
     * Handle checkout based on cart request
     * @return json
     */
    
    function cartCheckout() {

        if (Auth::check()) {
            $user = User::where('email', '=' , Auth::user()->email)->first();

            if ($user->carts()->count() > 0) {
                $first_code = "PAY-";
                $random = "123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";

                $end_code = substr(str_shuffle($random), 0, 22);

                $pay_id = $first_code . $end_code;
                
                if (Sale::all()->count() > 0) {
                    while (Sale::where('pay_id', '=', $pay_id)->exists()) {
                        $end_code = substr(str_shuffle($random), 0, 22);
                    }

                    $pay_id = $first_code . $end_code;
                }
                
                $sale = Sale::create([
                    'user_id' => $user->id,
                    'pay_id' => $pay_id,
                    'sales_date' => date('Y-m-d')
                ]);
                
                $carts = $user->carts()->get();
                foreach($carts as $cart) {
                    Detail::create([
                        'sales_id' => $sale->id,
                        'product_id' => $cart->product->id,
                        'quantity' => $cart->quantity
                    ]);
                }

                Cart::where('user_id', '=', $user->id)
                    ->delete();

                return response()->json(
                    [
                        'error' => false,
                        'message' =>'Transaction with ID : [' . $pay_id . '] is successfull',
                    ]
                );
            }
            
            return response()->json(
                [
                    'error' => true,
                    'message' =>'Your cart is empty',
                ]
            );

        }

        return response()->json(
            [
                'error' => true,
                'message' => 'Failed to make transaction',
            ]
        );

    }
}
