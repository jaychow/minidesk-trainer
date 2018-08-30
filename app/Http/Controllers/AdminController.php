<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.home', ['js' => 'dashboard', 'menu' => 'Dashboard']);
    }

    function getDetailsById(Request $request){
        $details = DB::table('admins')->select('name', 'email')->where('id',"=",$request->input('id'))->first();
        return response()->json($details);
    }

}
