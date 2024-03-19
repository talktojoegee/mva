<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_request_details', function (Blueprint $table) {
            $table->id('srd_id');
            $table->unsignedBigInteger('srd_stock_id');
            $table->integer('srd_plate_type');
            $table->integer('srd_quantity')->default(0);
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
        Schema::dropIfExists('stock_request_details');
    }
};
