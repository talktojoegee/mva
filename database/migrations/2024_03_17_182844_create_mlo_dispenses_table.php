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
        Schema::create('mlo_dispenses', function (Blueprint $table) {
            $table->id();
            $table->date("dispense_date")->nullable();
            $table->string("lga_code")->nullable();
            $table->integer("plate_type")->nullable();
            $table->integer("tag_no")->nullable()->comment("also known as plate number");
            $table->integer("status")->default(0);
            $table->string("ref_code")->nullable();
            $table->string("approved_by")->nullable();
            $table->date("approved_date")->nullable();
            $table->integer("sold")->default(0);
            $table->bigInteger("mlo_id")->default(0);
            $table->integer("station")->nullable();
            $table->integer("lock")->default(0);
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
        Schema::dropIfExists('mlo_dispenses');
    }
};
