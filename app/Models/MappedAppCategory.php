<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AppList;

class MappedAppCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'category_id',
        'app_id',
        'language_code',
    ];


}
