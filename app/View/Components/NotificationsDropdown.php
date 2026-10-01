<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NotificationsDropdown extends Component
{
    public $notifications;
    public $unreadCount;

    public function __construct()
    {
        $user = \Auth::guard('admin')->user();
        $this->notifications = $user->notifications()->limit(10)->get();
        $this->unreadCount = $user->unreadNotifications()->count();
    }

    public function render()
    {
        return view('components.notifications-dropdown');
    }
}