<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->unsignedDecimal('codigo',10,0)->unique();
            $table->primary('codigo');
            $table->string('descripcion',50)->nullable();
            $table->string('ruta',150)->nullable();
            $table->unsignedDecimal('tipo',1,0)->nullable();
            $table->unsignedDecimal('parent',10,0)->nullable();
            $table->unsignedDecimal('orden',5,0)->nullable();
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
        Schema::dropIfExists('menu');
    }
}
