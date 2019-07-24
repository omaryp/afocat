<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parametro extends Model
{
    //
    protected $fillable = ['codigo','codtab',
    'descor','deslar','valent','valdec'] ;
}
/*
INSERT INTO `afocat`.`parametros` (`codigo`, `descor`, `deslar`, `valent`) VALUES ('1', 'Ciudades', 'Ciudades', '0');
INSERT INTO `afocat`.`parametros` (`codigo`, `codtab`, `descor`, `deslar`, `valent`) VALUES ('1', '01', 'Piura', 'Piura', '1');
INSERT INTO `afocat`.`parametros` (`codigo`, `codtab`, `descor`, `deslar`, `valent`) VALUES ('1', '02', 'Ayabaca', 'Ayabaca', '2');
INSERT INTO `afocat`.`parametros` (`codigo`, `codtab`, `descor`, `deslar`, `valent`) VALUES ('1', '03', 'Huancabamba', 'Huancabamba', '3');
INSERT INTO `afocat`.`parametros` (`codigo`, `codtab`, `descor`, `deslar`, `valent`) VALUES ('1', '04', 'Morropón', 'Morropón', '4');
INSERT INTO `afocat`.`parametros` (`codigo`, `codtab`, `descor`, `deslar`, `valent`) VALUES ('1', '05', 'Paita', 'Paita', '5');
INSERT INTO `afocat`.`parametros` (`codigo`, `codtab`, `descor`, `deslar`, `valent`) VALUES ('1', '06', 'Sullana', 'Sullana', '6');
INSERT INTO `afocat`.`parametros` (`codigo`, `codtab`, `descor`, `deslar`, `valent`) VALUES ('1', '07', 'Talara', 'Talara', '7');
INSERT INTO `afocat`.`parametros` (`codigo`, `codtab`, `descor`, `deslar`, `valent`) VALUES ('1', '08', 'Sechura', 'Sechura', '8');
*/
