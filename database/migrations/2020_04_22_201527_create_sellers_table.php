<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('document_type');
            $table->string('document')->unique();
            $table->string('name');
            $table->string('surname');
            $table->string('company');
            $table->string('country');
            $table->string('department');
            $table->string('city');
            $table->string('email')->unique();
            $table->string('address');
            $table->string('mobile', 30);
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
        Schema::dropIfExists('sellers');
    }
}
