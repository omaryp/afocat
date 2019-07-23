<?php

namespace App\Imports;

use App\Models\Certificate;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class CertificateImport implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    
    public function model(array $row)
    {
        $codigo = explode('-',$row['codigo_certificado']);
        //dd($row);
        return new Certificate([
            //
            'correlativo' => intval($codigo[1]),
            'anio' => intval($codigo[2]),
            'codigo_certificado' => $row['codigo_certificado'],
            'fecha_emision' => Date::excelToDateTimeObject($row['fecha_emision']),
            'ini_vigencia' => Date::excelToDateTimeObject($row['ini_vigencia']),
            'fin_vigencia' => Date::excelToDateTimeObject($row['fin_vigencia']),
            'ini_control' => Date::excelToDateTimeObject($row['ini_control']),
            'fin_control' => Date::excelToDateTimeObject($row['fin_control']),
            'apellido_paterno' => $row['apellido_paterno'],
            'apellido_materno' => $row['apellido_materno'],
            'nombre' => $row['nombre'],
            'razon_social' =>$row['razon_social'],
            'tipo_documento' =>$row['tipo_documento'],
            'nro_documento' =>$row['nro_documento'],
            'placa' => $row['placa'],
            'provincia' => $row['provincia'],
            'categoria' => $row['categoria'],
            'uso' => $row['uso'],
            'tipo_vehiculo' => $row['tipo_vehiculo'],
            'observaciones' => $row['observaciones'],
        ]);
    }
    
    public function batchSize(): int {
        return 500;
    }
    
    public function chunkSize(): int {
        return 500;
    }

    public function headingRow(): int
    {
        return 1;
    }

}
