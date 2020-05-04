<?php

use App\Constans\InvoicesStatuses;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('reference')->unique();
            $table->string('title');
            $table->double('subtotal', 18, 2)->nullable();
            $table->double('vat', 18, 2)->nullable();
            $table->double('total', 18,2)->nullable();
            $table->string('status')->default(InvoicesStatuses::UNPAID);
            $table->timestamp('receipt_date')->nullable();
            $table->timestamp('duedate')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->string('annulate')->nullable();
            $table->unsignedInteger('client_id');
            $table->unsignedInteger('seller_id');
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
