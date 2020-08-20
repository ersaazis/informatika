<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIrDokumenRekomendasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ir_dokumen_rekomendasi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('dokumen_id');
            $table->unsignedBigInteger('users_id');
            $table->foreign('dokumen_id')->references('id')->on('dokumen')->onDelete('cascade');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('vsm')->default(0);
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
        Schema::dropIfExists('ir_dokumen_rekomendasi');
    }
}
