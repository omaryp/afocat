<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCetificateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedDecimal('correlativo',8,0)->default(0);
            $table->unsignedDecimal('anio',4,0)->default(0);
            $table->string('codigo_certificado',20)->default(0)->unique();
            $table->date('ini_vigencia');
            $table->date('fin_vigencia');
            $table->date('ini_control');
            $table->date('fin_control');
            $table->string('apellido_paterno',100)->default('');
            $table->string('apellido_materno',100)->default('');
            $table->string('nombre',200)->default('');
            $table->string('razon_social',300)->default('');
            $table->string('tipo_documento',5)->default('');
            $table->string('nro_documento',200)->default('');
            $table->string('placa',20);
            $table->string('provincia',50)->default('')->nullable();
            $table->string('categoria',4)->nulable();
            $table->string('uso',100)->default('')->nullable();
            $table->string('tipo_vehiculo',100)->nulable();
            $table->date('fecha_emision');
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
        Schema::dropIfExists('certificates');
    }
}
