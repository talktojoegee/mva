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
        Schema::create('invoice_masters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("issued_by");
            $table->date("issue_date")->nullable();
            $table->date("due_date")->nullable();
            $table->string("ref_code")->nullable();
            $table->double("total")->default(0);
            $table->string("slug")->nullable();
            $table->integer("status")->default(0)->comment("0=not paid,1=partly,2=fully paid");
            $table->string("approved_by")->nullable();
            $table->date("approved_date")->nullable();
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
        Schema::dropIfExists('invoice_masters');
    }
};
