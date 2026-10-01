<?php

namespace App\Models\Dictionary;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DictionaryInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'word', 'description', 'version_name', 'table_name', 'version_id'
    ];

    public function versions()
    {
        return $this->belongsTo('App\Models\Version','version_id','id');
    }
}
