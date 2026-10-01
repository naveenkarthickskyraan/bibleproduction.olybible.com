<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Bible Apps - Dashboard</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/skyraan-technologies.avif') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">

    <!-- Main CSS -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/preloader.css') }}" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #7367EF !important;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --info-color: #4895ef;
            --warning-color: #f8961e;
            --danger-color: #f72585;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f7fb;
        }
        
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card {
            border-left: 4px solid;
            border-radius: 8px;
            border-color: #8e84f3;
        }
        
        .stat-card i {
            font-size: 1.75rem;
            opacity: 0.8;
        }
        .pagetitle h1{
            color: #7367EF !important;
        }
        
        .activity-item {
            position: relative;
            padding-left: 2rem;
            border-left: 2px solid #e9ecef;
            margin-bottom: 1.5rem;
        }
        
        .activity-item:last-child {
            margin-bottom: 0;
        }
        
        .activity-item::before {
            content: '';
            position: absolute;
            left: -7px;
            top: 0;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--primary-color);
        }
        
        .activity-time {
            font-size: 0.8rem;
            color: #6c757d;
        }
        
        .chart-container {
            position: relative;
            height: 300px;
        }
        
        .quick-action-btn {
            transition: all 0.3s ease;
            border-radius: 10px;
            padding: 1.5rem 0.5rem;
        }
        
        .quick-action-btn:hover {
            transform: scale(1.05);
        }
        
        .badge-date {
            background-color: #7367EF !important;
            color: var(--primary-color);
        }
        
        .main-content {
            margin-left: 280px;
            transition: margin-left 0.3s ease;
        }
        
        @media (max-width: 992px) {
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    @include('admin.navbar')
    <!-- ======= Sidebar ======= -->
    @include('admin.sidebar')
    
    <!-- Preloader -->
    <div id="pre-loader" class="pre-loader is-active">
        <div class="loader"></div>
    </div>

    <main id="main" class="main main-content">
        <div class="pagetitle px-3 py-2">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1>Dashboard</h1>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </nav>
                </div>
                <div class="badge badge-date p-2">
                    <i class="bi bi-calendar3 me-2 text-white" ></i>
                    <span class="text-white">{{ now()->format('l, F j, Y') }}</span>
                </div>
            </div>
        </div><!-- End Page Title -->

        <section class="section dashboard px-3">
            <div class="row">
                <!-- Stats Cards -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card stat-card border-left-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2">Total Levels</h6>
                                    <h3 class="mb-0">{{ $totalQuizzes }}</h3>
                                </div>
                                <div class="bg-primary bg-opacity-10 p-3 rounded">
                                    <i class="bi bi-layers text-primary"></i>
                                </div>
                            </div>
                            <a href="{{ url('admin/level_list') }}" class="small text-primary stretched-link mt-2 d-block">View Levels</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card stat-card border-left-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2">Bible Apps</h6>
                                    <h3 class="mb-0">{{ $totalCategories }}</h3>
                                </div>
                                <div class="bg-success bg-opacity-10 p-3 rounded">
                                    <i class="bi bi-collection text-success"></i>
                                </div>
                            </div>
                            <a href="{{ url('admin/vidukathaigal_list') }}" class="small text-success stretched-link mt-2 d-block">Manage Bible Apps</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card stat-card border-left-info">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2">Active Users</h6>
                                    <h3 class="mb-0">{{ $activeUsers }}</h3>
                                </div>
                                <div class="bg-info bg-opacity-10 p-3 rounded">
                                    <i class="bi bi-people text-info"></i>
                                </div>
                            </div>
                            <a href="{{ url('admin/superadmin') }}" class="small text-info stretched-link mt-2 d-block">View Users</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card stat-card border-left-warning">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2">Recent Activity</h6>
                                    <h3 class="mb-0">{{ count($recentActivities) }}</h3>
                                </div>
                                <div class="bg-warning bg-opacity-10 p-3 rounded">
                                    <i class="bi bi-clock-history text-warning"></i>
                                </div>
                            </div>
                            <a href="#" class="small text-warning stretched-link mt-2 d-block">View All</a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <!-- Notification Card -->
                <div class="col-lg-12 mb-4">
                    <div class="card stat-card">
                        <div class="card-body">
                            
                            <style>
                                .notifications-container {
                                    border-radius: 8px;
                                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
                                }
                                
                                .notifications-header {
                                    background-color: #f8f9fa;
                                    border-bottom: 1px solid #eaeaea;
                                    padding: 15px 20px;
                                    border-radius: 8px 8px 0 0;
                                }
                                
                                .notifications-title {
                                    font-size: 1.25rem;
                                    font-weight: 600;
                                    color: #2c3e50;
                                    display: flex;
                                    align-items: center;
                                    gap: 10px;
                                }
                                
                                .notifications-title i {
                                    color: #4e73df;
                                }
                                
                                .notifications-tools {
                                    display: flex;
                                    gap: 10px;
                                }
                                
                                .notifications-list {
                                    max-height: 500px;
                                    overflow-y: auto;
                                    background-color: white;
                                }
                                
                                .notification-item {
                                    padding: 16px 20px;
                                    border-bottom: 1px solid #f0f0f0;
                                    transition: all 0.2s ease;
                                    position: relative;
                                }
                                
                                .notification-item.unread {
                                    background-color: #f8faff;
                                    border-left: 4px solid #4e73df;
                                }
                                
                                .notification-item:last-child {
                                    border-bottom: none;
                                    border-radius: 0 0 8px 8px;
                                }
                                
                                .notification-item:hover {
                                    background-color: #f5f7ff;
                                }
                                
                                .notification-content {
                                    display: flex;
                                    gap: 15px;
                                }
                                
                                .notification-icon {
                                    width: 40px;
                                    height: 40px;
                                    border-radius: 50%;
                                    background-color: #e8f0fe;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    flex-shrink: 0;
                                    color: #4e73df;
                                    font-size: 1.1rem;
                                }
                                
                                .notification-details {
                                    flex-grow: 1;
                                }
                                
                                .notification-title {
                                    font-weight: 600;
                                    color: #2c3e50;
                                    margin-bottom: 5px;
                                    display: flex;
                                    align-items: center;
                                }
                                
                                .notification-message {
                                    color: #5a6a85;
                                    font-size: 0.9rem;
                                    margin-bottom: 8px;
                                }
                                
                                .notification-time {
                                    font-size: 0.75rem;
                                    color: #95a5a6;
                                    display: flex;
                                    align-items: center;
                                    gap: 5px;
                                }
                                
                                .notification-badge {
                                    background-color: #e74c3c;
                                    color: white;
                                    font-size: 0.65rem;
                                    padding: 2px 6px;
                                    border-radius: 10px;
                                    margin-left: 8px;
                                }
                                
                                .notification-actions {
                                    position: absolute;
                                    right: 20px;
                                    top: 50%;
                                    transform: translateY(-50%);
                                    display: flex;
                                    gap: 8px;
                                    opacity: 0;
                                    transition: opacity 0.2s;
                                }
                                
                                .notification-item:hover .notification-actions {
                                    opacity: 1;
                                }
                                
                                .notification-action-btn {
                                    width: 28px;
                                    height: 28px;
                                    border-radius: 50%;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    border: none;
                                    cursor: pointer;
                                    transition: all 0.2s;
                                }
                                
                                .mark-read-btn {
                                    background-color: #e8f5e9;
                                    color: #2e7d32;
                                }
                                
                                .mark-read-btn:hover {
                                    background-color: #c8e6c9;
                                }
                                
                                .delete-btn {
                                    background-color: #ffebee;
                                    color: #c62828;
                                }
                                
                                .delete-btn:hover {
                                    background-color: #ffcdd2;
                                }
                                
                                .empty-notifications {
                                    padding: 40px 20px;
                                    text-align: center;
                                    color: #95a5a6;
                                }
                                
                                .empty-icon {
                                    font-size: 3rem;
                                    margin-bottom: 15px;
                                    color: #bdc3c7;
                                }
                                
                                .empty-text {
                                    font-size: 1rem;
                                }
                                
                                /* Tool buttons */
                                .btn-notification-tool {
                                    display: flex;
                                    align-items: center;
                                    gap: 6px;
                                    padding: 6px 12px;
                                    border-radius: 6px;
                                    font-size: 0.85rem;
                                    transition: all 0.2s;
                                }
                                
                                .btn-notification-tool i {
                                    font-size: 0.9rem;
                                }
                                
                                .btn-refresh {
                                    background-color: #e3f2fd;
                                    color: #1565c0;
                                    border: 1px solid #bbdefb;
                                }
                                
                                .btn-refresh:hover {
                                    background-color: #bbdefb;
                                }
                                
                                .btn-mark-all {
                                    background-color: #e8f5e9;
                                    color: #2e7d32;
                                    border: 1px solid #c8e6c9;
                                }
                                
                                .btn-mark-all:hover {
                                    background-color: #c8e6c9;
                                }

                                .notification-details-container {
                                    margin-top: 10px;
                                    padding: 10px;
                                    background-color: #f8f9fa;
                                    border-radius: 6px;
                                    border-left: 3px solid #dee2e6;
                                }
                                
                                .detail-item {
                                    display: flex;
                                    margin-bottom: 6px;
                                    font-size: 0.85rem;
                                }
                                
                                .detail-label {
                                    font-weight: 600;
                                    color: #495057;
                                    min-width: 100px;
                                }
                                
                                .detail-value {
                                    color: #6c757d;
                                    flex-grow: 1;
                                }
                                
                                .detail-item:last-child {
                                    margin-bottom: 0;
                                }
                                
                                .toggle-details {
                                    color: #4e73df;
                                    font-size: 0.8rem;
                                    cursor: pointer;
                                    display: inline-block;
                                    margin-top: 8px;
                                }
                                
                                .toggle-details:hover {
                                    text-decoration: underline;
                                }
                                
                                .toggle-details i {
                                    margin-right: 4px;
                                    font-size: 0.7rem;
                                    transition: transform 0.2s;
                                }
                                
                                .details-expanded i {
                                    transform: rotate(90deg);
                                }
                            </style>

                            <div class="notifications-container">
                                <div class="notifications-header d-flex justify-content-between align-items-center">
                                    <div class="notifications-title">
                                        <i class="fas fa-bell"></i>
                                            Notifications
                                        @if(auth()->user()->unreadNotifications->count() > 0)
                                            <span class="notification-badge">{{ auth()->user()->unreadNotifications->count() }}</span>
                                        @endif
                                    </div>
                                    <div class="notifications-tools">
                                        <button class="btn-notification-tool btn-refresh refresh-notifications">
                                            <i class="fas fa-sync-alt"></i>
                                            <span>Refresh</span>
                                        </button>
                                        <button class="btn-notification-tool btn-mark-all mark-all-read">
                                            <i class="fas fa-check-double"></i>
                                            <span>Mark All</span>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="notifications-list">
                                    @forelse(auth()->user()->notifications as $notification)
                                        <div class="notification-item {{ $notification->unread() ? 'unread' : '' }}" 
                                            data-id="{{ $notification->id }}">
                                            <div class="notification-content">
                                                <div class="notification-icon">
                                                    @if(isset($notification->data['icon']))
                                                        <i class="fas fa-bell"></i>
                                                    @else
                                                        <i class="fas fa-bell"></i>
                                                    @endif
                                                </div>
                                                <div class="notification-details">
                                                    <div class="notification-title">
                                                        {{ $notification->data['title'] ?? 'Notification' }}
                                                        @if($notification->unread())
                                                            <span class="notification-badge">New</span>
                                                        @endif
                                                    </div>
                                                    <div class="notification-message">
                                                        {{ $notification->data['message'] }}
                                                    </div>
                                                    
                                                    @if(isset($notification->data['details']) && count($notification->data['details']) > 0)
                                                        <div class="toggle-details" onclick="toggleDetails(this)">
                                                            <i class="fas fa-chevron-right"></i>
                                                            <span>View Details</span>
                                                        </div>
                                                        
                                                        <div class="notification-details-container" style="display: none;">
                                                            @foreach($notification->data['details'] as $label => $value)
                                                                <div class="detail-item">
                                                                    <span class="detail-label">{{ ucfirst(str_replace('_', ' ', $label)) }}:</span>
                                                                    <span class="detail-value">
                                                                        @if(is_array($value))
                                                                            {{ json_encode($value) }}
                                                                        @else
                                                                            {{ $value }}
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                    
                                                    <div class="notification-time">
                                                        <i class="far fa-clock"></i>
                                                        {{ $notification->created_at->diffForHumans() }}
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="notification-actions">
                                                @if($notification->unread())
                                                    <button class="notification-action-btn mark-read-btn mark-as-read" title="Mark as read">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                @endif
                                                <button class="notification-action-btn delete-btn delete-notification" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="empty-notifications">
                                            <div class="empty-icon">
                                                <i class="far fa-bell-slash"></i>
                                            </div>
                                            <div class="empty-text">
                                                No notifications to display
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <!-- Performance Chart -->
                <div class="col-lg-8 mb-4">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0">Bible Apps Performance</h5>
                            </div>
                            <div class="chart-container">
                                <canvas id="activityChart" data-dates='{{ json_encode($dates) }}'
                                    data-categories='{{ json_encode($categoryData) }}'
                                    data-applications='{{ json_encode($appData) }}'></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="col-lg-4 mb-4">
                    <div class="card stat-card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Quick Actions</h5>
                            <div class="row g-3">
                                <div class="col-6">
                                    <a href="{{ url('admin/add_vidukathaigal') }}" class="btn btn-light quick-action-btn text-center">
                                        <i class="bi bi-plus-circle-fill text-primary fs-3 mb-2"></i>
                                        <h6 class="mb-0">Create Vidukathai</h6>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ url('admin/add_level') }}" class="btn btn-light quick-action-btn text-center">
                                        <i class="bi bi-folder-plus text-success fs-3 mb-2"></i>
                                        <h6 class="mb-0">Add Level</h6>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ url('admin/superadmin') }}" class="btn btn-light quick-action-btn text-center">
                                        <i class="bi bi-people-fill text-info fs-3 mb-2"></i>
                                        <h6 class="mb-0">Manage Users</h6>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ url('admin/profile_update') }}" class="btn btn-light quick-action-btn text-center">
                                        <i class="bi bi-gear-fill text-warning fs-3 mb-2"></i>
                                        <h6 class="mb-0">Settings</h6>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row">
                <div class="col-12">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0">Recent Activity</h5>
                                <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
                            </div>
                            
                            <div class="activity-feed" style="max-height: 500px;overflow-y: scroll;padding: 15px;">
                                @forelse($recentActivities as $key => $activity)
                                    @php
                                        $textColorClasses = ['primary', 'success', 'info', 'warning', 'danger'];
                                        $colorIndex = $key % count($textColorClasses);
                                        $textColorClass = $textColorClasses[$colorIndex];
                                        
                                        $url = $activity->url;
                                        $path = parse_url($url, PHP_URL_PATH);
                                        $segments = explode('/', trim($path, '/'));
                                        $lastSegment = $segments[count($segments) - 1] ?? '';
                                        $secondLastSegment = $segments[count($segments) - 2] ?? '';
                                        
                                        // Determine action sentence
                                        if (Str::startsWith($secondLastSegment, 'edit_') && is_numeric($lastSegment)) {
                                            $entity = Str::ucfirst(str_replace(['list', '_'], [' ', ' '], str_replace('edit_', '', $secondLastSegment)));
                                            $actionSentence = "Edited {$entity} (ID: {$lastSegment})";
                                        } elseif (Str::startsWith($lastSegment, 'add_')) {
                                            $entity = ucfirst(str_replace('add_', '', $lastSegment));
                                            $actionSentence = "Created new {$entity}";
                                        } elseif (in_array($lastSegment, ['login', 'logout'])) {
                                            $actionSentence = ucfirst($lastSegment);
                                        } else {
                                            $actionSentence = 'Viewed ' . ucfirst($lastSegment);
                                        }
                                        
                                        $iconMap = [
                                            'login' => 'bi-box-arrow-in-right',
                                            'logout' => 'bi-box-arrow-left',
                                            'edit' => 'bi-pencil-square',
                                            'add' => 'bi-plus-circle',
                                            'default' => 'bi-eye'
                                        ];
                                        
                                        $actionType = Str::contains($actionSentence, 'Edited') ? 'edit' : 
                                                    (Str::contains($actionSentence, 'Created') ? 'add' : 
                                                    (in_array(strtolower($actionSentence), ['login', 'logout']) ? strtolower($actionSentence) : 'default'));

                                        $icon = $iconMap[$actionType] ?? $iconMap['default'];

                                    @endphp
                                    
                                    <div class="activity-item">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <i class="bi {{ $icon }} me-2 text-{{ $textColorClass }}"></i>
                                                <strong class="text-{{ $textColorClass }}">{{ $actionSentence }}</strong>
                                            </div>
                                            <span class="activity-time">{{ \Carbon\Carbon::parse($activity->time)->diffForHumans() }}</span>
                                        </div>
                                        <div class="mt-2 ps-4">
                                            <small class="text-muted d-block">
                                                <i class="bi bi-person me-1"></i> {{ $activity->email ?? 'N/A' }}
                                            </small>
                                            <small class="text-muted">
                                                <i class="bi bi-link-45deg me-1"></i> 
                                                <a href="{{ $url ?? '#' }}" target="_blank" class="text-decoration-none">{{ Str::limit($url, 50) ?? 'N/A' }}</a>
                                            </small>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-4">
                                        <i class="bi bi-activity fs-1 text-muted"></i>
                                        <p class="text-muted mt-2">No recent activity found</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer id="footer" class="footer" style="background: #7367EF !important; color: #ffffff !important;">
        <div class="copyright text-center text-white py-3">
            &copy; <script>document.write(new Date().getFullYear())</script> Bible Apps. All rights reserved.
            <span class="mx-2">•</span>
            Developed by <strong>Gunasekar M</strong>
        </div>
    </footer>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- jQuery & Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>
        // Initialize Chart
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('activityChart').getContext('2d');
            const dates = JSON.parse(document.getElementById('activityChart').dataset.dates);
            const categoryData = JSON.parse(document.getElementById('activityChart').dataset.categories);
            const appData = JSON.parse(document.getElementById('activityChart').dataset.applications);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [
                        {
                            label: 'Bible Apps',
                            data: categoryData,
                            borderColor: '#4361ee',
                            backgroundColor: 'rgba(67, 97, 238, 0.1)',
                            tension: 0.3,
                            fill: true,
                            borderWidth: 2,
                            pointRadius: 3,
                            pointBackgroundColor: '#4361ee'
                        },
                        {
                            label: 'Levels',
                            data: appData,
                            borderColor: '#4cc9f0',
                            backgroundColor: 'rgba(76, 201, 240, 0.1)',
                            tension: 0.3,
                            fill: true,
                            borderWidth: 2,
                            pointRadius: 3,
                            pointBackgroundColor: '#4cc9f0'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: '#fff',
                            titleColor: '#000',
                            bodyColor: '#333',
                            borderColor: '#eee',
                            borderWidth: 1,
                            padding: 12,
                            usePointStyle: true
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false,
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                stepSize: 1
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });

        // Toastr notifications
        $(document).ready(function() {
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "5000"
            }
            
            @if (Session::has('error'))
                toastr.error("{{ Session::get('error') }}");
            @elseif (Session::has('message'))
                toastr.success("{{ Session::get('message') }}");
            @endif
        });

        // Preloader
        window.addEventListener('load', function() {
            const preloader = document.getElementById('pre-loader');
            preloader.style.opacity = '0';
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 500);
        });
    </script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mark notification as read when clicked
            document.querySelectorAll('.notification-item').forEach(item => {
                item.addEventListener('click', function(e) {
                    // Don't trigger if clicked on action buttons
                    if (e.target.closest('.notification-actions')) return;
                    
                    if (this.classList.contains('unread')) {
                        markAsRead(this.getAttribute('data-id'));
                    }
                });
            });

            // Mark as read button click
            document.querySelectorAll('.mark-as-read').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const notificationId = this.closest('.notification-item').getAttribute('data-id');
                    markAsRead(notificationId);
                });
            });

            // Delete notification button click
            document.querySelectorAll('.delete-notification').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const notificationItem = this.closest('.notification-item');
                    const notificationId = notificationItem.getAttribute('data-id');
                    
                    if (confirm('Are you sure you want to delete this notification?')) {
                        fetch(`/notifications/${notificationId}/delete`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json'
                            }
                        }).then(response => {
                            if (response.ok) {
                                notificationItem.remove();
                                updateUnreadCount();
                                showToast('Notification deleted successfully', 'success');
                            }
                        });
                    }
                });
            });

            // Mark all as read
            document.querySelector('.mark-all-read').addEventListener('click', function(e) {
                e.preventDefault();
                fetch('/notifications/mark-all-read', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                }).then(() => {
                    document.querySelectorAll('.notification-item.unread').forEach(item => {
                        item.classList.remove('unread');
                        item.querySelector('.badge')?.remove();
                    });
                    updateUnreadCount();
                    showToast('All notifications marked as read', 'success');
                });
            });

            // Refresh notifications
            document.querySelector('.refresh-notifications').addEventListener('click', function() {
                location.reload();
            });

            function markAsRead(notificationId) {
                fetch(`/notifications/${notificationId}/mark-as-read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                }).then(() => {
                    const item = document.querySelector(`.notification-item[data-id="${notificationId}"]`);
                    if (item) {
                        item.classList.remove('unread');
                        item.querySelector('.badge')?.remove();
                        item.querySelector('.mark-as-read')?.remove();
                        updateUnreadCount();
                    }
                });
            }

            function updateUnreadCount() {
                const unreadCount = document.querySelectorAll('.notification-item.unread').length;
                const counter = document.querySelector('.badge-new');
                
                if (unreadCount > 0) {
                    if (counter) {
                        counter.textContent = `${unreadCount} New`;
                    } else {
                        const title = document.querySelector('.notification-header h5');
                        title.innerHTML += ` <span class="badge-new">${unreadCount} New</span>`;
                    }
                } else if (counter) {
                    counter.remove();
                }
            }

            function showToast(message, type = 'success') {
                // Implement your toast notification system here
                // Example: using Bootstrap toasts
                console.log(`${type}: ${message}`);
            }
        });

        function toggleDetails(element) {
            const container = element.nextElementSibling;
            const isExpanded = container.style.display === 'block';
            
            if (isExpanded) {
                container.style.display = 'none';
                element.classList.remove('details-expanded');
                element.querySelector('span').textContent = 'View Details';
            } else {
                container.style.display = 'block';
                element.classList.add('details-expanded');
                element.querySelector('span').textContent = 'Hide Details';
            }
        }
    </script>
</body>
</html>