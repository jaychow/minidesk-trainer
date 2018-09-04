<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TradeData as TradeData;
use DB;

class ChartDataController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getChartData(Request $request){

        $response = TradeData::getChartData($request);
        return response()->json($response);

    }

    function getTrendLines(Request $request){

        $data = TradeData::getTrendLines($request);
        return response()->json(json_encode(array("annotationsList"=>$data)));

    }
}
