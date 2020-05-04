<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('document_type');
            $table->string('document')->unique();
            $table->string('name', 50);
            $table->string('surname', 50);
            $table->string('country', 50);
            $table->string('department', 50);
            $table->string('city', 50);
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
        Schema::dropIfExists('clients');
    }
}
