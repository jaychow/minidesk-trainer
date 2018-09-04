<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TradeData as TradeData;
use DB;

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

}
