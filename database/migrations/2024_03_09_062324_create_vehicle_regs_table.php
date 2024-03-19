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
        Schema::create('vehicle_regs', function (Blueprint $table) {
            $table->id("vr_id");
            $table->unsignedBigInteger("vr_registered_by");
            $table->date("vr_date");
            $table->integer("vr_brand");
            $table->integer("vr_model");
            $table->integer("vr_color");
            $table->string("vr_chassis_no")->nullable();
            $table->string("vr_engine_no")->nullable();
            $table->string("vr_engine_capacity")->nullable();
            $table->integer("vr_purpose")->nullable();
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
        Schema::dropIfExists('vehicle_regs');
    }
};
