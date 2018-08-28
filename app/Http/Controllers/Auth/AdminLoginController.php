<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AdminLoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest:admin')->except(['logout']);
    }

    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        //validate
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        //log attempt
        if(Auth::guard('admin')->attempt(['email'=> $request->email, 'password' => $request->password], $request->remember)){
            //if success redirect
            return redirect()->intended(route('admin.dashboard'));
        }

        //if failed redirect back
        return redirect()->back()->withinput($request->only('email', 'remember'));
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect('/');
    }
}
