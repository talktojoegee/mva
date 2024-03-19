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
        Schema::create('stock_requests', function (Blueprint $table) {
            $table->id('sr_id');
            $table->unsignedBigInteger('sr_requested_by');
            $table->string('sr_batch_code');
            $table->date('sr_request_date');
            $table->integer('sr_lga');
            $table->integer('sr_status')->default(0)->comment('0=pending,1=approved,2=declined');
            $table->unsignedBigInteger('sr_actioned_by')->nullable();
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
        Schema::dropIfExists('stock_requests');
    }
};
