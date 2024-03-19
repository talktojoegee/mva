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
        Schema::create('stock_receipt_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("stock_receipt_master");
            $table->string("lga_code")->nullable();
            $table->integer("plate_id")->nullable();
            $table->string("plate_no")->nullable();
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
        Schema::dropIfExists('stock_receipt_details');
    }
};
