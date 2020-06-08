<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PlantShopController extends Controller
{

    /**
     * Handle profile request with profile data
     * @return view
     */

    function profile() {

        if (!Auth::check()) {
            return redirect()->back();
        }

        $user = User::where('email', Auth::user()->email)->first();

        $sales = $user->sales()->orderBy('id', 'desc')->get();

        $transaction_history = array();

        foreach ($sales as $sale ) {
            $total = 0;
            $details = $sale->details;

            foreach ($details as $detail) {
                $subtotal = $detail->product->price * $detail->quantity;
                $total += $subtotal;
            }

            $transaction_history[] = [
                'sales_id' => $sale->id,
                'pay_id' => $sale->pay_id,
                'sales_date' => $sale->sales_date,
                'total_price' => $total
            ];
            
        }

        return view('plantshop.profile')->with('transactions', $transaction_history);
    }

    /**
     * Handle profile edit request
     * @param firstname
     * @param lastname
     * @param email
     * @param photo
     * @param password
     * @return view
     */

    function editProfile(Request $request){

        $validate_full = [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users',
            'photo' => 'mimes:jpeg,jpg,png',
            'curr_password' => 'required'
        ];

        $validate_no_email = [
            'firstname' => 'required',
            'lastname' => 'required',
            'photo' => 'mimes:jpeg,jpg,png',
            'curr_password' => 'required'
        ];

        $user = User::where('email', '=', $request->email)->first();
        
        if (Hash::check($request->curr_password, $user->password)) {
            if ($request->email == Session::get('session')) {
                $this->validate($request, $validate_no_email);
            }else {
                $this->validate($request, $validate_full);
            }

            if ($request->photo) {
                $photo = $request->file('photo')->store('avatars');

                if ($request->user()->photo) {
                    Storage::delete($request->user()->photo);
                }

            }else {
                $photo = $user->photo;
            }
            
            $request->user()->update([
                'email' => $request->email,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'photo' => $photo,
                'contact_info' => $request->contact,
                'address' => $request->address
            ]);

            return redirect('/profile');
        }

        return redirect('/profile')->withErrors(['error' => 'Password not match']);
        
    }

    /**
     * Handle profile detail transaction item request
     * @param sales_id
     * @return json
     */

    function profileDetailTransaction(Request $request) {

        $response = array( 'transaction' => '',
                        'date' => '',
                        'list' => '',
                        'total' => '');

        $user = User::where('email', '=' , Auth::user()->email)->first();

        $sale = $user->sales()->where('id', '=', $request->id)->first();
        
        $details = $sale->details->all();

        $total = 0;
        foreach ($details as $detail) {
            $subtotal = $detail->product->price * $detail->quantity;
            $total += $subtotal;

            $response['transaction'] = $sale->pay_id;
            $response['date'] = $sale->sales_date;
            $response['list'] .= "  <tr class='prepend_items'>
                                        <td>" . $detail->product->name . "</td>
                                        <td>Rp. " . $detail->product->number_format_price() . "</td>
                                        <td>" . $detail->quantity . "</td>
                                        <td>Rp. ".number_format($subtotal)."</td>
                                    </tr>
            ";

        }

        $response['total'] = '<b>Rp. '.number_format($total).'<b>';

        return response()->json($response);

    }

}
