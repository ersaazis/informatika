<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DataPendidikan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_pendidikan', function (Blueprint $table) {
            $table->bigIncrements('id')->nullable();
            $table->integer('thn_lulus')->nullable();
            $table->string('nm_sp_formal')->nullable();
            $table->string('namajenjang')->nullable();
            $table->string('singkat_gelar')->nullable();
            $table->unsignedBigInteger('users_id');
            $table->string('signature')->nullable();
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('data_pendidikan');
    }
}
