<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('invoice_id');
            $table->unsignedInteger('product_id');
            $table->integer('quantity');
            $table->double('unit_value');
            $table->double('total_value');
            $table->timestamps();

            $table->foreing('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->foreing('product_id')->references('id')->on('products')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_products');
    }
}
