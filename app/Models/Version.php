<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';

    protected $fillable = [
        'version_name', 'metakeywords', 'metadescription', 'createdby', 'updatedby',
        'createdid', 'updatedid', 'status', 'updated_at', 'created_at',
        'uploadnotprocess', 'uploadedid', 'nooftimesupdated', 'version_num',
        'lang', 'lang_id', 'audiotype', 'alignment'
    ];

    public function verses()
    {
        return new BaseVerse(['version_id' => $this->id]);
    }
}
