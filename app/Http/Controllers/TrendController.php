<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\TradeData as TradeData;

class TrendController extends Controller
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
        return view('backend.trend', ['js' => 'trend', 'menu' => 'Trend', 'select2' => $data]);
    }

    public function getJsonData(){
        $result = DB::table('trade_data')->select('trade_date', 'open_bid', 'high_bid', 'low_bid', 'close_bid')->limit(1000)->get();
        $data = array();
        foreach($result as $item){
            $time = strtotime($item->trade_date);
            $utc_time = mktime( date("H", $time),
                                date("i", $time),
                                0,
                                date("d", $time),
                                date("m", $time),
                                date("Y", $time)
                        );
            $row = array($utc_time*1000,
                         $item->open_bid,
                         $item->high_bid,
                         $item->low_bid,
                         $item->close_bid
                        );
            $data[] = $row;
        }
        return response()->json($data);
    }

    function saveTrendLines(Request $request){
        $arr[] = ['id_currency' => $request->input('id_currency'),
                  'enabled' => $request->input('enabled'),
                  'type' => $request->input('type'),
                  'color' => $request->input('color'),
                  'xAnchor' => $request->input('xAnchor'),
                  'secondXAnchor' => $request->input('secondXAnchor'),
                  'valueAnchor' => $request->input('valueAnchor'),
                  'secondValueAnchor' => $request->input('secondValueAnchor'),
        ];
        $status = DB::table('zones')->insert($arr);
        return response()->json(array('status'=>$status));
    }

    function removeTrendLines(Request $request){
        DB::table('zones')->where('id_currency', $request->input('id_currency'))
           ->where('color', $request->input('color'))
           ->where('xAnchor', $request->input('xAnchor'))
           ->where('secondXAnchor', $request->input('secondXAnchor'))
           ->delete();
        return response()->json(json_encode(array('status'=>true)));
    }

    function getTrendLines(Request $request){

        $data = TradeData::getTrendLines($request);
        return response()->json(json_encode(array("annotationsList"=>$data)));
        // $param = array( "enabled"=>true,
        //                 "type"=>"vertical-line",
        //                 "color"=>"#e06666",
        //                 "allowEdit"=>true,
        //                 "hoverGap"=>5,
        //                 "normal"=>array("markers"=>array(   "enabled"=>false,
        //                                                     "anchor"=>"center",
        //                                                     "offsetX"=>0,
        //                                                     "offsetY"=>0,
        //                                                     "type"=>"square",
        //                                                     "rotation"=>0,
        //                                                     "size"=>10,
        //                                                     "fill"=>"#ffff66",
        //                                                     "stroke"=>"#333333"
        //                                             )
        //                                 ),
        //                 "hovered"=>array("markers"=>array("enabled"=>null)),
        //                 "selected"=>array("markers"=>array("enabled"=>true))
        //                 ,"xAnchor"=>0
        //             );

    }

    public function saveToJsonFile(Request $request){

        $response = TradeData::getChartData($request);
        return response()->json($response);

    }

    public function getCurrency(){
        $result = DB::table('currency')->select('id_currency', 'currency_name')->get();
        $data = array();
        foreach($result as $item){
            $row = array();
            $row['id'] = $item->id_currency;
            $row['item'] = $item->currency_name;
            $data[] = $row;
        }

        return response()->json($data);
    }

    public function saveTrendLineChange(Request $request){

        $update = DB::table('zones')->where("id", $request->input('id'))->update(array(
            'xAnchor' => $request->input('xAnchor'),
            'secondXAnchor' => $request->input('secondXAnchor'),
            'valueAnchor' => $request->input('valueAnchor'),
            'secondValueAnchor' => $request->input('secondValueAnchor'),
        ));

        return response()->json($update);
    }


}
