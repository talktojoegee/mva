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
        Schema::create('vehicle_reg_documents', function (Blueprint $table) {
            $table->id('vrd_id');
            $table->bigInteger("vrd_vehicle_reg");
            $table->integer("vrd_doc_type");
            $table->string("vrd_doc");
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
        Schema::dropIfExists('vehicle_reg_documents');
    }
};
