<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Validator;

class FechaValida implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value){
        //
        $rpta = TRUE;
        try {
            $fecha = Date::excelToDateTimeObject($value);
            $data[$attribute] = $fecha;
        } catch (\Throwable $th) {
            $rpta = FALSE;
        }
        return ($rpta && FechaValida::validator($attribute,$data));
    }

    public static function validator($attribute,$data){
        $validator = Validator::make($data, [
            $attribute => 'date_format:d/m/Y',
        ]);
        return($validator->fails());
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El campo :attribute no es una fecha.';
    }
}
