<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class TableRolePrivileges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cb_role_privileges', function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("cb_roles_id");
            $table->unsignedInteger("cb_menus_id");
            $table->tinyInteger("can_browse")->default(1);
            $table->tinyInteger("can_create")->default(1);
            $table->tinyInteger("can_read")->default(1);
            $table->tinyInteger("can_update")->default(1);
            $table->tinyInteger("can_delete")->default(1);
            $table->foreign('cb_roles_id')->references('id')->on('cb_roles')->onDelete('cascade');
            $table->foreign('cb_menus_id')->references('id')->on('cb_menus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cb_role_privileges');
    }
}
