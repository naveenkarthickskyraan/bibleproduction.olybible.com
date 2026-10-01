
<style>
    .notifications-dropdown {
        position: relative;
    }

    .notifications-dropdown .dropdown-menu {
        width: 350px;
        max-height: 400px;
        overflow-y: auto;
    }

    .notification-item {
        padding: 10px 15px;
        border-left: 3px solid transparent;
    }

    .notification-item.unread {
        background-color: #f8f9fa;
        border-left-color: #007bff;
    }

    .notification-title {
        font-weight: 500;
    }

    .notification-details {
        margin: 5px 0;
        color: #6c757d;
    }

    .notification-details small {
        display: block;
        line-height: 1.4;
    }
</style>

<div class="dropdown notifications-dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-bell"></i>
        @if($unreadCount)
            <span class="badge badge-danger">{{ $unreadCount }}</span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-menu-right">
        @forelse($notifications as $notification)
            <a href="{{ $notification->data['url'] ?? '#' }}" 
               class="dropdown-item notification-item {{ $notification->unread() ? 'unread' : '' }}"
               data-id="{{ $notification->id }}">
                <div class="d-flex align-items-center">
                    <div class="mr-2">
                        <i class="fa {{ $notification->data['icon'] ?? 'fa-bell' }}"></i>
                    </div>
                    <div>
                        <div class="notification-title">{{ $notification->data['message'] }}</div>
                        @isset($notification->data['details'])
                            <div class="notification-details">
                                @foreach($notification->data['details'] as $detail)
                                    <small>{{ $detail }}</small><br>
                                @endforeach
                            </div>
                        @endisset
                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            </a>
        @empty
            <span class="dropdown-item">No new notifications</span>
        @endforelse
        @if($unreadCount)
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item mark-all-read">Mark all as read</a>
        @endif
    </div>
</div>