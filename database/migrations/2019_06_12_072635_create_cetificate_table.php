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
            $table->date('ini_vigencia')->nullable();
            $table->date('fin_vigencia')->nullable();
            $table->date('ini_control')->nullable();
            $table->date('fin_control')->nullable();
            $table->string('apellido_paterno',100)->default('')->nullable();
            $table->string('apellido_materno',100)->default('')->nullable();
            $table->string('nombre',200)->default('')->nullable();
            $table->string('razon_social',300)->default('')->nullable();
            $table->string('tipo_documento',5)->default('')->nullable();
            $table->string('nro_documento',200)->default('')->nullable();
            $table->string('placa',20)->default('')->nullable();
            $table->string('provincia',50)->default('')->nullable();
            $table->string('categoria',4)->nullable()->nullable();
            $table->string('uso',100)->default('')->nullable();
            $table->string('tipo_vehiculo',100)->nullable();
            $table->date('fecha_emision')->nullable();
            $table->string('observaciones',500)->nullable();
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
