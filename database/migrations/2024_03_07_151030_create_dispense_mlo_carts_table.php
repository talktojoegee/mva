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
        Schema::create('dispense_mlo_carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("added_by")->nullable();
            $table->string("ref_code")->nullable();
            $table->date("date_added")->nullable();
            $table->string("lga_code")->nullable()->comment("lga_id");
            $table->integer("plate_type")->nullable();
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
        Schema::dropIfExists('dispense_mlo_carts');
    }
};
