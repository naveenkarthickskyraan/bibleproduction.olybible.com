<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vidukathaigal extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'level',
        'answer',
        'hints',
    ];

    public function levels()
    {
        return $this->belongsTo('App\Models\Level','level','id');
    }
}
