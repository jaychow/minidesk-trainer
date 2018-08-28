<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        return view('home', ['js' => 'user-home']);
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

}
