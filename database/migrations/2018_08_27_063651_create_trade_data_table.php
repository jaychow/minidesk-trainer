<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradeDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trade_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_currency');
            $table->dateTime('trade_date');
            $table->decimal('open_bid', 13, 9);
            $table->decimal('high_bid', 13, 9);
            $table->decimal('low_bid', 13, 9);
            $table->decimal('close_bid', 13, 9);
            $table->decimal('volume', 13, 9);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trade_data');
    }
}
