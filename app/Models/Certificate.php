<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    //
    protected $fillable = ['correlativo','anio','codigo_certificado','ini_vigencia','fin_vigencia','ini_control','fin_control','placa','apellido_paterno','apellido_materno','nombre','provincia','uso','fecha_emision','hora_emision','categoria','tipo_vehiculo','marca modelo','color','nro_motor','chasis'] ;
}
