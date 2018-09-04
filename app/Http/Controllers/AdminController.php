<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Admin as Admin;
use DB;
use Auth;

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

    public function profile(){
        return view('backend.profile', ['js' => 'profile', 'menu' => 'Profile']);
    }

    public function checkEmail(Request $request){
        $status = "Email already in use";
        $result = Admin::where('id', Auth::user()->id)
                ->where('email', $request->input('email'))
                ->first();
        if($result == null){
            $result = Admin::where('email', $request->input('email'))->first();
            if($result == null){
                $status = "true";
            }
        }else{
            $status = "true";
        }
        return response()->json($status);
    }

    public function getDetails(){
        $result = Admin::select('email', 'name')->where('id', Auth::user()->id)->first();
        return response()->json($result);
    }

    function getDetailsById(Request $request){
        $details = DB::table('admins')->select('name', 'email')->where('id',"=",$request->input('id'))->first();
        return response()->json($details);
    }

    public function update(Request $request){
        $update = Admin::where("id", Auth::user()->id)->update(array(
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ));

        return response()->json($update);
    }

    public function updatePassword(Request $request){
        $update = Admin::where("id", Auth::user()->id)->update(array(
            'password' => Hash::make($request->input('password')),
        ));

        return response()->json($update);
    }

}
