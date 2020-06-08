<?php

namespace App\Http\Controllers;

use App\Sale;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    function salesDetail(Request $request) {
        
        $response = array( 'transaction' => '',
                        'date' => '',
                        'list' => '',
                        'total' => '');

        $sale = Sale::where('id', '=', $request->id)->first();
        
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

    function userDetail(Request $request){

        $user = User::where('id', '=', $request->id)->first();

        return response()->json($user);

    }

    function userCart($id) {

        if (!User::where('id','=', $id)->exists()) {
            return redirect()->back();
        }

        $user = User::where('id', '=', $id)->first();
        $cart_items = array();

        if ($user->carts()->count() > 0) {
            $carts = $user->carts()->get();
            foreach ($carts as $item) {
                $cart_items[] = [
                    'cart_id' => $item->id,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity
                ];
            }
        }
        return view('admin.cart')->with('user', $user)
                                ->with('cart_items', $cart_items);

    }

    function userEdit(Request $request) {
        
        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'email',
            'password' => 'required'
        ]);

        if (!User::where('id','=', $request->id)->exists()) {
            return redirect()->back();
        }
        
        $message = 'Update user successfully';
    
        $user = User::where('id', '=', $request->id)->first();
        $update_data = array();
        
        if ($user->email != $request->email ) {
            if (!User::where('email', '=', $request->email)->exists()) {
                $update_data['email'] = $request->email;
            }
        }

        if ($request->password != $user->password) {
            $update_data['password'] = bcrypt($request->password);
        }

        if ($user->firstname != $request->firstname) {
            $update_data['firstname'] = $request->firstname;
        }

        if ($user->lastname != $request->lastname) {
            $update_data['lastname'] = $request->lastname;
        }

        if ($user->contact_info != $request->contact) {
            $update_data['contact_info'] = $request->contact;
        }

        if ($user->address != $request->address) {
            $update_data['address'] = $request->address;
        }

        if (empty($update_data)) {
            return redirect()->back();
        }

        User::where('id', '=', $request->id)->update($update_data);   
        
        return redirect()->back()->with('success', $message);

    }

    function userDelete(Request $request){

        if (!User::where('id','=', $request->id)->exists()) {
            return redirect()->back();
        }

        User::where('id','=', $request->id)->delete();

        return redirect()->back()->with('success', 'User deleted successfuly');
    }

    function userUpdateAvatar(Request $request) {

        $this->validate($request, ['photo' => 'mimes:jpeg,jpg,png']);

        if (!$request->photo || !User::where('id', '=', $request->id)->exists()) {
            return redirect()->back();
        }

        $user = User::where('id', '=', $request->id)->first();

        if ($request->photo) {
            
            if ($user->photo) {
                Storage::delete($user->photo);
            }

            $photo = $request->file('photo')->store('avatars');

            User::where('id', '=', $request->id)->update(['photo' => $photo]);

        }

        return redirect()->back()->with('success', 'Profile photo updated successfully');

    }

    function userAdd(Request $request) {

        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'photo' => 'mimes:jpeg,jpg,png'
        ]);

        $photo = null;
        if ($request->photo) {
            $photo = $request->file('photo')->store('avatars');
        }

        User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'address' => $request->address,
            'contact_info' => $request->contact,
            'photo' => $photo
        ]);

        return redirect()->back()->with('success', 'Account created successfully');
    }

}
