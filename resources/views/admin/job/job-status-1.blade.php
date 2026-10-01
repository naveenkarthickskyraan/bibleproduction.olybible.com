<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Bible App - Import Verse Info</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/skyraan-technologies.avif') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.0.96/css/materialdesignicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/preloader.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        :root {
            --primary: #5469d4 !important;
            --primary-light: #eceffe !important;
            --secondary: #0d123c !important;
            --accent: #f3a712 !important;
            --success: #3bb54a !important;
            --danger: #e74a3b !important;
            --light-gray: #f8f9fa !important;
            --medium-gray: #e9ecef !important;
            --dark-gray: #495057 !important;
            --white: #ffffff !important;
            --border-radius: 8px !important;
            --box-shadow: 0 0.25rem 1rem rgba(13, 18, 60, 0.08) !important;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif !important;
            background-color: #f5f7fb !important;
            color: var(--secondary) !important;
            line-height: 1.6 !important;
        }

        .main-container {
            max-width: 1400px !important;
            margin: 0 auto !important;
            padding: 2rem 1rem !important;
        }

        .btn {
            border-radius: var(--border-radius) !important;
            padding: 0.625rem 1.25rem !important;
            font-weight: 600 !important;
            transition: all 0.2s !important;
        }

        .btn-primary {
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
        }

        .btn-primary:hover {
            background-color: #4559b3 !important;
            border-color: #4559b3 !important;
        }

        .btn-outline-primary {
            color: var(--primary) !important;
            border-color: var(--primary) !important;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary) !important;
            color: var(--white) !important;
        }

        .card {
            border: none !important;
            border-radius: var(--border-radius) !important;
            box-shadow: var(--box-shadow) !important;
            margin-bottom: 1.5rem !important;
            overflow: hidden !important;
            transition: transform 0.2s, box-shadow 0.2s !important;
        }

        .card:hover {
            transform: translateY(-3px) !important;
            box-shadow: 0 0.5rem 1.5rem rgba(13, 18, 60, 0.12) !important;
        }

        .card-header {
            background-color: var(--white) !important;
            padding: 1.25rem 1.5rem !important;
            font-weight: 600 !important;
            color: var(--secondary) !important;
            border-bottom: 1px solid var(--medium-gray) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
        }

        .card-header-icon {
            margin-right: 10px !important;
            color: var(--primary) !important;
        }

        /* Progress Bar Styles */
        .progress {
            background-color: #e9ecef;
            border-radius: 10px;
            overflow: visible;
            height: 25px;
        }
        
        .progress-bar {
            border-radius: 10px;
            transition: width 0.5s ease;
            position: relative;
            font-size: 0.9rem;
            line-height: 25px;
        }
        
        .progress-bar::after {
            content: '';
            position: absolute;
            top: -5px;
            right: -5px;
            width: 15px;
            height: 15px;
            background-color: inherit;
            border-radius: 50%;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .progress-bar:hover::after {
            opacity: 0.8;
        }
        
        #progressDetails {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
        
        #resultsCard, #errorCard {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border: none;
        }
        
        #submitBtn {
            transition: all 0.3s ease;
        }
        
        .card-header {
            border-bottom: none;
        }

        /* Status Badges */
        .badge-ready {
            background-color: #6c757d;
            color: white;
        }

        .badge-processing {
            background-color: #17a2b8;
            color: white;
        }

        .badge-completed {
            background-color: #28a745;
            color: white;
        }

        .badge-failed {
            background-color: #dc3545;
            color: white;
        }

        .badge-paused {
            background-color: #ffc107;
            color: #212529;
        }

        /* Alert Styles */
        .alert-container {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 9999;
            width: 350px;
        }

        /* Info Box Styles */
        .info-box {
            margin-bottom: 1rem;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            transition: all 0.3s ease;
        }

        .info-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1.5rem rgba(13, 18, 60, 0.15);
        }

        .info-box-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            border-radius: var(--border-radius);
            font-size: 1.5rem;
        }

        .info-box-content {
            padding: 0.5rem 1rem;
        }

        .info-box-text {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .info-box-number {
            font-size: 1.2rem;
            font-weight: 600;
        }

        /* Log Styles */
        .log-entry {
            font-size: 0.85rem;
            margin-bottom: 0.25rem;
            word-wrap: break-word;
            padding: 0.25rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .log-entry:last-child {
            border-bottom: none;
        }

        .log-entry.info {
            color: #17a2b8;
        }

        .log-entry.success {
            color: #28a745;
        }

        .log-entry.warning {
            color: #ffc107;
        }

        .log-entry.error {
            color: #dc3545;
        }

        /* Activity Log Container */
        #activityLog {
            background-color: #1e1e1e;
            border-radius: var(--border-radius);
            padding: 1rem;
            height: 200px;
            overflow-y: auto;
            font-family: 'Courier New', monospace;
            border: 1px solid #444;
        }

        /* Version Progress Bar */
        #versionProgressContainer {
            margin-top: 0.5rem;
        }

        /* Button Group Styles */
        .card-tools .btn {
            margin-left: 0.5rem;
            min-width: 100px;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .card-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .card-tools {
                margin-top: 1rem;
                width: 100%;
            }
            
            .card-tools .btn {
                margin: 0.25rem;
                width: calc(50% - 0.5rem);
            }
            
            .info-box {
                margin-bottom: 0.5rem;
            }
        }
    </style>
