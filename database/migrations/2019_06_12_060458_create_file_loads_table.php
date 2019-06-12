<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileLoadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_loads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre',100)->default('');
            $table->dateTime('fecha_carga')->default(null)->nullable();  
            $table->string('ubicacion',500)->default('');
            //0 sin procesar 1 procesado
            $table->unsignedDecimal('estado',1,0)->default(0);
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
        Schema::dropIfExists('file_loads');
    }
}
