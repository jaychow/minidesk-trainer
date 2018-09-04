<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_currency');
            $table->char('enabled', 6);
            $table->char('type', 20);
            $table->char('color', 25);
            $table->bigInteger('xAnchor');
            $table->bigInteger('secondXAnchor');
            $table->decimal('valueAnchor', 15, 9);
            $table->decimal('secondValueAnchor', 15, 9);
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
        Schema::dropIfExists('zones');
    }
}
