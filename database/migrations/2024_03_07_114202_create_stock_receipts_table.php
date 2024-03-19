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
        Schema::create('stock_receipts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by');
            $table->string("ref_code")->nullable();
            $table->date("receipt_date")->nullable();
            $table->string("attachment")->nullable();
            $table->integer("status")->default(0)->comment('0=pending,1=approved,2=declined');
            $table->unsignedBigInteger('actioned_by')->nullable();
            $table->date('date_actioned')->nullable();
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
        Schema::dropIfExists('stock_receipts');
    }
};
