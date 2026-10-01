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
    
    <link href="{{ asset('assets/css/job.css') }}" rel="stylesheet">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        /* Add to your CSS file */
        .status-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 6px;
        }

        .status-indicator.ready {
            background-color: #6c757d; /* Gray */
        }

        .status-indicator.processing {
            background-color: #0dcaf0; /* Info blue */
            animation: pulse 1.5s infinite;
        }

        .status-indicator.completed {
            background-color: #198754; /* Success green */
        }

        .status-indicator.failed {
            background-color: #dc3545; /* Danger red */
        }

        .status-indicator.stopped {
            background-color: #ffc107; /* Warning yellow */
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
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
            <h1><i class="fa fa-coins"></i>&nbsp;&#11162;&nbsp;Bible Word Check Job List (Dashboard - Home)</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('admin/verse_list') }}">Verse List</a></li>
                    <li class="breadcrumb-item active">Bible Word Check Job</li>
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <i class="fas fa-cogs"></i>
                            Bible Word Check Job Control Panel
                        </h4>
                        <div class="d-flex align-items-center">
                            <span class="status-indicator ready" id="statusIndicator"></span>
                            <span id="importStatusBadge" class="badge bg-light">Ready</span>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5><i class="fas fa-play-circle"></i> Job Controls</h5>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-success" id="startJobBtn">
                                        <i class="fas fa-play"></i> Start Job
                                    </button>
                                    <button type="button" class="btn btn-danger" id="stopJobBtn" style="display: none;">
                                        <i class="fas fa-stop"></i> Stop Job
                                    </button>
                                    <button type="button" class="btn btn-warning" id="resetJobBtn">
                                        <i class="fas fa-redo"></i> Reset
                                    </button>
                                    <button type="button" class="btn btn-info" id="viewLogsBtn">
                                        <i class="fas fa-file-alt"></i> View Logs
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Control Buttons -->
                        <div class="activity-log-note">
                            <p>
                                Every action, error, success, and process will be logged and displayed in the activity log box.
                                If there is any status update, it will be stored and shown here. The log view will then refresh
                                to enable the <strong>View Logs <i class="fa-solid fa-arrow-up-right-from-square"></i></strong> button to display the latest logs.
                            </p>
                            <small class="log-note-hint">Note: Activity logs auto-refresh to show real-time updates.</small>
                        </div>

                        <style>
                            .activity-log-note {
                                background: #e9f7fd;
                                border-left: 5px solid #3498db;
                                padding: 15px 20px;
                                margin: 20px 0;
                                border-radius: 6px;
                                box-shadow: 0 2px 6px rgba(0,0,0,0.05);
                                color: #333;
                                font-size: 14px;
                                line-height: 22px;
                            }

                            .activity-log-note p {
                                margin: 0 0 8px;
                                font-weight: 500;
                                color: #2c3e50;
                            }

                            .activity-log-note strong {
                                color: #e74c3c;
                            }

                            .log-note-hint {
                                font-size: 12px;
                                color: #666;
                            }
                        </style>

                        <!-- Job Status Overview -->
                        <div class="row mb-4">
                            <div class="col-md-3 mb-3">
                                <div class="info-box">
                                    <div class="info-box-icon bg-info">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Status</span>
                                        <span class="info-box-number" id="jobStatus">Idle</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="info-box">
                                    <div class="info-box-icon bg-success">
                                        <i class="fas fa-percentage"></i>
                                    </div>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Progress</span>
                                        <span class="info-box-number" id="jobProgress">0%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="info-box">
                                    <div class="info-box-icon bg-warning">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Versions Processed</span>
                                        <span class="info-box-number">
                                            <span id="processedVersions">0</span>
                                            /
                                            <span id="totalVersions">0</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="info-box">
                                    <div class="info-box-icon bg-secondary">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Last Updated</span>
                                        <span class="info-box-number text-sm" id="lastUpdated">Never</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="mb-2">Overall Progress</h6>
                                <div class="progress progress-lg">
                                    <div class="progress-bar" 
                                        id="progressBar" 
                                        role="progressbar" 
                                        style="width: 0%"
                                        aria-valuenow="0" 
                                        aria-valuemin="0" 
                                        aria-valuemax="100">
                                        0%
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Current Processing Details -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <div class="card version-progress-card">
                                    <div class="card-header">
                                        <h5><i class="fas fa-book-open"></i> Current Version</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-2">
                                            <strong>Version:</strong> <span id="currentVersion">None</span>
                                        </p>
                                        <p class="mb-3">
                                            <strong>Verses Processed:</strong> 
                                            <span id="currentVerseCount">0</span>
                                            /
                                            <span id="totalVersesInVersion">0</span>
                                        </p>
                                        <div class="progress">
                                            <div class="progress-bar bg-info" 
                                                id="versionProgressBar"
                                                role="progressbar" 
                                                style="width: 0%">
                                                0%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card job-info-card">
                                    <div class="card-header">
                                        <h5><i class="fas fa-info-circle"></i> Job Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-2">
                                            <strong>Job Type:</strong> Bible Word Check
                                        </p>
                                        <p class="mb-2">
                                            <strong>Method:</strong> Case-Sensitive Exact Match
                                        </p>
                                        <p class="mb-2">
                                            <strong>Boundaries:</strong> Word boundaries with case sensitivity
                                        </p>
                                        <p class="mb-0">
                                            <strong>Storage:</strong> Session-based tracking
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Error Display -->
                        <div class="row mb-4" style="display: none;" id="errorContainer">
                            <div class="col-12">
                                <div class="alert alert-danger" id="errorAlert">
                                    <h5><i class="fas fa-exclamation-triangle"></i> Error Occurred!</h5>
                                    <span id="errorMessage"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Success Message -->
                        <div class="row mb-4" style="display: none;" id="successContainer">
                            <div class="col-12">
                                <div class="alert alert-success" id="successAlert">
                                    <h5><i class="fas fa-check-circle"></i> Job Completed!</h5>
                                    <span id="successMessage">Bible word check job completed successfully!</span>
                                </div>
                            </div>
                        </div>

                        <!-- Activity Log -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5><i class="fas fa-terminal"></i> Activity Log</h5>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-outline-secondary" id="clearLogBtn">
                                                <i class="fas fa-trash"></i> Clear Log
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="activityLog" style="height: 300px; overflow-y: auto;">
                                            <div class="log-entry">System initialized - Ready to start job</div>
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
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {

            // Set up CSRF token for AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Global AJAX error handler for CSRF issues
            $(document).ajaxError(function(event, xhr) {
                if (xhr.status === 419) {
                    addLogEntry('Session expired. Please refresh the page.');
                    setTimeout(() => location.reload(), 2000);
                }
            });

            let pollingInterval;
            let isPolling = false;

            // Function to log messages
            function addLogEntry(message) {
                const timestamp = new Date().toLocaleString();
                const logEntry = `<div class="log-entry">${timestamp} - ${message}</div>`;
                $('#activityLog').append(logEntry);
                $('#activityLog').scrollTop($('#activityLog')[0].scrollHeight);
            }

            // Update UI with job status
            function updateUI(data) {
                $('#jobStatus').text(data.status);
                $('#jobProgress').text(data.progress + '%');
                $('#processedVersions').text(data.processed_versions);
                $('#totalVersions').text(data.total_versions);
                $('#lastUpdated').text(data.last_updated);
                $('#currentVersion').text(data.current_version);
                $('#currentVerseCount').text(data.current_verse_count);
                $('#totalVersesInVersion').text(data.total_verses_in_version);

                $('#progressBar')
                    .css('width', data.progress + '%')
                    .attr('aria-valuenow', data.progress)
                    .text(data.progress + '%');

                if (data.total_verses_in_version > 0) {
                    const versionProgress = (data.current_verse_count / data.total_verses_in_version) * 100;
                    const rounded = versionProgress.toFixed(2);
                    $('#versionProgressBar')
                        .css('width', rounded + '%')
                        .attr('aria-valuenow', rounded)
                        .text(rounded + '%');
                }

                if (data.error) {
                    $('#errorMessage').text(data.error);
                    $('#errorContainer').show();
                } else {
                    $('#errorContainer').hide();
                }

                if (data.status === 'Completed') {
                    $('#successContainer').show();
                    stopPolling();
                } else {
                    $('#successContainer').hide();
                }

                if (data.status === 'Failed') {
                    stopPolling();
                }

                updateButtonVisibility(data.status);

                // Progress bar color by status
                const progressBar = $('#progressBar');
                progressBar.removeClass('bg-success bg-danger bg-warning bg-info');

                if (data.status === 'Completed') {
                    progressBar.addClass('bg-success');
                } else if (data.status === 'Failed') {
                    progressBar.addClass('bg-danger');
                } else if (data.status === 'In Progress') {
                    progressBar.addClass('bg-info');
                }
            }

            // Start polling function
            function startPolling() {
                if (isPolling) return;

                isPolling = true;
                addLogEntry('Started polling for job status updates');

                pollingInterval = setInterval(() => {
                    $.get('{{ route("job.status.api") }}')
                        .done(updateUI)
                        .fail(() => addLogEntry('Failed to fetch job status'));
                }, 2000);
            }

            // Stop polling
            function stopPolling() {
                if (pollingInterval) {
                    clearInterval(pollingInterval);
                    isPolling = false;
                    addLogEntry('Stopped polling for job status updates');
                }
            }

            // Button visibility control
            function updateButtonVisibility(status) {
                if (status === 'In Progress' || status === 'Starting...') {
                    $('#startJobBtn').hide();
                    $('#stopJobBtn').show();
                } else {
                    $('#startJobBtn').show();
                    $('#stopJobBtn').hide();
                }
            }

            // Start job button click
            $('#startJobBtn').click(function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will start the Bible Word Check job. It may take time.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, start it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const btn = $(this);
                        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Starting...');

                        $.post('{{ route("job.start") }}')
                            .done(response => {
                                if (response.success) {
                                    addLogEntry('Job started successfully');
                                    startPolling();
                                    updateButtonVisibility('In Progress');
                                    Swal.fire('Started!', 'The job has been started.', 'success');
                                } else {
                                    addLogEntry('Failed to start job: ' + response.message);
                                    Swal.fire('Error!', response.message, 'error');
                                }
                            })
                            .fail(xhr => {
                                const response = xhr.responseJSON;
                                addLogEntry('Failed to start job: ' + (response?.message || 'Unknown error'));
                                Swal.fire('Error!', response?.message || 'Unknown error', 'error');
                            })
                            .always(() => {
                                btn.prop('disabled', false).html('<i class="fas fa-play"></i> Start Job');
                            });
                    }
                });
            });

            // Stop job button click
            $('#stopJobBtn').click(function() {
                const btn = $(this);
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Stopping...');

                $.post('{{ route("job.stop") }}')
                    .done(response => {
                        if (response.success) {
                            addLogEntry('Job stop signal sent');
                            stopPolling();
                            updateButtonVisibility('Stopped');
                        } else {
                            addLogEntry('Failed to stop job: ' + response.message);
                            Swal.fire('Error!', 'Failed to stop job: ' + response.message, 'error');

                        }
                    })
                    .fail(xhr => {
                        const response = xhr.responseJSON;
                        addLogEntry('Failed to stop job: ' + (response?.message || 'Unknown error'));
                        Swal.fire('Error!', 'Failed to stop job: ' + (response?.message || 'Unknown error'), 'error');
                    })
                    .always(() => {
                        btn.prop('disabled', false).html('<i class="fas fa-stop"></i> Stop Job');
                    });
            });

            // Reset job button click
            $('#resetJobBtn').click(function() {
                const btn = $(this);
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Resetting...');

                $.post('{{ route("job.reset") }}')
                    .done(response => {
                        if (response.success) {
                            addLogEntry('Job reset successfully');
                            stopPolling();
                            location.reload();
                        } else {
                            addLogEntry('Failed to reset job: ' + response.message);
                            Swal.fire('Error!', 'Failed to reset job: ' + response.message, 'error');
                        }
                    })
                    .fail(xhr => {
                        const response = xhr.responseJSON;
                        addLogEntry('Failed to reset job: ' + (response?.message || 'Unknown error'));
                            Swal.fire('Error!', 'Failed to reset job: ' + (response?.message || 'Unknown error'), 'error');
                    })
                    .always(() => {
                        btn.prop('disabled', false).html('<i class="fas fa-reset"></i> Reset');
                    });
            });

            // View logs button click
            $('#viewLogsBtn').click(function() {
                const btn = $(this);
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Loading...');

                $.get('{{ route("job.logs") }}')
                    .done(response => {
                        if (response.success && response.logs) {
                            $('#activityLog').empty();
                            response.logs.forEach(log => {
                                $('#activityLog').append('<div class="log-entry">' + log.trim() + '</div>');
                            });
                            addLogEntry('Job logs loaded successfully');
                        } else {
                            addLogEntry('No logs found or failed to load logs');
                        }
                    })
                    .fail(xhr => {
                        const response = xhr.responseJSON;
                        addLogEntry('Failed to load logs: ' + (response?.message || 'Unknown error'));
                    })
                    .always(() => {
                        btn.prop('disabled', false).html('<i class="fas fa-file-alt"></i> View Logs');
                    });
            });

            // Clear log button
            $('#clearLogBtn').click(function() {
                // Clear the UI log
                $('#activityLog').empty();
                addLogEntry('Clearing system log...');
                
                // Call the server to clear laravel.log
                $.ajax({
                    url: '/admin/clear-log',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            addLogEntry('System log cleared successfully');
                        } else {
                            addLogEntry('Error clearing system log');
                        }
                    },
                    error: function() {
                        addLogEntry('Failed to clear system log');
                    }
                });
            });

            // Stop polling when page is closed
            $(window).on('beforeunload', stopPolling);

            // Auto-start polling if job in progress on page load
            const currentStatus = '{{ $status["status"] }}';
            if (currentStatus === 'In Progress' || currentStatus === 'Starting...') {
                startPolling();
                $('#startJobBtn').hide();
                $('#stopJobBtn').show();
            }

        });
    </script>


    <script>
        $(document).ready(function() {
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