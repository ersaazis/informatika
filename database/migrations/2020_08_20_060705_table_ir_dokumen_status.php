<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableIrDokumenStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dokumen', function (Blueprint $table) {
            $table->double('sqrt')->nullable();
            $table->boolean('preprocess')->default(0);
            $table->boolean('vsm')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dokumen', function (Blueprint $table) {
            $table->dropColumn('sqrt');
            $table->dropColumn('preprocess');
            $table->dropColumn('vsm');
        });
    }
}
