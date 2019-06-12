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
            $table->string('placa',20);
            $table->string('apellido_paterno',100)->default('');
            $table->string('apellido_materno',100)->default('');
            $table->string('nombre',200)->default('');
            $table->string('provincia',50)->default('')->nullable();
            $table->string('uso',100)->default('')->nullable();
            $table->date('fecha_emision');
            $table->time('hora_emision');
            $table->string('categoria',4)->nulable();
            $table->string('tipo_vehiculo',100)->nulable();
            $table->string('marca',30)->nulable();
            $table->string('modelo',30)->nulable();
            $table->string('color',30)->nulable();
            $table->string('nro_motor',50)->nulable();
            $table->string('chasis',50)->nulable();
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
