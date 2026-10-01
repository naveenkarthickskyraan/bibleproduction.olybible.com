<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ExistsInMysql2 implements Rule
{
    protected $table;
    protected $column;

    public function __construct($table, $column = 'id')
    {
        $this->table = $table;
        $this->column = $column;
    }

    public function passes($attribute, $value)
    {
        return DB::connection('mysql2')
            ->table($this->table)
            ->where($this->column, $value)
            ->exists();
    }

    public function message()
    {
        return 'The selected :attribute is invalid.';
    }
}