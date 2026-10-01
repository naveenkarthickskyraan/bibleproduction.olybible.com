<?php

namespace App\Exports;

use App\Models\LetterCount;
use Maatwebsite\Excel\Concerns\FromCollection;

class StudentExport implements FromCollection
{
    public $cid;

    public function __construct($id)
    {
        // $this->middleware('auth');
        $this->cid = $id;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return[
            'Id',
            'letters',
            'category_id', 
        ];
    } 
    public function collection()
    {
        return LetterCount::where('category_id', $this->cid)->where('deleted_at','0')->get();
    }
}
