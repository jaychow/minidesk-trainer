<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Admin as Admin;

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
        if ( ! Admin::where('email', $request->email)->first() ) {
            return redirect()->back()
                ->withinput($request->only('email', 'remember'))
                ->withErrors([
                    'email' => "These credentials do not match our records."
                ]);
        }

        if ( ! Admin::where('email', $request->email)->where('password',  Hash::make($request->input('password')))->first() ) {
            return redirect()->back()
                ->withinput($request->only('email', 'remember'))
                ->withErrors([
                    'password' => "Wrong password."
                ]);
        }
    }


    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect('/');
    }
}
