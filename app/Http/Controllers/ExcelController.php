<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Modes\FileLoadController;

class ExcelController extends Controller
{
    //
    public function procesar(){
        $data= request()->all();
        $id = $data['codigo'];
        $fileLoad = FileLoadController::getArchivo($id);
        $ruta = storage_path('app').'/'.$fileLoad->ubicacion;
        if (File::exists($ruta)){
            cargarExcel($ruta);
        }else {
            $mensaje = "No existe el archivo";      
        }
    }

    public function cargaExcel($ruta){
        Excel::load($ruta, function($reader) {
            foreach ($reader->get() as $book) {
                Book::create([
                'name' => $book->title,
                'author' =>$book->author,
                'year' =>$book->publication_year
                ]);
            }
        });
        return Book::all();
    }
}