</head>

<body>
    @include('admin.navbar')
    <!-- ======= Sidebar ======= -->
    @include('admin.sidebar')

    <div id="pre-loader" class="pre-loader is-active">
        <div class="loader"></div>
    </div>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1><i class="fa fa-coins"></i>&nbsp;&#11162;&nbsp;Verse List (Import Form)</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('admin/verse_list') }}">Verse List</a></li>
                    <li class="breadcrumb-item active">Import Verses</li>
                </ol>
            </nav>
        </div>

        <!-- Flash Messages -->
        @if (Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <div>{{ Session::get('error') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (Session::has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-2"></i>
                    <div>{{ Session::get('message') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0" style="color: #7367EF !important;">
                            <i class="fas fa-file-import me-2"></i>Bible Word Check Processor
                        </h4>
                        <span id="importStatusBadge" class="badge badge-ready">Ready</span>
                    </div>

                    <div class="card-body">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h3 class="card-title">Bible Word Check Job Status</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-primary" id="startJobBtn">
                                            <i class="fas fa-play"></i> Start Job
                                        </button>
                                        <button type="button" class="btn btn-danger" id="stopJobBtn" style="display: none;">
                                            <i class="fas fa-stop"></i> Stop Job
                                        </button>
                                        <button type="button" class="btn btn-warning" id="pauseJobBtn" style="display: none;">
                                            <i class="fas fa-pause"></i> Pause
                                        </button>
                                        <button type="button" class="btn btn-success" id="resumeJobBtn" style="display: none;">
                                            <i class="fas fa-play"></i> Resume
                                        </button>
                                        <button type="button" class="btn btn-secondary" id="resetJobBtn">
                                            <i class="fas fa-redo"></i> Reset
                                        </button>
                                        <button type="button" class="btn btn-info" id="viewLogsBtn">
                                            <i class="fas fa-file-alt"></i> View Logs
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!-- Job Status Overview -->
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-info">
                                                    <i class="fas fa-info-circle"></i>
                                                </span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Status</span>
                                                    <span class="info-box-number" id="jobStatus">{{ $status['status'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-success">
                                                    <i class="fas fa-percentage"></i>
                                                </span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Progress</span>
                                                    <span class="info-box-number" id="jobProgress">{{ $status['progress'] }}%</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-warning">
                                                    <i class="fas fa-book"></i>
                                                </span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Versions Processed</span>
                                                    <span class="info-box-number">
                                                        <span id="processedVersions">{{ $status['processed_versions'] }}</span>
                                                        /
                                                        <span id="totalVersions">{{ $status['total_versions'] }}</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-secondary">
                                                    <i class="fas fa-clock"></i>
                                                </span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Last Updated</span>
                                                    <span class="info-box-number text-sm" id="lastUpdated">{{ $status['last_updated'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Progress Bar -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <div class="progress progress-lg">
                                                <div class="progress-bar" 
                                                    id="progressBar" 
                                                    role="progressbar" 
                                                    style="width: {{ $status['progress'] }}%"
                                                    aria-valuenow="{{ $status['progress'] }}" 
                                                    aria-valuemin="0" 
                                                    aria-valuemax="100">
                                                    {{ $status['progress'] }}%
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Current Processing Details -->
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="card-title">Current Version</h5>
                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text">
                                                        <strong>Version:</strong> <span id="currentVersion">{{ $status['current_version'] }}</span>
                                                    </p>
                                                    <p class="card-text">
                                                        <strong>Verses Processed:</strong> 
                                                        <span id="currentVerseCount">{{ $status['current_verse_count'] }}</span>
                                                        /
                                                        <span id="totalVersesInVersion">{{ $status['total_verses_in_version'] }}</span>
                                                    </p>
                                                    @if($status['total_verses_in_version'] > 0)
                                                    <div class="progress mt-2" id="versionProgressContainer">
                                                        <div class="progress-bar bg-info" 
                                                            id="versionProgressBar"
                                                            role="progressbar" 
                                                            style="width: {{ $status['total_verses_in_version'] > 0 ? ($status['current_verse_count'] / $status['total_verses_in_version']) * 100 : 0 }}%">
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="card-title">Job Information</h5>
                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text">
                                                        <strong>Job Type:</strong> Bible Word Check (Case-Sensitive Exact Match)
                                                    </p>
                                                    <p class="card-text">
                                                        <strong>Matching Method:</strong> Exact word boundaries with case sensitivity
                                                    </p>
                                                    <p class="card-text">
                                                        <strong>Storage:</strong> Session-based tracking
                                                    </p>
                                                    <p class="card-text">
                                                        <strong>Estimated Time Remaining:</strong> <span id="timeRemaining">Calculating...</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Error Display -->
                                    @if($status['error'])
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <div class="alert alert-danger" id="errorAlert">
                                                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                                                <span id="errorMessage">{{ $status['error'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="row mb-4" style="display: none;" id="errorContainer">
                                        <div class="col-12">
                                            <div class="alert alert-danger" id="errorAlert">
                                                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                                                <span id="errorMessage"></span>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Success Message -->
                                    <div class="row mb-4" style="display: none;" id="successContainer">
                                        <div class="col-12">
                                            <div class="alert alert-success" id="successAlert">
                                                <h5><i class="icon fas fa-check"></i> Success!</h5>
                                                <span id="successMessage">Bible word check job completed successfully!</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Real-time Log -->
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="card-title">Activity Log</h5>
                                                    <div class="card-tools">
                                                        <button type="button" class="btn btn-tool" id="clearLogBtn">
                                                            <i class="fas fa-trash"></i> Clear
                                                        </button>
                                                        <button type="button" class="btn btn-tool" id="exportLogsBtn">
                                                            <i class="fas fa-download"></i> Export
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div id="activityLog" class="bg-dark text-light p-3" style="height: 200px; overflow-y: auto; font-family: monospace;">
                                                        <div class="log-entry info">{{ now() }} - System ready</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright"></div>
    </footer>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Setup CSRF token for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Handle AJAX errors globally
            $(document).ajaxError(function(event, xhr) {
                if (xhr.status === 419) { // CSRF token mismatch
                    addLogEntry('Session expired. Please refresh the page.', 'error');
                    setTimeout(() => location.reload(), 2000);
                }
            });

            let pollingInterval;
            let isPolling = false;
            let startTime;
            let lastProgress = 0;
            let lastUpdateTime = Date.now();
            let jobIsPaused = false;

            // Initialize status badge
            updateStatusBadge('{{ $status["status"] }}');

            // Function to add log entry with type
            function addLogEntry(message, type = 'info') {
                const timestamp = new Date().toLocaleString();
                const logEntry = $(`<div class="log-entry ${type}">${timestamp} - ${message}</div>`);
                $('#activityLog').append(logEntry);
                $('#activityLog').scrollTop($('#activityLog')[0].scrollHeight);
            }

            // Function to update status badge
            function updateStatusBadge(status) {
                const badge = $('#importStatusBadge');
                badge.removeClass('badge-ready badge-processing badge-completed badge-failed badge-paused');
                
                switch(status.toLowerCase()) {
                    case 'ready':
                        badge.addClass('badge-ready').text('Ready');
                        break;
                    case 'in progress':
                    case 'starting...':
                        badge.addClass('badge-processing').text('Processing');
                        break;
                    case 'completed':
                        badge.addClass('badge-completed').text('Completed');
                        break;
                    case 'failed':
                        badge.addClass('badge-failed').text('Failed');
                        break;
                    case 'paused':
                        badge.addClass('badge-paused').text('Paused');
                        break;
                    default:
                        badge.addClass('badge-ready').text(status);
                }
            }

            // Function to estimate time remaining
            function estimateTimeRemaining(progress) {
                if (!startTime || progress <= 0 || progress >= 100) {
                    return 'Calculating...';
                }
                
                const currentTime = Date.now();
                const elapsedTime = (currentTime - startTime) / 1000; // in seconds
                const totalEstimatedTime = elapsedTime / (progress / 100);
                const remainingTime = totalEstimatedTime - elapsedTime;
                
                // Convert seconds to hours, minutes, seconds
                const hours = Math.floor(remainingTime / 3600);
                const minutes = Math.floor((remainingTime % 3600) / 60);
                const seconds = Math.floor(remainingTime % 60);
                
                let timeString = '';
                if (hours > 0) timeString += `${hours}h `;
                if (minutes > 0 || hours > 0) timeString += `${minutes}m `;
                timeString += `${seconds}s`;
                
                return timeString.trim();
            }

            // Function to update UI with status data
            function updateUI(data) {
                // Update basic fields
                $('#jobStatus').text(data.status);
                $('#jobProgress').text(data.progress + '%');
                $('#processedVersions').text(data.processed_versions);
                $('#totalVersions').text(data.total_versions);
                $('#lastUpdated').text(data.last_updated);
                $('#currentVersion').text(data.current_version);
                $('#currentVerseCount').text(data.current_verse_count);
                $('#totalVersesInVersion').text(data.total_verses_in_version);

                // Update status badge
                updateStatusBadge(data.status);

                // Update progress bars with animation
                $('#progressBar').animate({ width: data.progress + '%' }, 500, function() {
                    $(this).attr('aria-valuenow', data.progress).text(data.progress + '%');
                });
                
                if (data.total_verses_in_version > 0) {
                    const versionProgress = (data.current_verse_count / data.total_verses_in_version) * 100;
                    $('#versionProgressBar').animate({ width: versionProgress + '%' }, 500);
                }

                // Update time remaining estimate
                if (data.status === 'In Progress') {
                    if (lastProgress !== data.progress) {
                        lastProgress = data.progress;
                        lastUpdateTime = Date.now();
                    }
                    $('#timeRemaining').text(estimateTimeRemaining(data.progress));
                } else {
                    $('#timeRemaining').text('N/A');
                }

                // Handle error display
                if (data.error) {
                    $('#errorMessage').text(data.error);
                    $('#errorContainer').show();
                    addLogEntry(data.error, 'error');
                } else {
                    $('#errorContainer').hide();
                }

                // Handle success display
                if (data.status === 'Completed') {
                    $('#successContainer').show();
                    stopPolling();
                    updateButtonVisibility('Completed');
                    addLogEntry('Job completed successfully!', 'success');
                } else {
                    $('#successContainer').hide();
                }

                // Handle failed status
                if (data.status === 'Failed') {
                    stopPolling();
                    updateButtonVisibility('Failed');
                }

                // Update button visibility
                updateButtonVisibility(data.status);

                // Update progress bar color based on status
                const progressBar = $('#progressBar');
                progressBar.removeClass('bg-success bg-danger bg-info bg-warning');
                
                if (data.status === 'Completed') {
                    progressBar.addClass('bg-success');
                } else if (data.status === 'Failed') {
                    progressBar.addClass('bg-danger');
                } else if (data.status === 'In Progress') {
                    progressBar.addClass('bg-info');
                } else if (data.status === 'Paused') {
                    progressBar.addClass('bg-warning');
                }
            }

            // Function to update button visibility based on status
            function updateButtonVisibility(status) {
                const statusLower = status.toLowerCase();
                
                $('#startJobBtn').toggle(statusLower === 'ready' || statusLower === 'failed');
                $('#stopJobBtn').toggle(statusLower === 'in progress' || statusLower === 'starting...');
                $('#pauseJobBtn').toggle(statusLower === 'in progress' || statusLower === 'starting...');
                $('#resumeJobBtn').toggle(statusLower === 'paused');
                $('#resetJobBtn').toggle(true); // Always show reset button
                $('#viewLogsBtn').toggle(true); // Always show view logs button
            }

            // Function to start polling
            function startPolling() {
                if (isPolling) return;
                
                isPolling = true;
                startTime = Date.now();
                lastProgress = 0;
                addLogEntry('Started polling for job status updates', 'info');
                
                // Initial request
                fetchJobStatus();
                
                // Start interval
                pollingInterval = setInterval(fetchJobStatus, 2000); // Poll every 2 seconds
            }

            // Function to fetch job status
            function fetchJobStatus() {
                $.get('{{ route("job.status.api") }}')
                    .done(function(data) {
                        updateUI(data);
                    })
                    .fail(function(xhr) {
                        addLogEntry('Failed to fetch job status: ' + xhr.statusText, 'error');
                        if (xhr.status === 419) { // CSRF token mismatch
                            addLogEntry('Session expired. Please refresh the page.', 'error');
                            stopPolling();
                        }
                    });
            }

            // Function to stop polling
            function stopPolling() {
                if (pollingInterval) {
                    clearInterval(pollingInterval);
                    isPolling = false;
                    addLogEntry('Stopped polling for job status updates', 'info');
                }
            }

            // Start job button click
            $('#startJobBtn').click(function() {
                const btn = $(this);
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Starting...');
                
                $.post('{{ route("job.start") }}')
                    .done(function(response) {
                        if (response.success) {
                            addLogEntry('Job started successfully', 'success');
                            startPolling();
                            updateButtonVisibility('In Progress');
                        } else {
                            addLogEntry('Failed to start job: ' + response.message, 'error');
                        }
                    })
                    .fail(function(xhr) {
                        const response = xhr.responseJSON;
                        addLogEntry('Failed to start job: ' + (response ? response.message : 'Unknown error'), 'error');
                    })
                    .always(function() {
                        btn.prop('disabled', false).html('<i class="fas fa-play"></i> Start Job');
                    });
            });

            // Stop job button click
            $('#stopJobBtn').click(function() {
                const btn = $(this);
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Stopping...');
                
                $.post('{{ route("job.stop") }}')
                    .done(function(response) {
                        if (response.success) {
                            addLogEntry('Job stop signal sent', 'warning');
                            stopPolling();
                            updateButtonVisibility('Stopped');
                        } else {
                            addLogEntry('Failed to stop job: ' + response.message, 'error');
                        }
                    })
                    .fail(function(xhr) {
                        const response = xhr.responseJSON;
                        addLogEntry('Failed to stop job: ' + (response ? response.message : 'Unknown error'), 'error');
                    })
                    .always(function() {
                        btn.prop('disabled', false).html('<i class="fas fa-stop"></i> Stop Job');
                    });
            });

            // Pause job button click
            $('#pauseJobBtn').click(function() {
                const btn = $(this);
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Pausing...');
                
                $.post('{{ route("job.stop") }}')
                    .done(function(response) {
                        if (response.success) {
                            addLogEntry('Job paused successfully', 'warning');
                            updateButtonVisibility('Paused');
                            jobIsPaused = true;
                        } else {
                            addLogEntry('Failed to pause job: ' + response.message, 'error');
                        }
                    })
                    .fail(function(xhr) {
                        const response = xhr.responseJSON;
                        addLogEntry('Failed to pause job: ' + (response ? response.message : 'Unknown error'), 'error');
                    })
                    .always(function() {
                        btn.prop('disabled', false).html('<i class="fas fa-pause"></i> Pause');
                    });
            });

            // Resume job button click
            $('#resumeJobBtn').click(function() {
                const btn = $(this);
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Resuming...');
                
                $.post('{{ route("job.stop") }}')
                    .done(function(response) {
                        if (response.success) {
                            addLogEntry('Job resumed successfully', 'success');
                            updateButtonVisibility('In Progress');
                            jobIsPaused = false;
                        } else {
                            addLogEntry('Failed to resume job: ' + response.message, 'error');
                        }
                    })
                    .fail(function(xhr) {
                        const response = xhr.responseJSON;
                        addLogEntry('Failed to resume job: ' + (response ? response.message : 'Unknown error'), 'error');
                    })
                    .always(function() {
                        btn.prop('disabled', false).html('<i class="fas fa-play"></i> Resume');
                    });
            });

            // Reset job button click
            $('#resetJobBtn').click(function() {
                if (!confirm('Are you sure you want to reset the job? This will clear all progress.')) {
                    return;
                }
                
                const btn = $(this);
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Resetting...');
                
                $.post('{{ route("job.reset") }}')
                    .done(function(response) {
                        if (response.success) {
                            addLogEntry('Job status reset successfully', 'info');
                            stopPolling();
                            location.reload(); // Reload to reset UI
                        } else {
                            addLogEntry('Failed to reset job: ' + response.message, 'error');
                        }
                    })
                    .fail(function(xhr) {
                        const response = xhr.responseJSON;
                        addLogEntry('Failed to reset job: ' + (response ? response.message : 'Unknown error'), 'error');
                    })
                    .always(function() {
                        btn.prop('disabled', false).html('<i class="fas fa-redo"></i> Reset');
                    });
            });

            // Clear log button click
            $('#clearLogBtn').click(function() {
                $('#activityLog').empty();
                addLogEntry('Log cleared', 'info');
            });

            // Export logs button click
            $('#exportLogsBtn').click(function() {
                const logs = $('#activityLog').text();
                const blob = new Blob([logs], { type: 'text/plain' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'bible-word-check-logs-' + new Date().toISOString().slice(0, 10) + '.txt';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
                addLogEntry('Logs exported', 'success');
            });

            // View logs button click
            $('#viewLogsBtn').click(function() {
                const btn = $(this);
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Loading...');
                
                $.get('{{ route("job.logs") }}')
                    .done(function(response) {
                        if (response.success && response.logs) {
                            $('#activityLog').empty();
                            response.logs.forEach(function(log) {
                                const logType = log.includes('ERROR') ? 'error' : 
                                              log.includes('WARNING') ? 'warning' : 
                                              log.includes('SUCCESS') ? 'success' : 'info';
                                $('#activityLog').append('<div class="log-entry ' + logType + '">' + log.trim() + '</div>');
                            });
                            addLogEntry('Job logs loaded successfully', 'success');
                        } else {
                            addLogEntry('No logs found or failed to load logs', 'warning');
                        }
                    })
                    .fail(function(xhr) {
                        const response = xhr.responseJSON;
                        addLogEntry('Failed to load logs: ' + (response ? response.message : 'Unknown error'), 'error');
                    })
                    .always(function() {
                        btn.prop('disabled', false).html('<i class="fas fa-file-alt"></i> View Logs');
                    });
            });

            // Auto-start polling if job is in progress
            const currentStatus = '{{ $status["status"] }}';
            if (currentStatus === 'In Progress' || currentStatus === 'Starting...') {
                startPolling();
                updateButtonVisibility(currentStatus);
            } else if (currentStatus === 'Paused') {
                jobIsPaused = true;
                updateButtonVisibility(currentStatus);
            }

            // Stop polling when page is unloaded
            $(window).on('beforeunload', function() {
                stopPolling();
            });

            // Initialize Select2
            $('.select2').select2({
                width: '100%'
            });
            
            // Preloader
            window.addEventListener('load', function() {
                const preloader = document.getElementById('pre-loader');
                preloader.style.opacity = '0';
                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 500);
            });
        });
    </script>
</body>
</html>