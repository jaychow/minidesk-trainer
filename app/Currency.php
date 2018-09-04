<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Currency extends Model
{
    protected $table = 'currency';

    public static function getCurrencyId($currency_name){
        $curr = DB::table('currency')->where('currency_name', $currency_name)->first();
        if($curr != null){
            return $curr->id_currency;
        }else{
            $id = DB::table('currency')->insertGetId(
                [ 'currency_name' => strtoupper($currency_name) ]
            );
            return $id;
        }
    }

}
