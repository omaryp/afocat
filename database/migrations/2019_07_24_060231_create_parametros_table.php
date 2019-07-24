<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParametrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parametros', function (Blueprint $table) {
            //$table->increments('id');
            $table->integer('codigo');
            $table->char('codtab',6);
            $table->primary(['codigo','codtab']);
            $table->char('descor',50);
            $table->char('deslar',200);
            $table->integer('valent');
            $table->double('valdec',15,9);
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
        Schema::dropIfExists('parametros');
    }
}
