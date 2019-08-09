<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    //
    protected $fillable = ['id','correlativo',
    'anio','codigo_certificado','ini_vigencia','fin_vigencia',
    'ini_control','fin_control','razon_social','tipo_documento','nro_documento','placa',
    'provincia','categoria','uso','tipo_vehiculo','fecha_emision','observaciones'] ;
}
