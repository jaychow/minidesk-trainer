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

        if($request->file('sample_file')->getClientOriginalExtension() == "csv"){

            if (($handle = fopen("$path", "r")) !== FALSE) {
                $counter = 1;
                while (($value = fgetcsv($handle, 1000, ";")) !== FALSE) {
                    $arr[] = ['id_currency' => $currency_id,
                                'trade_date' => $value[0],
                                'open_bid' => str_replace(",", ".", $value[1]),
                                'high_bid' => str_replace(",", ".", $value[2]),
                                'low_bid' => str_replace(",", ".", $value[3]),
                                'close_bid' => str_replace(",", ".", $value[4]),
                                'volume' => str_replace(",", ".", $value[5]),
                            ];
                    if($counter == 1000){
                        DB::table('trade_data')->insert($arr);
                        unset($arr);
                        $counter = 0;
                    }else{
                        $counter++;
                    }
                }
                if(!empty($arr)){
                    DB::table('trade_data')->insert($arr);
                }
                fclose($handle);
            }

        }else{

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

            }
        }

        return response()->json(true);

    }

    public function anyData()
    {
        return Datatables::of(TradeData::query())->make(true);
    }
}
