<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //
    protected $fillable = ['codigo','descripcion','ruta','tipo','parent','orden'];
}
