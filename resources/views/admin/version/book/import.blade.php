<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Bible App - Import Book Info</title>
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

    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet"> --}}

    {{-- <!-- Templat{{ asset('e Main CSS File --> --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/preloader.css') }}" rel="stylesheet">

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

    </style>

</head>

<body >
    @include('admin.navbar')
    <!-- ======= Sidebar ======= -->
    @include('admin.sidebar')

    <div id="pre-loader" class="pre-loader is-active">
        <div class="loader">
        </div>
    </div>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1><i class="fa fa-coins"></i>&nbsp;&#11162;&nbsp;Book List (Import Form)</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('admin/version_list') }}">Book
                            List</a></li>
                    <li class="breadcrumb-item active">List of Book Table</li>
                </ol>
            </nav>
        </div>

        @if (Session::has('error'))
            <div class="alert-container">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <div>{{ Session::get('error') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        @if (Session::has('message'))
            <div class="alert-container">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle me-2"></i>
                        <div>{{ Session::get('message') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <div class="alert-container"></div>

        <div class="row">
            <div class="col-md-9 grid-margin stretch-card">

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li> <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        @endforeach
                    </div>
                @endif


                @if(Session::has('results'))
                
                    <div class="alert-container">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle me-2"></i>
                                <div>{{ "Book Import Successfully!.." }}</div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    
                    @php
                        $importResults = Session::get('results');
                    @endphp

                    <div class="alert alert-info">
                        <h5>Import Summary</h5>
                        <ul class="mb-0">
                            <li>Total Records Processed: {{ $importResults['total'] }}</li>
                            <li>New Records Added: {{ $importResults['added'] }}</li>
                            <li>Existing Records Updated: {{ $importResults['updated'] }}</li>
                            <li>Failed Records: {{ $importResults['failed'] }}</li>
                        </ul>
                    </div>
                @endif

                <div class="card" style="background-color: #fff;">

                    <div class="card-header d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0" style="color: #7367EF !important;">
                            <i class="fas fa-folder-tree me-2"></i>Book Import </h4>
                    </div>

                    <div class="card-body">
                        <form class="forms-sample" action="{{ route('book.import') }}" method="POST" role="form"
                            enctype="multipart/form-data">
                            @csrf
                            
                            <div class="container px-2">
                            
                                <a href="{{ asset('assets/csv/BookSample.xlsx') }}" download class="btn btn-sm btn-outline-primary refresh-log">
                                    Click here to download sample Excel file
                                </a>

                                
                                <div class="form-group row">
                                    <div class="col-sm-12 d-flex aling-items-center">
                                        <label for="version_id" class="col-sm-12 col-form-label h2 text-dark">App
                                            Version<span style="color:red;">&nbsp;*</span></label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <select class="form-control select2" name="version_id" id="version_id">
                                            <option value="">Select a Version name</option>
                                            @foreach ($versions as $data)
                                            <option value="{{ $data->id  }}" {{ $data->id == old('version_id') ?
                                                "selected":""}}> {{ $data->version_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">    
                                    <div class="col-sm-12 d-flex aling-items-center">
                                        <label for="file" class="col-sm-12 col-form-label h2 text-dark">Upload book File (xlsx/csv) <span style="color:red;">&nbsp;*</span></label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                       <input type="file" class="form-control ps-2" id="file" name="file"
                                                placeholder="Enter book Name" accept=".xlsx, .xls, .csv">
                                    </div>
                                </div>
                                <br>
                                <br>
                                
                                <!-- Form Actions -->
                                <div class="row">
                                    <div class="col-12">
                                        <hr>
                                        <div class="d-flex justify-content-end gap-3">
                                            <a href="{{ url('admin/book_list') }}" class="btn btn-dark">
                                                <i class="fas fa-times me-2"></i>Cancel
                                            </a>
                                            <button type="submit" name="submit" class="btn btn-primary" id="submitBtn">
                                                <i class="fas fa-save me-2"></i>Save Book(s)
                                            </button>
                                            <button id="loadingBtn" class="btn btn-primary" type="button" disabled
                                                style="display: none;">
                                                <span class="spinner-grow spinner-grow-sm me-2" role="status"
                                                    aria-hidden="true"></span>
                                                Saving...
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('assets/editor_ckediter/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/editor_ckediter/adapters/jquery.js') }}"></script>
    <script src="{{ asset('assets/editor_ckediter/styles.js') }}"></script>


    <script>
        // Initialize Select2
        $('.select2').select2({
            theme: 'default',
            width: '100%'
        });
            
        $('.select2').on('select2:open', function(e) {
            $('input.select2-search__field').prop('placeholder', 'Search here...');
            document.querySelector('.select2-search__field').focus();
        });
        // JavaScript for Preloader
        // Preloader
        window.addEventListener('load', function() {
            const preloader = document.getElementById('pre-loader');
            preloader.style.opacity = '0';
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 500);
        });


        $('#loading').hide();
        $('#susubmitbmit').on('click', function() {
            $('#loading').show();
            $('#susubmitbmit').hide();
        });
    </script>

</body>

</html>
