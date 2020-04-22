<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('reference', 32);
            $table->unsignedInteger('invoice_id');
            $table->double('amount');
            $table->string('status')->nullable();
            $table->string('request_id')->nullable()->unique();
            $table->string('processUrl')->nullable()->unique();
            $table->timestamp('playment_date')->nullable();
            $table->timestamps();

            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}