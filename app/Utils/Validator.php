<?php

namespace App\Utils;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class Validator
{
    /**
     * Checks unique fields value
     *
     * @param string $field
     * @param string $table
     * @param string $col
     * @param mixed $value
     * @return boolean
     */
    public static function unique(string $field, string $table, string $col, mixed $value): bool
    {
        $result =  DB::table($table)
            ->select($col)
            ->where($col, '=', $value)
            ->first();

        if ($result) {
            throw ValidationException::withMessages([
                $field => [__('The value has already been taken.')],
            ]);
        }

        return true;
    }
}
