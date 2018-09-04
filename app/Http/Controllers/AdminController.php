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
        $result = DB::table('currency')->select('id_currency', 'currency_name')->get();
        $data = array();
        foreach($result as $item){
            $row = array();
            $row['id'] = $item->id_currency;
            $row['item'] = $item->currency_name;
            $data[] = $row;
        }
        return view('backend.home', ['js' => 'dashboard', 'menu' => 'Dashboard' , 'select2' => $data]);
    }

    function getDetailsById(Request $request){
        $details = DB::table('admins')->select('name', 'email')->where('id',"=",$request->input('id'))->first();
        return response()->json($details);
    }

}
