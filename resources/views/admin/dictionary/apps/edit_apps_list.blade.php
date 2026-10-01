<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Bible App - Edit Apps Info</title>
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

    {{--
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css"
        rel="stylesheet"> --}}

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
            <h1><i class="fa fa-layer-group"></i> Apps List (Edit Form)</h1>
            <nav>
                <ol class="breadcrumb">&nbsp;&nbsp;&nbsp;&nbsp;&#11162;&nbsp;&nbsp;
                    <li class="breadcrumb-item"><a href="{{ url('admin/apps_list') }}">Apps
                            List</a></li>
                    <li class="breadcrumb-item active">List of Apps Table</li>
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
                            <i class="fas fa-folder-tree me-2"></i>Apps Edit Page Form
                        </h4>
                    </div>

                    <div class="card-body">
                        <form class="forms-sample" action="{{ url('admin/edit_apps_list/' . $edit->id) }}"
                            method="POST" role="form" enctype="multipart/form-data">
                            @csrf
                            <hr class="text-dark">
                            <div class="container px-2">

                                <div class="form-group row">
                                    <div class="col-sm-12 d-flex aling-items-center">
                                        <label for="app_name" class="col-sm-12 col-form-label h2 text-dark">App Name <span style="color:red;">&nbsp;*</span></label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <input name="app_name" class="form-control" id="app_name" type="text" placeholder="Enter App Name" value="{{ $edit->app_name }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12 d-flex aling-items-center">
                                        <label for="app_description" class="col-sm-12 col-form-label h2 text-dark">App Description<span style="color:red;">&nbsp;*</span></label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <textarea name="app_description" class="form-control" id="app_description" placeholder="Enter App Description" rows="7">{{ $edit->app_description }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12 d-flex aling-items-center">
                                        <label for="app_type" class="col-sm-12 col-form-label h2 text-dark">App Type<span style="color:red;">&nbsp;*</span></label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <select name="app_type" class="form-control select2" id="app_type" required>
                                            <option value="">Select App Type</option>
                                            <option value="ios" {{  $edit->app_type == 'ios' ? 'selected' : '' }}>iOS</option>
                                            <option value="android" {{  $edit->app_type == 'android' ? 'selected' : '' }}>Android</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row ios-fields" style="display: {{  $edit->app_type == 'ios' ? 'block' : 'none' }};">
                                    <div class="col-sm-12 d-flex aling-items-center">
                                        <label for="apple_id" class="col-sm-12 col-form-label h2 text-dark">Apple ID <span style="color:red;">&nbsp;*</span></label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <input name="apple_id" class="form-control" id="apple_id" type="text" placeholder="Enter Apple ID" value="{{  $edit->apple_id }}" {{  $edit->app_type == 'ios' ? 'required' : '' }}>
                                    </div>
                                </div>

                                <div class="form-group row ios-fields" style="display: {{  $edit->app_type == 'ios' ? 'block' : 'none' }};">
                                    <div class="col-sm-12 d-flex aling-items-center">
                                        <label for="bundle_id" class="col-sm-12 col-form-label h2 text-dark">Bundle ID <span style="color:red;">&nbsp;*</span></label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <input name="bundle_id" class="form-control" id="bundle_id" type="text" placeholder="Enter Bundle ID" value="{{  $edit->bundle_id }}" {{  $edit->app_type == 'ios' ? 'required' : '' }}>
                                    </div>
                                </div>

                                <div class="form-group row android-fields" style="display: {{  $edit->app_type == 'android' ? 'block' : 'none' }};">
                                    <div class="col-sm-12 d-flex aling-items-center">
                                        <label for="package_name" class="col-sm-12 col-form-label h2 text-dark">Package Name <span style="color:red;">&nbsp;*</span></label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <input name="package_name" class="form-control" id="package_name" type="text" placeholder="Enter Package Name" value="{{  $edit->package_name }}" {{  $edit->app_type == 'android' ? 'required' : '' }}>
                                    </div>
                                </div>

                                

                                <div class="form-group row  px-1">
                                    <label for="exampleInputUsername2" class="col-sm-12 col-form-label h2 text-dark" style="padding-left: 10px">Image Upload Type</label>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <div class="form-check-inline h5 text-dark">
                                            <input class="form-check-input" type="radio" name="thumb_upload_type" id="image_3" value='1' checked style="font-size:1.00rem;align-items:center;">
                                            <label class="form-check-label" for="image_3" style="font-size: 1.00rem;">
                                                Image Type
                                            </label>
                                        </div>
                                        <div class="form-check-inline h5 text-dark">
                                            <input class="form-check-input" type="radio" name="thumb_upload_type" id="image_4" value='2'style="font-size:1.00rem;align-items:center;" >
                                            <label class="form-check-label" for="image_4" style="font-size: 1.00rem;">
                                                URL Type
                                            </label>
                                        </div> 
                                    </div>
                                </div>
                
                                <div id='Normal_image_type_1' class="form-group row px-1">
                                    <label for="file" class="col-sm-12 col-form-label h2 text-dark" style="padding-left: 10px">Image Upload URL</label>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <input type="File" class="form-control" id="file" name="thumb_file" accept="image/*" placeholder="Choose File">
                                    </div>
                                </div>
                
                                <div id="url_image_type_2" class="form-group row px-1">
                                    <label for="file_1" class="col-sm-12 col-form-label h2 text-dark" style="padding-left: 10px">Image URL</label>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <input type="url" class="form-control" id="file_1" name="thumb_url_image" placeholder="Copy and Paste an Image address or URL" value="{{old('thumb_url_image')}}">
                                    </div>
                                </div>


                                <style>
                                    .ximage img{
                                        width: 85px;
                                        height: 85px;
                                        border-radius: 10px;
                                        box-shadow: 0px 0px 15px #405189;
                                        border:2px !important;
                                        opacity: 85%;
                                    }
                                </style>
                                
                                @if(!empty($edit->app_image))
                                    <div class="form-group row mb-3 ximage">
                                        <label for="file_1" class="col-sm-12 col-form-label h2 text-dark" style="padding-left: 10px">Image Preview </label>
                                        <div class="col-md-12 p-2" style="padding-left: 50px !important;">
                                            @if($edit->image_type == 1)
                                                <a href="{{asset("storage/".$edit->app_image)}}" target="_blank"><img src="{{asset("storage/".$edit->app_image)}}" data-bs-toggle="tooltip"  title="Click to View Image in another tab"  style="height:70px;width:auto;"/></a>
                                            @else
                                                <a href="{{$edit->app_image}}" target="_blank"><img src="{{$edit->app_image}}" data-bs-toggle="tooltip"  title="Click to View Image in another tab"  style="height:70px;width:auto;"/></a>
                                            @endif
                                        </div>
                                    </div>
                                @endif 

                                <div class="form-group row">
                                    <div class="col-sm-12 d-flex aling-items-center">
                                        <label for="temp_id" class="col-sm-12 col-form-label h2 text-dark">Template ID <span style="color:red;">&nbsp;*</span></label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <select class="form-control select2" name="temp_id" id="temp_id">
                                            <option value="">Select a Template name</option>
                                            @foreach ($tempInfo as $date)
                                                <option value="{{ $date->id  }}" {{ $date->id ==  $edit->temp_id ? "selected":""}}> {{ $date->template_name }}</option>
                                            @endforeach
                                        </select>
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
                                            <a href="{{ url('admin/apps_list').'#'.$edit->id }}" class="btn btn-dark"
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

    <script>
         $(document).ready(function() {
            $('.select2').select2();
                
            $('.select2').on('select2:open', function(e) {
                $('input.select2-search__field').prop('placeholder', 'Search here...');
                document.querySelector('.select2-search__field').focus();
            });
            
            // Handle app type change
            $('#app_type').change(function() {
                const selectedType = $(this).val();
                
                // Hide all platform-specific fields first
                $('.ios-fields, .android-fields').hide();
                $('.ios-fields input, .android-fields input').removeAttr('required');
                
                // Show and set required for the selected platform
                if (selectedType === 'ios') {
                    $('.ios-fields').show();
                    $('.ios-fields input').attr('required', 'required');
                    $('#loading').hide();
                    $('#susubmitbmit').show();
                } else if (selectedType === 'android') {
                    $('.android-fields').show();
                    $('.android-fields input').attr('required', 'required');
                    $('#loading').hide();
                    $('#susubmitbmit').show();
                }
            });

            // Trigger change event on page load if there's already a selected value
            if ($('#app_type').val()) {
                $('#app_type').trigger('change');
            }
        });
            
           
        var thumb_image = {{$edit->image_type ?? 1}};
        test_check_thumb_image(thumb_image);
        function test_check_thumb_image(params)
        {
            if(params == "1")
            {
                $('#image_3').attr("checked",true);
                $('#image_4').attr("checked",false);
                $("#Normal_image_type_1").show()
                $('#url_image_type_2').hide();
            }
            else if(params == "2") 
            { 
                $('#image_4').attr("checked",true);
                $('#image_3').attr("checked",false);
                $("#Normal_image_type_1").hide()
                $('#url_image_type_2').show();
            }
        }
        
        if($('#image_3').is(':checked'))
        {
            $("#Normal_image_type_1").show()
            $('#url_image_type_2').hide();
        }

        $('#image_3').bind('change', function () {
            if ($(this).is(':checked'))
                $("#Normal_image_type_1").show().removeAttr('checked',true)
                $('#url_image_type_2').hide();
            });
        
        $("#image_4").bind('change', function(){
            if ($(this).is(':checked'))
            $("#Normal_image_type_1").hide();
            $('#url_image_type_2').show().attr('checked',true);
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