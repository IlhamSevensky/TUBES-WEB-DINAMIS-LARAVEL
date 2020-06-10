<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Handle login page request
     * @return view
     */

    function loginPage() {
        return view('plantshop.login');
    }

    /**
     * Handle register page request
     * @return view
     */
    
    function registerPage() {
        return view('plantshop.register');
    }

    /**
     * Handle register process request
     * @param firstname
     * @param lastname
     * @param email
     * @param password
     * @return view
     */
    
    function register(Request $request) {

        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|same:repassword'
        ]);

        User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'firstname' => $request->firstname,
            'lastname' => $request->lastname
        ]);

        return redirect()->route('register_page')->with('success', 'Account Created Successfully');
    }

    /**
     * Handle login process request
     * @param email
     * @param password
     * @return view
     */

    function login(Request $request) {

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        if (!User::where('email', '=', $request->email)->exists()) {
            return redirect()->back()->with('error', 'Email not registered');
        }

        if (!Auth::attempt($request->only('email','password'))) {
            return redirect()->back()->with('error', 'Wrong Password') ;
        }

        Session::put('session', $request->email);

        $user = User::where('email', '=', $request->email)->first();
    
        if ($user->type == 1) {
            return redirect()->route('admin_page');
        }

        return redirect()->route('home');
    }

    /**
     * Handle logout process request
     * @return view
     */

    function logout() {
        Session::forget('session');
        Auth::logout();
        return redirect()->route('home');
    }
}
