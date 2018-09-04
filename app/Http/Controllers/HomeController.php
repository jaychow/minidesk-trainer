<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\TradeData as TradeData;
use App\User as User;
use DB;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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
        return view('home', ['js' => 'user-home', 'select2' => $data]);
    }

    public function getChartData(Request $request){

        $response = TradeData::getChartData($request);
        return response()->json($response);

    }

    function getTrendLines(Request $request){

        $data = TradeData::getTrendLines($request);
        return response()->json(json_encode(array("annotationsList"=>$data)));

    }

    public function profile(){
        return view('profile', ['js' => 'user-profile', 'menu' => 'Profile']);
    }

    public function checkEmail(Request $request){
        $status = "Email already in use";
        $result = User::where('id', Auth::user()->id)
                ->where('email', $request->input('email'))
                ->first();
        if($result == null){
            $result = User::where('email', $request->input('email'))->first();
            if($result == null){
                $status = "true";
            }
        }else{
            $status = "true";
        }
        return response()->json($status);
    }

    public function getDetails(){
        $result = User::select('email', 'name')->where('id', Auth::user()->id)->first();
        return response()->json($result);
    }

    function getDetailsById(Request $request){
        $details = DB::table('admins')->select('name', 'email')->where('id',"=",$request->input('id'))->first();
        return response()->json($details);
    }

    public function update(Request $request){
        $update = User::where("id", Auth::user()->id)->update(array(
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ));

        return response()->json($update);
    }

    public function updatePassword(Request $request){
        $update = User::where("id", Auth::user()->id)->update(array(
            'password' => Hash::make($request->input('password')),
        ));

        return response()->json($update);
    }

}
