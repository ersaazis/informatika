<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIrToken extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ir_token', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('token')->unique();
            $table->integer('df')->nullable();
            $table->double('d_df')->nullable();
            $table->double('idf')->nullable();
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
        Schema::dropIfExists('ir_token');
    }
}
