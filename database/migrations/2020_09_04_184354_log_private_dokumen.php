<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LogPrivateDokumen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dokumen', function (Blueprint $table) {
            $table->boolean('private')->default(0);
            $table->string('upload_by')->nullable();
            $table->unsignedBigInteger('users_id');
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
            $table->dropColumn('private');
            $table->dropColumn('upload_by');
            $table->dropColumn('users_id');
        });
    }
}
