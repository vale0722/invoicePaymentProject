<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->unsignedInteger('invoice_id');
            $table->string('status')->default(\App\Constans\PaymentsStatuses::PENDING);
            $table->string('reason')->nullable();
            $table->string('message')->nullable();
            $table->string('request_id')->nullable()->unique();
            $table->string('processUrl')->nullable()->unique();
            $table->timestamp('payment_date')->nullable();
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
