<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BaseVerse extends Model
{
    // Disable timestamps if your dynamic verse tables don't have them
    // public $timestamps = false;
    protected $connection = 'mysql2';

    // Define fillable fields for mass assignment
    protected $fillable = [
        'version_id',
        'book_id',
        'content',
        'status',
        'meta_keyword',
        'meta_description',
        'uploadnotprocess',
        'version_num',
        'book_num',
        'chapter_num',
        'verse_num',
        'uploadedid',
        'chapter_id',
        // Make sure this is fillable if you use mass assignment
    ];

    /**
     * Constructor to dynamically set the table name.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (isset($attributes['version_id'])) {
            $this->setTable('record' . $attributes['version_id']);
        }
    }

    /**
     * Get the table name dynamically.
     * This method ensures the table name is set based on version_id.
     * @return string
     */
    public function getTable()
    {
        if (property_exists($this, 'table')) {
            return $this->table;
        }

        // Fallback or error if version_id is not set
        // Consider throwing an exception or handling this based on your app logic
        return 'record2'; // Or some other default/error handling
    }

    /**
     * Helper to create a new instance with a specific version ID.
     * @param int $versionId
     * @return static
     */
    public static function forVersion(int $versionId): static
    {
        $instance = new static();
        $instance->setTable('record' . $versionId);
        return $instance;
    }
}