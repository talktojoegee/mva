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
        Schema::create('mlo_setups', function (Blueprint $table) {
            $table->id('ms_id');
            $table->integer('ms_station');
            $table->string('ms_mlo_id');
            $table->string('ms_last_name')->nullable();
            $table->string('ms_first_name')->nullable();
            $table->string('ms_other_names')->nullable();
            $table->string('ms_email')->nullable();
            $table->string('ms_phone_no')->nullable();
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
        Schema::dropIfExists('mlo_setups');
    }
};
