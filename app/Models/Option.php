<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    //
    protected $fillable = ['codigo','descripcion','ruta','tipo','parent','orden'];
}
