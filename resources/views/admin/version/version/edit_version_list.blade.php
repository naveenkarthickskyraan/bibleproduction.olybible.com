<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Bible App - Add Version Info</title>
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
            <h1><i class="fa fa-layer-group"></i> Versions List (Edit Form)</h1>
            <nav>
                <ol class="breadcrumb">&nbsp;&nbsp;&nbsp;&nbsp;&#11162;&nbsp;&nbsp;
                    <li class="breadcrumb-item"><a href="{{ url('admin/version_list') }}">Versions
                            List</a></li>
                    <li class="breadcrumb-item active">List of Versions Table</li>
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
                            <i class="fas fa-folder-tree me-2"></i>Version Edit Page Form
                        </h4>
                    </div>

                    <div class="card-body">
                        <form class="forms-sample" id="versionForm" action="{{ url('admin/edit_version_list/' . $version->id) }}"
                            method="POST" role="form" enctype="multipart/form-data">
                            @csrf
                            <hr class="text-dark">
                            <div class="container-fluid">

                                <!-- Version Name -->

                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <label for="name" class="form-label">
                                            <i class="fas fa-book me-2"></i>Version Name
                                            <span class="required">*</span>
                                        </label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <input name="version_name" class="form-control" id="name" type="text"
                                            placeholder="Enter Version Name (e.g., King James Version, NIV, ESV)"
                                            value="{{ $version->version_name }}" required >
                                        <div class="error-message" id="name-error"></div>
                                    </div>
                                </div>

                                <!-- Version Number -->
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <label for="version_num_disabled" class="form-label">
                                            <i class="fas fa-hashtag me-2"></i>Version Number
                                        </label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <input type="number" class="form-control"
                                            placeholder="Auto-generated version number" name="version_num_disabled"
                                            id="version_num_disabled" value="<?php echo $version->version_num; ?>" disabled>
                                        <input type="hidden" name="version_num" id="version_num"
                                            value="<?php echo $version->version_num; ?>">
                                        <small class="text-muted">This number is automatically generated</small>
                                    </div>
                                </div>

                                <!-- Text Alignment -->
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <label for="alignment" class="form-label">
                                            <i class="fas fa-align-left me-2"></i>Text Alignment
                                        </label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <select class="form-select select2" aria-label="Select alignment" id="alignment"
                                            name="alignment">
                                            <option value="" selected>Select Text Alignment</option>
                                            <option value="1" {{ $version->alignment == "1" ? "selected":"" }}>Left to Right (LTR)</option>
                                            <option value="2" {{ $version->alignment == "2" ? "selected":"" }}>Right to Left (RTL)</option>
                                        </select>
                                        <div class="error-message errorstatus"></div>
                                        <small class="text-muted">Choose based on the language's reading
                                            direction</small>
                                    </div>
                                </div>

                                <!-- Meta Description -->
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <label for="metadescription" class="form-label">
                                            <i class="fas fa-tags me-2"></i>Meta Description
                                        </label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <textarea name="metadescription" class="form-control" id="metadescription" 
                                                rows="10" placeholder="Enter meta description for SEO (optional)">{{ $version->metadescription }}</textarea>
                                        <small class="text-muted">Brief description for search engines (160 characters recommended)</small>
                                        <div class="d-flex justify-content-between mt-1">
                                            <small class="text-muted">Character count: <span id="metaDescCount">0</span>/160</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Meta Keywords -->
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <label for="metakeywords" class="form-label">
                                            <i class="fas fa-key me-2"></i>Meta Keywords
                                        </label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <input name="metakeywords" class="form-control" id="metakeywords" type="text"
                                            placeholder="Enter comma-separated keywords for SEO (optional)" 
                                            value="{{ $version->metakeywords }}">
                                        <small class="text-muted">Comma-separated keywords for search engines (optional)</small>
                                    </div>
                                </div>


                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <label for="status" class="form-label">
                                             <i class="fas fa-toggle-on me-2"></i>Status
                                        </label>
                                    </div>

                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <select class="form-select select2" aria-label="Select status" id="status"
                                            name="status">
                                            <option value="" selected>Select Status</option>
                                            <option value="1" {{ $version->status == "1" ? "selected":"" }}>Active</option>
                                            <option value="2" {{ $version->status == "2" ? "selected":"" }}>In Active</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Language Selection -->
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <label for="languageid" class="form-label">
                                            <i class="fas fa-globe me-2"></i>Select Language
                                            <span class="required">*</span>
                                        </label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <select class="form-select select2" aria-label="Select language" id="languageid"
                                            name="languageid" required>
                                            <option value="" selected>Choose a Language</option>
                                            <?php if($lang != false){ ?>
                                                <?php foreach($lang as $row1){ ?>
                                                    <?php 
                                                        if($row1['id'] == $version->lang_id){ ?>
                                                            <option value="<?php echo $row1['id'].'|'.$row1['lang_name']; ?>" selected><?php echo $row1['lang_name']; ?></option>
                                                    <?php 
                                                        } else {
                                                            ?>
                                                            <option value="<?php echo $row1['id'].'|'.$row1['lang_name']; ?>"><?php echo $row1['lang_name']; ?></option>
                                                    <?php } 
                                                    ?>
                                            <?php } } ?>
                                        </select>
                                        <div class="error-message errorlanguageid"></div>
                                        <small class="text-muted">Select the primary language for this Bible
                                            version</small>
                                    </div>
                                </div>

                                <!-- Audio Type Selection -->

                                <div class="row mb-4" id="audiotypediv" style="display: none;">
                                    <div class="col-md-12">
                                        <label for="audiotype" class="form-label">
                                            <i class="fas fa-volume-up me-2"></i>Audio Type
                                            <span class="required">*</span>
                                        </label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <select class="form-select select2" aria-label="Select audio type"
                                            id="audiotype" name="audiotype">
                                            <option value="">Choose Audio Type</option>
                                        </select>
                                        <div class="error-message erroraudiotype"></div>
                                        <small class="text-muted">Select how audio will be provided for this
                                            version</small>
                                    </div>
                                </div>

                                <!-- Form Actions -->

                                <div class="row mt-5">
                                    <div class="col-12">
                                        <hr class="mb-4">
                                        <div class="d-flex justify-content-end gap-3">
                                            <a href="{{ url('admin/version_list') }}" class="btn btn-dark">
                                                <i class="fas fa-times me-2"></i>Cancel
                                            </a>
                                            <button type="submit" name="submit" class="btn btn-primary" id="submitBtn">
                                                <i class="fas fa-save me-2"></i>Save Version
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

    {{-- <script src="{{ asset('assets/js/quiz.js') }}"></script> --}}


    <script>
        let selectedAudiotype = "{{ $version->audiotype ?? '' }}";

        function handleLanguageChange() {
            const selectedValue = $('#languageid').val();

            if (selectedValue !== '') {
                $('.errorlanguageid').html('');

                // Show loading state
                $('#audiotypediv').hide();
                $('#audiotype').html('<option value="">Loading...</option>');

                const languageId = selectedValue.split('|')[0];
                const formData = new FormData();
                formData.append('languageid', languageId);

                $.ajax({
                    url: "{{ route('admin.getaudiotype') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#audiotype').html('<option value="">Choose Audio Type</option>');

                        if (response && response.result && response.result.length > 0) {
                            const result = response.result[0];

                            // Add "None" option
                            $('#audiotype').append(
                                `<option value="0" ${selectedAudiotype == 0 ? 'selected' : ''}>None</option>`
                            );

                            // Add Text to Speech option if available
                            if (result.text_to_speech_string && result.text_to_speech_string.trim() !== '') {
                                $('#audiotype').append(
                                    `<option value="1" ${selectedAudiotype == 1 ? 'selected' : ''}>Text To Speech</option>`
                                );
                            }

                            // Add MP3 option
                            $('#audiotype').append(
                                `<option value="2" ${selectedAudiotype == 2 ? 'selected' : ''}>MP3 Audio</option>`
                            );

                            // Show the audio type selection
                            $('#audiotypediv').fadeIn();
                        } else {
                            // If no audio options available, still show the div with just "None"
                            $('#audiotype').append(
                                `<option value="0" ${selectedAudiotype == 0 ? 'selected' : ''}>None</option>`
                            );
                            $('#audiotypediv').fadeIn();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching audio types:', error);
                        toastr.error('Error loading audio types. Please try again.');

                        // Reset audio type dropdown
                        $('#audiotype').html('<option value="">Choose Audio Type</option>');
                        $('#audiotype').append('<option value="0">None</option>');
                        $('#audiotypediv').fadeIn();
                    }
                });
            } else {
                $('.errorlanguageid').html('<span class="error-message">Please select a language</span>');
                $('#audiotypediv').hide();
            }
        }

        // Bind to the change event
        $('#languageid').change(handleLanguageChange);

        // Optionally call it on page load if a language is already selected
        $(document).ready(function() {
            if ($('#languageid').val() !== '') {
                handleLanguageChange();
            }
        });

        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: 'default',
                width: '100%'
            });
            
            $('.select2').on('select2:open', function(e) {
                $('input.select2-search__field').prop('placeholder', 'Search here...');
                document.querySelector('.select2-search__field').focus();
            });

            // Initialize Toastr
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            // Form validation
            $('#versionForm').on('submit', function(e) {
                let isValid = true;
                
                // Validate version name
                if ($('#name').val().trim() === '') {
                    $('#name-error').text('Version name is required');
                    isValid = false;
                } else {
                    $('#name-error').text('');
                }
                
                // Validate language selection
                if ($('#languageid').val() === '') {
                    $('.errorlanguageid').html('<span class="error-message">Please select a language</span>');
                    isValid = false;
                } else {
                    $('.errorlanguageid').html('');
                }
                
                // Validate audio type if visible
                if ($('#audiotypediv').is(':visible') && $('#audiotype').val() === '') {
                    $('.erroraudiotype').html('<span class="error-message">Please select an audio type</span>');
                    isValid = false;
                } else {
                    $('.erroraudiotype').html('');
                }
                
                if (!isValid) {
                    e.preventDefault();
                    toastr.error('Please fix the validation errors before submitting');
                    return false;
                }
                
                // Show loading state
                $('#submitBtn').hide();
                $('#loadingBtn').show();
                
                return true;
            });

            // Audio type change validation
            $('#audiotype').change(function() {
                if ($(this).val() === '') {
                    $('.erroraudiotype').html('<span class="error-message">Please select an audio type</span>');
                } else {
                    $('.erroraudiotype').html('');
                }
            });

            // Name field validation
            $('#name').on('blur', function() {
                if ($(this).val().trim() === '') {
                    $('#name-error').text('Version name is required');
                } else {
                    $('#name-error').text('');
                }
            });

        });
    </script>

    <script>
        // JavaScript for Preloader
        // Preloader
        window.addEventListener('load', function() {
            const preloader = document.getElementById('pre-loader');
            preloader.style.opacity = '0';
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 500);
        });
    </script>

</body>

</html>