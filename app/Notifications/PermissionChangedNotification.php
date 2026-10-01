<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class PermissionChangedNotification extends Notification
{
    use Queueable;

    protected $changes;

    public function __construct(array $changes)
    {
        $this->changes = $changes;
    }

    public function via($notifiable)
    {
        return ['database']; // Only database notifications
    }

    public function toArray($notifiable)
    {
        $message = 'Your permissions have been updated: ';
        $details = [];

        foreach ($this->changes as $module => $change) {
            $moduleName = Str::title(str_replace('_', ' ', $module));
            
            if ($change['status'] === 'added') {
                $details[] = "✅ {$moduleName} added with permissions: " . implode(', ', $change['permissions']);
            } elseif ($change['status'] === 'removed') {
                $details[] = "❌ {$moduleName} removed";
            } else {
                $added = !empty($change['added']) ? "Added: " . implode(', ', $change['added']) : '';
                $removed = !empty($change['removed']) ? "Removed: " . implode(', ', $change['removed']) : '';
                $details[] = "✏️ {$moduleName} modified. {$added} {$removed}";
            }
        }

        return [
            'message' => $message,
            'details' => $details,
            'url' => url('/profile'),
            'icon' => 'fa-key', // Font Awesome icon for permissions
            'type' => 'permission_change',
        ];
    }
}