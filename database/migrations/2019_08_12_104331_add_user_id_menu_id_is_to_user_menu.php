<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdMenuIdIsToUserMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_menu', function (Blueprint $table) {
            $table->unsignedDecimal('id_menu',10,0);
            $table->unsignedDecimal('id_usuario',10,0);
            $table->foreign('id_menu')->references('codigo')->on('menu');
            $table->foreign('id_usuario')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_menu', function (Blueprint $table) {
            $table->dropForeign('id_menu');
            $table->dropForeign('id_usuario');
            $table->dropColumn('id_menu');
            $table->dropColumn('id_usuario');
        });
    }
}
