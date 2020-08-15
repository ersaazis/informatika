<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProfilDosen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('nip')->nullable();
            $table->integer('nidn')->nullable();
        	$table->string('jenis_kelamin')->nullable();
            $table->date('tanggal_lahir')->nullable();
        	$table->string('tmpt_lahir')->nullable();
        	$table->string('namapt')->nullable();
        	$table->string('namaprodi')->nullable();
        	$table->string('statuskeaktifan')->nullable();
        	$table->string('pend_tinggi')->nullable();
        	$table->string('fungsional')->nullable();
            $table->string('ikatankerja')->nullable();
            $table->text('alamat')->nullable();
            $table->string('bidang_keahlian')->nullable();

            $table->string('url_schollar')->nullable();
            $table->string('url_dikti')->nullable();

            $table->string('id_dikti')->nullable();
            $table->string('id_schollar')->nullable();
            $table->string('id_scopus')->nullable();
            $table->string('id_orchid')->nullable();

            $table->integer('programstudi_id')->nullable();
            $table->boolean('proses_update')->default(1);
            $table->boolean('auto_update')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nip');
            $table->dropColumn('nidn');
        	$table->dropColumn('jenis_kelamin');
            $table->dropColumn('tanggal_lahir');
        	$table->dropColumn('tmpt_lahir');
        	$table->dropColumn('namapt');
        	$table->dropColumn('namaprodi');
        	$table->dropColumn('statuskeaktifan');
        	$table->dropColumn('pend_tinggi');
        	$table->dropColumn('fungsional');
            $table->dropColumn('ikatankerja');
            $table->dropColumn('alamat');
            $table->dropColumn('bidang_keahlian');

            $table->dropColumn('url_schollar');
            $table->dropColumn('url_dikti');

            $table->dropColumn('id_dikti');
            $table->dropColumn('id_schollar');
            $table->dropColumn('id_scopus');
            $table->dropColumn('id_orchid');

            $table->dropColumn('programstudi_id');
            $table->dropColumn('proses_update');
            $table->dropColumn('auto_update');
        });
    }
}
