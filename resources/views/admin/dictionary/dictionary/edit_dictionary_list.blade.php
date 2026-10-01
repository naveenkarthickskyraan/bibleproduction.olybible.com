<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Bible App - Edit Dictionary Words Info</title>
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

    {{--
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css"
        rel="stylesheet"> --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{--
    <!-- Templat{{ asset('e Main CSS File --> --}}

    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/preloader.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/quiz.css') }}" rel="stylesheet">

</head>

<body>
    @include('admin.navbar')
    <!-- ======= Sidebar ======= -->
    @include('admin.sidebar')

    <div id="pre-loader" class="pre-loader is-active">
        <div class="loader">
        </div>
    </div>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1><i class="fa fa-layer-group"></i> Dictionary Words List (Edit Form)</h1>
            <nav>
                <ol class="breadcrumb">&nbsp;&nbsp;&nbsp;&nbsp;&#11162;&nbsp;&nbsp;
                    <li class="breadcrumb-item"><a href="{{ url('admin/dictionary_list') }}">Dictionary Words
                            List</a></li>
                    <li class="breadcrumb-item active">List of Dictionary Words Table</li>
                </ol>
            </nav>
        </div>


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

                <div class="card" style="background-color: #fff;">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0" style="color: #7367EF !important;">
                            <i class="fas fa-folder-tree me-2"></i>Dictionary Words Edit Page Form
                        </h4>
                    </div>

                    <div class="card-body">
                        <form class="forms-sample" action="{{ url('admin/edit_dictionary_list/' . $edit->id) }}"
                            method="POST" role="form" enctype="multipart/form-data">
                            @csrf
                            <hr class="text-dark">
                            <div class="container px-2">


                                <div class="form-group row">
                                    <div class="col-sm-12 d-flex aling-items-center">
                                        <label for="version_id" class="col-sm-12 col-form-label h2 text-dark">App Version<span style="color:red;">&nbsp;*</span></label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <select class="form-control select2" name="version_id" id="version_id">
                                            <option value="">Select a Version name</option>
                                            @foreach ($versions as $data)
                                                <option value="{{ $data->id  }}" {{ $data->id == $edit->version_id ? "selected":""}}> {{ $data->version_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-sm-12 d-flex aling-items-center">
                                        <label for="word" class="col-sm-12 col-form-label h2 text-dark">Word
                                            <span style="color:red;">&nbsp;*</span></label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <input name="word" class="form-control" id="word" type="text"
                                            placeholder="Enter Word Name" value="{{ $edit->word }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12 d-flex aling-items-center">
                                        <label for="description" class="col-sm-12 col-form-label h2 text-dark">
                                            Description<span style="color:red;">&nbsp;*</span></label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <textarea name="description" class="form-control" id="description"
                                            placeholder="Enter Description"
                                            rows="7">{{ $edit->description }}</textarea>
                                    </div>
                                </div>

                                <br>
                                <br>


                                <div class="container px-5">
                                    <div class="row">
                                        <div class="col-sm-12 text-end">
                                            <button type="submit" name="submit" class="btn btn-primary"
                                                id="susubmitbmit"><i class="fas fa-save me-1"></i> Submit</button>
                                            <button id="loading" class="btn btn-primary" type="button" disabled=""><span
                                                    class="spinner-grow spinner-grow-sm" role="status"
                                                    aria-hidden="true"></span>Loading...</button>
                                            <a href="{{ url('admin/dictionary_list').'#'.$edit->id }}" class="btn btn-dark"
                                                type="button">Cancel</a>
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

    {{-- <script src="{{ asset('assets/js/quiz.js') }}"></script> --}}
  
    <script src="{{ asset('assets/editor_ckediter/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/editor_ckediter/styles.js') }}"></script>
    <script src="{{ asset('assets/editor_ckediter/adapters/jquery.js') }}"></script>


    <script>
        $('.select2').select2();
        
        $('.select2').on('select2:open', function(e) {
            $('input.select2-search__field').prop('placeholder', 'Search here...');
            document.querySelector('.select2-search__field').focus();
        });
        
        var editor = CKEDITOR.replace('description', {
            extraPlugins: 'image2,uploadimage',
            filebrowserUploadUrl: "{{ route('upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form',
            height: 400,
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