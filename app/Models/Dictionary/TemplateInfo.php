<?php

namespace App\Models\Dictionary;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateInfo extends Model
{
    use HasFactory;

    public function version()
    {
        return $this->belongsTo('App\Models\Version','version_id','id');
    }
}
