<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class VerseImportJob extends Model
{
    protected $fillable = [
        'version_id', 'user_id', 'file_path', 'original_filename',
        'status', 'progress', 'status_message', 'total_rows', 
        'processed_rows', 'added_count', 'updated_count', 
        'failed_count', 'error_message', 'started_at', 'completed_at'
    ];

    protected $dates = ['started_at', 'completed_at'];

    public function version()
    {
        return $this->belongsTo(Version::class);
    }

    public function user()
    {
        return $this->belongsTo(admin::class, 'user_id');
    }

    public function updateProgress($progress, $message = null, $processed = null)
    {
        $data = ['progress' => min(100, max(0, $progress))];
        
        if ($message) $data['status_message'] = $message;
        if ($processed !== null) $data['processed_rows'] = $processed;
        
        $this->update($data);
    }

    public function markAsProcessing($message = 'Starting import process')
    {
        $this->update([
            'status' => 'processing',
            'status_message' => $message,
            'started_at' => now()
        ]);
    }

    public function markAsCompleted($results)
    {
        $this->update([
            'status' => 'completed',
            'progress' => 100,
            'status_message' => 'Import completed successfully',
            'added_count' => $results['added'] ?? 0,
            'updated_count' => $results['updated'] ?? 0,
            'failed_count' => $results['failed'] ?? 0,
            'processed_rows' => $results['total'] ?? 0,
            'completed_at' => now()
        ]);
    }

    public function markAsFailed($error)
    {
        $this->update([
            'status' => 'failed',
            'error_message' => $error,
            'status_message' => 'Import failed: ' . $error,
            'completed_at' => now()
        ]);
    }

    public function getResults()
    {
        return [
            'total' => $this->processed_rows,
            'added' => $this->added_count,
            'updated' => $this->updated_count,
            'failed' => $this->failed_count,
            'completed_at' => $this->completed_at,
            'duration' => $this->started_at ? 
                $this->started_at->diffForHumans($this->completed_at ?? now()) : null
        ];
    }
}
