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
        Schema::create('dispense_mlo_masters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('added_by');
            $table->string("ref_code")->nullable();
            $table->unsignedBigInteger("mlo_station")->nullable();
            $table->integer("dispense_status")->default(0)->comment("0=pending,1=approved");
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
        Schema::dropIfExists('dispense_mlo_masters');
    }
};
