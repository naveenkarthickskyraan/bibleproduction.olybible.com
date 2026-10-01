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
        .badge-processing {
            background-color: #ffc107;
            color: #212529;
        }

        .badge-completed {
            background-color: #28a745;
            color: white;
        }

        .badge-failed {
            background-color: #dc3545;
            color: white;
        }

        /* Alert Styles */
        .alert-container {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 9999;
            width: 350px;
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
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0" style="color: #7367EF !important;">
                            <i class="fas fa-file-import me-2"></i>Verse Import
                        </h4>
                        <span id="importStatusBadge" class="badge bg-dark">Ready</span>
                    </div>

                    <div class="card-body">
                        <!-- Progress Section (Initially Hidden) -->
                        <div id="progressSection" style="display: none;">
                            <div class="d-flex justify-content-between mb-1">
                                <span id="progressStatus">Initializing import...</span>
                                <span id="progressPercent">0%</span>
                            </div>
                            
                            <div class="progress">
                                <div id="importProgress" class="progress-bar progress-bar-striped progress-bar-animated" 
                                    role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            
                            <div class="mt-3" id="progressDetails">
                                <div class="d-flex justify-content-between mb-2">
                                    <small class="text-muted">Processed:</small>
                                    <small><span id="processedCount">0</span> of <span id="totalRows">0</span> rows</small>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <small class="text-muted">Estimated time remaining:</small>
                                    <small><span id="timeRemaining">Calculating...</span></small>
                                </div>
                            </div>
                        </div>

                        <!-- Results Card (Initially Hidden) -->
                        <div class="card mt-4" id="resultsCard" style="display: none;">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="fas fa-check-circle me-2"></i> Import Complete</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="alert alert-success">
                                            <h6 class="alert-heading">Successfully Processed</h6>
                                            <div class="d-flex justify-content-between">
                                                <span>Total:</span>
                                                <strong id="totalCount">0</strong>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span>Added:</span>
                                                <strong id="addedCount">0</strong>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span>Updated:</span>
                                                <strong id="updatedCount">0</strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="alert alert-danger">
                                            <h6 class="alert-heading">Failed Rows</h6>
                                            <div class="d-flex justify-content-between">
                                                <span>Total:</span>
                                                <strong id="failedCount">0</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-center mt-3">
                                    <button id="doneBtn" class="btn btn-primary">
                                        <i class="fas fa-redo me-2"></i> Import Another File
                                    </button>
                                    <button id="viewVersesBtn" class="btn btn-outline-primary ms-2">
                                        <i class="fas fa-book me-2"></i> View Imported Verses
                                    </button>
                                    <button id="downloadReportBtn" class="btn btn-outline-secondary ms-2">
                                        <i class="fas fa-download me-2"></i> Download Report
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Error Card (Initially Hidden) -->
                        <div class="card mt-4" id="errorCard" style="display: none;">
                            <div class="card-header bg-danger text-white">
                                <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i> Import Failed</h5>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-danger" id="errorMessage"></div>
                                <div class="text-center">
                                    <button id="retryBtn" class="btn btn-danger me-2">
                                        <i class="fas fa-sync-alt me-2"></i> Retry Import
                                    </button>
                                    <button id="cancelBtn" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i> Cancel
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Import Form -->
                        <form id="importForm" class="mt-4" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <a href="{{ asset('assets/csv/VerseSample.xlsx') }}" download class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-download me-2"></i>Download Sample Excel File
                                </a>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="version_id" class="form-label">Bible Version <span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="version_id" id="version_id" required>
                                        <option value="">Select a Version</option>
                                        @foreach ($versions as $version)
                                            <option value="{{ $version->id }}">{{ $version->version_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="file" class="form-label">Upload Verse File (xlsx/csv) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" id="file" name="file" accept=".xlsx, .xls, .csv" required>
                                    </div>
                                    <small class="text-muted">Max file size: 50MB</small>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <a href="{{ url('admin/verse_list') }}" class="btn btn-secondary me-2">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <span id="submitText"><i class="fas fa-upload me-2"></i> Import Verses</span>
                                    <span id="submitSpinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
                                </button>
                            </div>
                        </form>
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
            // Initialize Select2
            $('.select2').select2({
                width: '100%'
            });

            // Initialize variables for progress tracking
            let progressInterval;
            let versionId = null;
            let userId = {{ auth()->guard('admin')->id() ?? 'null' }};

            // Form submission handler
            $('#importForm').on('submit', function(e) {
                e.preventDefault();
                
                // Reset UI
                $('#resultsCard').hide();
                $('#errorCard').hide();
                $('#progressSection').show();
                $('#submitBtn').prop('disabled', true);
                $('#submitText').text('Processing...');
                $('#submitSpinner').show();
                $('#importStatusBadge').removeClass('bg-light bg-success bg-danger').addClass('bg-warning').text('Processing');
                
                // Update progress UI
                updateProgressUI(0, 'Preparing import...', 0, 0);
                
                // Prepare form data
                const formData = new FormData(this);
                
                // Submit via AJAX
                $.ajax({
                    url: "{{ route('verse.import') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            if (response.queued) {
                                // Store the import job ID
                                currentImportJobId = response.import_job_id;
                                
                                // Large file - background processing
                                updateProgressUI(5, 'Your file is being processed in the background...', 0, 0);
                                monitorImportProgress(response.import_job_id);
                            } else {
                                // Small file - immediate results
                                currentImportJobId = response.import_job_id;
                                showImportResults(response.results);
                            }
                        } else {
                            showImportError(response.message || 'Import failed');
                        }
                    },
                    error: function(xhr) {
                        let error = xhr.responseJSON ? xhr.responseJSON.message : 'An unknown error occurred';
                        showImportError(error);
                    }
                });
            });

            // Monitor import progress for queued jobs
            function monitorImportProgress(importJobId) {
                clearInterval(progressInterval);
                
                progressInterval = setInterval(function() {
                    $.ajax({
                        url: "{{ route('admin.verses.import.status') }}",
                        type: 'GET',
                        data: {
                            import_job_id: importJobId
                        },
                        success: function(response) {
                            switch(response.status) {
                                case 'completed':
                                    clearInterval(progressInterval);
                                    showImportResults(response.results);
                                    break;
                                case 'failed':
                                    clearInterval(progressInterval);
                                    showImportError(response.error || 'Import failed');
                                    break;
                                case 'processing':
                                    const progress = response.progress || 0;
                                    const status = response.status_message || 'Processing...';
                                    const processed = response.processed_rows || 0;
                                    const total = response.total_rows || 0;
                                    const timeRemaining = response.estimated_time_remaining || 'Calculating...';
                                    
                                    updateProgressUI(progress, status, processed, total, timeRemaining);
                                    break;
                                case 'pending':
                                    updateProgressUI(5, 'Waiting for job to start processing...', 0, 0);
                                    break;
                                default:
                                    clearInterval(progressInterval);
                                    showImportError('Unknown import status: ' + response.status);
                            }
                        },
                        error: function() {
                            console.error('Error checking import status');
                        }
                    });
                }, 3000); // Check every 3 seconds
            }

            // Update progress UI
            function updateProgressUI(percent, status, processed, total, timeRemaining = 'Calculating...') {
                percent = Math.min(100, Math.max(0, percent)); // Ensure between 0-100
                
                // Update progress bar
                $('#importProgress').css('width', percent + '%').attr('aria-valuenow', percent);
                $('#progressPercent').text(percent + '%');
                $('#progressStatus').text(status);
                
                // Update processed rows
                $('#processedCount').text(processed);
                $('#totalRows').text(total);
                $('#timeRemaining').text(timeRemaining);
                
                // Change progress bar color based on percentage
                if (percent >= 90) {
                    $('#importProgress').removeClass('bg-warning').addClass('bg-success');
                } else if (percent >= 50) {
                    $('#importProgress').removeClass('bg-info').addClass('bg-warning');
                } else {
                    $('#importProgress').removeClass('bg-warning bg-success').addClass('bg-info');
                }
            }

            // Show import results
            function showImportResults(results) {
                // Update progress to 100%
                updateProgressUI(100, 'Import completed successfully', results.total || 0, results.total || 0, 'Completed');
                
                // Update status badge
                $('#importStatusBadge').removeClass('bg-warning bg-danger').addClass('bg-success').text('Completed');
                
                // Show results
                $('#totalCount').text(results.total || 0);
                $('#addedCount').text(results.added || 0);
                $('#updatedCount').text(results.updated || 0);
                $('#failedCount').text(results.failed || 0);
                
                // Show results card
                $('#resultsCard').show();
                
                // Enable buttons
                $('#submitBtn').prop('disabled', false);
                $('#submitText').html('<i class="fas fa-upload me-2"></i> Import Verses');
                $('#submitSpinner').hide();
                
                // Set up button handlers
                $('#viewVersesBtn').off('click').on('click', function() {
                    window.location.href = `{{ route('verse_import.list') }}?version_id=${versionId}`;
                });
                
                $('#downloadReportBtn').off('click').on('click', function() {
                    window.location.href = `{{ route('admin.verses.import.status') }}?version_id=${versionId}`;
                });
                
                // Show success toast
                toastr.success('Verse import completed successfully!', 'Success');
            }

            // Show import error
            function showImportError(error) {
                // Update UI for error state
                $('#importProgress').removeClass('bg-info bg-warning bg-success').addClass('bg-danger');
                $('#progressPercent').text('Error');
                $('#progressStatus').text('Import failed');
                $('#importStatusBadge').removeClass('bg-warning bg-success').addClass('bg-danger').text('Failed');
                
                // Show error message
                $('#errorMessage').text(error);
                $('#errorCard').show();
                
                // Enable buttons
                $('#submitBtn').prop('disabled', false);
                $('#submitText').html('<i class="fas fa-upload me-2"></i> Import Verses');
                $('#submitSpinner').hide();
                
                // Show error toast
                toastr.error(error, 'Import Failed');
            }

            // Done button handler
            $('#doneBtn').on('click', function() {
                resetImportForm();
            });

            // Retry button handler
            $('#retryBtn').on('click', function() {
                resetImportForm();
            });

            // Cancel button handler
            $('#cancelBtn').on('click', function() {
                resetImportForm();
            });

            // Reset form to initial state
            function resetImportForm() {
                $('#progressSection').hide();
                $('#resultsCard').hide();
                $('#errorCard').hide();
                $('#importStatusBadge').removeClass('bg-warning bg-success bg-danger').addClass('bg-light').text('Ready');
                $('#importForm')[0].reset();
                $('.select2').val(null).trigger('change');
                $('#submitBtn').prop('disabled', false);
                $('#submitText').html('<i class="fas fa-upload me-2"></i> Import Verses');
                $('#submitSpinner').hide();
            }

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