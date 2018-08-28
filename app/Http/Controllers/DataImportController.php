<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Currency as Currency;
use App\TradeData as TradeData;
use Yajra\Datatables\Datatables;

class DataImportController extends Controller
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
        return view('backend.data-import', ['js' => 'data-import', 'menu' => 'Import']);
    }

    public function importFile(Request $request){
        if($request->hasFile('sample_file')){

            $currency = $request->input('currency');
            if(isset($currency) == false){
                $filename = $request->file('sample_file')->getClientOriginalName();
                $filename = explode("_", $filename);
                if(sizeof($filename) >= 3 ){
                    $currency = $filename[2];
                }
            }

            $currency_id = Currency::getCurrencyId($currency);

            $path = $request->file('sample_file')->getRealPath();

            $data = \Excel::load($path, function($reader) { $reader->noHeading = true; })->get();
            if($data->count()){
                $devider = 1000;
                $count_devider = 1;
                $i = 1;
                foreach ($data as $key => $value) {
                    $arr[] = ['id_currency' => $currency_id,
                              'trade_date' => $value[0],
                              'open_bid' => $value[1],
                              'high_bid' => $value[2],
                              'low_bid' => $value[3],
                              'close_bid' => $value[4],
                              'volume' => $value[5],
                            ];
                    if($i == $count_devider*$devider || $i == $data->count()){
                        if(!empty($arr)){

                            DB::table('trade_data')->insert($arr);
                            unset($arr);

                        }
                        $count_devider++;
                    }
                    $i++;
                }

                    dd('Insert Recorded successfully.');

            }

        }

        dd('Request data does not have any files to import.');

    }

    public function anyData()
    {
        return Datatables::of(TradeData::query())->make(true);
    }
}
