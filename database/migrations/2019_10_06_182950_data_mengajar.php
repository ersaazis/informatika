<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DataMengajar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_mengajar', function (Blueprint $table) {
            $table->bigIncrements('id')->nullable();
            $table->string('id_smt')->nullable();
            $table->string('nm_kls')->nullable();
            $table->string('kode_mk')->nullable();
            $table->string('nm_mk')->nullable();
            $table->string('namapt')->nullable();
            $table->string('signature')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('data_mengajar');
    }
}
