<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class TradeData extends Model
{
    protected $table = 'trade_data';

    public static function getChartData($request){

        $response = array(
            'status' => true,
            'title' => "Money Exchange",
            'filename' => 'emptyData.json',
            'name' => 'N/A',
            'minDate' => date("Y-m-d").' 00:00:00',
            'maxDate' => date("Y-m-d").' 16:58:00',
        );

        if($request->input('id_currency') != ""){
            $result = DB::table('trade_data')->select('trade_date', 'open_bid', 'high_bid', 'low_bid', 'close_bid')
                    ->where('id_currency', $request->input('id_currency'))->get();
            $data = array();

            $count = 1;
            $total = $result->count();
            foreach($result as $item){
                if($count == 1){
                    $response['minDate'] = $item->trade_date;
                }elseif($count ==  $total){
                    $response['maxDate'] = $item->trade_date;
                }
                $time = strtotime($item->trade_date);
                $row = array(date("U", $time)*1000,
                            $item->open_bid,
                            $item->high_bid,
                            $item->low_bid,
                            $item->close_bid
                        );
                $data[] = $row;
                $count++;
            }

            $newJsonString = json_encode($data, JSON_PRETTY_PRINT);

            $response['title'] = "Money Exchange ".substr($request->input('currency'), 0, 3)." - ".substr($request->input('currency'), 3, 3);
            $response['filename'] = $request->input('currency').'.json';
            $response['name'] = $request->input('currency');

            file_put_contents(base_path('public/files/'.$request->input('currency').'.json'), stripslashes($newJsonString));
        }

        return $response;
    }

    public static function getTrendLines($request){
        $data = array();
        $result = DB::table('zones')->where("id_currency",  $request->input('id_currency'))->get();
        foreach($result as $item){
            $row = array(
                'id' => $item->id,
                'enabled' => $item->enabled,
                'type' => $item->type,
                'color' => $item->color,
                'xAnchor' => $item->xAnchor,
                'secondXAnchor' => $item->secondXAnchor,
                'valueAnchor' => $item->valueAnchor,
                'secondValueAnchor' => $item->secondValueAnchor,
            );
            $data[] = $row;
        }

        return $data;
    }


}
