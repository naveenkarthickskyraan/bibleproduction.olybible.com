<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Skyraan Website Dashboard</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Favicons -->
    <!-- Favicons -->
    <link href="{{ asset('assets/img/skyraan-technologies.avif') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    {{-- <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon"> --}}

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
    {{-- <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet"> --}}
    {{-- <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet"> --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- <!-- Templat{{ asset('e Main CSS File --> --}}
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/preloader.css') }}" rel="stylesheet">

    <link href="https://unpkg.com/slim-select@latest/dist/slimselect.css" rel="stylesheet">
    <style>
        .ss-main .ss-values .ss-placeholder {
            color: #aaa;
            font-size: 13px;
            display: flex;
            justify-content: center;
        }

        .ss-main {
            height: 40px;
            border: 1px solid #aaa !important;

        }

        .ss-main .ss-values {
            justify-content: center;
        }

        .ss-main:focus {
            border-color: #007BFF !important;
            outline: none !important;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5) !important;
        }

        .ss-content .ss-list .ss-option:hover {
            background: #ffffff !important;
            color: #000000 !important;
        }

        .ss-content .ss-list .ss-option.ss-highlighted,
        .ss-content .ss-list .ss-option:not(.ss-disabled).ss-selected:hover {
            color: #ffffff !important;
            background-color: #5897fb !important;
        }
    </style>

    <style>
        .pagination {
            --bs-pagination-padding-x: 0.75rem;
            --bs-pagination-padding-y: 0.375rem;
            --bs-pagination-font-size: 1rem;
            --bs-pagination-color: var(--bs-link-color);
            --bs-pagination-bg: #dee2e6 !important;
            --bs-pagination-border-width: 1px;
            --bs-pagination-border-color: #dee2e6;
            --bs-pagination-border-radius: 0.375rem;
            --bs-pagination-hover-color: var(--bs-link-hover-color);
            --bs-pagination-hover-bg: #0d6efd !important;
            --bs-pagination-hover-border-color: #dee2e6;
            --bs-pagination-focus-color: var(--bs-link-hover-color);
            --bs-pagination-focus-bg: #e9ecef;
            --bs-pagination-focus-box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            --bs-pagination-active-color: #fff;
            --bs-pagination-active-bg: #0d6efd;
            --bs-pagination-active-border-color: #0d6efd;
            --bs-pagination-active-border-radius: 10px !important;
            --bs-pagination-disabled-color: #6c757d !important;
            --bs-pagination-disabled-bg: #dee2e6 !important;
            --bs-pagination-disabled-border-color: #dee2e6;
            display: flex;
            padding-left: 0;
            list-style: none;
        }

        .page-link {
            border-radius: 10px !important;
            margin-top: 12px;
            margin-bottom: 12px;
            border-radius: 10px;
            border: 2px solid #4285F4 !important;
            box-shadow: rgba(0, 0, 0, 0.15) 2.4px 2.4px 3.2px;
        }

        .page-item:not(:first-child) .page-link {
            margin-left: 6px !important;
            border-radius: 10px;
        }
    </style>

    <style>
        /* Custom CSS for Select2 */
        .select2-container--default .select2-selection--single {
            height: 40px;
            border: 1px solid #bfc9d4;
            color: #3b3f5c;
            font-size: 15px;
            letter-spacing: 1px;
            padding-left: 0.75rem;
            border-radius: 6px;
            background: #fff;
            transition: none;
        }

        .select2-container--default .select2-selection--single:focus {
            box-shadow: none;
            border-color: #4361ee;
            color: #3b3f5c;
            background-color: #fff;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 40px;
            padding-left: 10px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px;
        }
    </style>

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
            <h1><i class="fa fa-users"></i>&nbsp;&#11162;&nbsp;Admin Accounts</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('admin/superadmin') }}">Admin Accounts List</a></li>
                    <li class="breadcrumb-item active">List of Admin Accounts Table</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <style>
            .apply_in_mugaam input[type="checkbox"] {
                display: none;
            }

            .apply_in_mugaam input[type="checkbox"]+label {
                cursor: pointer;
                padding: 8px 16px;
                background-color: #f0f0f0;
                border-radius: 4px;
                transition: background-color 0.3s ease;
                cursor: pointer;
            }

            .apply_in_mugaam input[type="checkbox"]:checked+label {
                background-color: #4170c2;
                cursor: pointer;
                color: #fff;
            }

            .choices__list--multiple .choices__item {
                background-color: #4170c2 !important;
                border: 1px solid #4170c2;
                cursor: pointer;
            }
        </style>

        @include('admin.show')

        <div class="row">
            <div class="col-md-9 col-12 grid-margin stretch-card">
                <div class="card" style="background-color: #fff;">
                    <div class="card-body">
                        <h4 class="card-title text-dark">Admin Accounts Add Form</h4>
                        <hr class="text-dark">
                        <form class="forms-sample" action="{{ url('admin/admin_insert') }}" method="POST"
                            role="form" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row mb-3">
                                <label for="parent"
                                    class="col-sm-12 col-form-label h2 text-dark"
                                    style="padding-left: 10px">Admin Type <span
                                        style="color:red;">&nbsp;*</span></label>
                                <div class="col-md-12">
                                    <select
                                        class="form-select form-select-white text-dark bg-outline-dark border-3 select2"
                                        id="parent" name="parent" style="width:100%">
                                        <option class="text-dark" value="">Please select the role of Admin
                                        </option>
                                        <option class="text-dark"
                                            {{ old('parent') == 'Administrator' ? 'selected' : '' }}
                                            value="Administrator">Administrator</option>
                                        <option class="text-dark" {{ old('parent') == 'SubAdmin' ? 'selected' : '' }}
                                            value="SubAdmin">SubAdmin</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name"
                                    class="col-sm-12 col-form-label h2 text-dark"
                                    style="padding-left: 10px">Admin Name <span
                                        style="color:red;">&nbsp;*</span></label>
                                <div class="col-md-12 mb-3">
                                    <input type="text" class="form-control bg-outline-dark border-3" name="name"
                                        id="name" value="{{ old('name') }}" placeholder="Enter a name">
                                </div>
                            </div>

                            <div class="form-group row ">
                                <label for="email"
                                    class="col-sm-12 col-form-label h2 text-dark"
                                    style="padding-left: 10px">Admin Email <span
                                        style="color:red;">&nbsp;*</span></label>
                                <div class="col-md-12 mb-3">
                                    <input type="email" class="form-control bg-outline-dark border-3"
                                        name="email" id="email" value="{{ old('email') }}"
                                        placeholder="Enter a Email">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password"
                                    class="col-sm-12 col-form-label h2 text-dark"
                                    style="padding-left: 10px">Admin Password <span
                                        style="color:red;">&nbsp;*</span></label>
                                <div class="col-md-12 mb-3">
                                    <input type="text" class="form-control bg-outline-dark border-3"
                                        name="password" id="password" placeholder="Enter a Password">
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label for="password_confirmation"
                                    class="col-sm-12 col-form-label h2 text-dark"
                                    style="padding-left: 10px">Confirm Password<span
                                        style="color:red;">&nbsp;*</span></label>
                                <div class="col-md-12 mb-3">
                                    <input type="text" class="form-control bg-outline-dark border-3"
                                        name="password_confirmation" id="password_confirmation"
                                        placeholder="Enter a Confirm Password">
                                </div>
                            </div>
                            <style>
                                .mm {
                                    width: 836px;
                                    border: 3px solid lightgrey;
                                    padding: 10px;
                                    margin: 10px;
                                }
                            </style>



                            <style>
                                .permission-container {
                                    max-height: 500px;
                                    overflow-y: auto;
                                }

                                .permission-group {
                                    margin-bottom: 2rem;
                                }

                                .module-title {
                                    font-weight: bold;
                                    text-transform: uppercase;
                                    color: #7367EF !important;
                                    border-bottom: 2px solid #00cec9;
                                    padding-bottom: 4px;
                                    margin-bottom: 15px;
                                }

                                .checkbox-box {
                                    display: inline-block;
                                    margin-right: 10px;
                                    margin-bottom: 10px;
                                }

                                .checkbox-box input[type="checkbox"] {
                                    display: none;
                                }

                                .checkbox-box label {
                                    display: inline-block;
                                    padding: 8px 14px;
                                    border-radius: 6px;
                                    background-color: #f5f6fa;
                                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                                    font-weight: 500;
                                    cursor: pointer;
                                    color: #2d3436;
                                    transition: all 0.2s ease-in-out;
                                    user-select: none;
                                }

                                .checkbox-box input[type="checkbox"]:checked+label {
                                    background-color: #7367EF !important;
                                    color: white;
                                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
                                }

                                .select-all-wrapper {
                                    margin-bottom: 20px;
                                }

                                .select-all-box {
                                    display: inline-block;
                                    margin-bottom: 10px;
                                }

                                .select-all-box input[type="checkbox"] {
                                    display: none;
                                }

                                .select-all-box label {
                                    display: inline-block;
                                    padding: 10px 18px;
                                    border-radius: 8px;
                                    background-color: #f5f6fa;
                                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                                    font-weight: 600;
                                    cursor: pointer;
                                    color: #2d3436;
                                    transition: all 0.2s ease-in-out;
                                    user-select: none;
                                }

                                .select-all-box input[type="checkbox"]:checked+label {
                                    background-color: #7367EF !important;
                                    color: white;
                                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
                                }
                            </style>

                            <div class="card">
                                <div class="card-header bg-primary text-white" style="background:#7367EF !important">
                                    {{-- <h4 class="mb-0">Module Permissions</h4> --}}
                                </div>
                                <div class="card-body mt-2">
                                    <div class="select-all-wrapper">
                                        <div class="select-all-box">
                                            <input type="checkbox" id="select_all">
                                            <label for="select_all">SELECT ALL</label>
                                        </div>
                                    </div>

                                    <div class="permission-container">
                                        @foreach ($modules as $key => $module)
                                            @php
                                                $moduleName = strtolower($module->module_name);
                                                $displayName = Str::title(str_replace('_', ' ', $moduleName));
                                            @endphp

                                            <div class="permission-group">
                                                <div class="module-title cursor-pointer" data-module="{{ $moduleName }}" style="cursor: pointer;">
                                                   <i class="fa fa-{{ $moduleIcons[$moduleName] }}"></i> {{ Str::upper($displayName) }}
                                                </div>

                                                <div class="d-flex flex-wrap">
                                                    @php
                                                        $icons        = [
                                                            'read'    => '📖',
                                                            'create'  => '➕',
                                                            'update'  => '✏️',
                                                            'status'  => '🟢',
                                                            'delete'  => '🗑️',
                                                            'import'  => '📥',
                                                        ];
                                                    @endphp

                                                    @foreach (['read', 'create', 'update', 'status', 'delete','import'] as $permission)
                                                        <div class="checkbox-box">
                                                            <input type="checkbox"
                                                                id="{{ $module->id }}_{{ $permission }}"
                                                                name="permissions[{{ $moduleName }}][]"
                                                                value="{{ $permission }}"
                                                                data-module="{{ $moduleName }}"
                                                                class="permission-checkbox"
                                                                @if (isset($existingPermissions[$moduleName]) && in_array($permission, $existingPermissions[$moduleName])) checked @endif>
                                                            <label for="{{ $module->id }}_{{ $permission }}">
                                                                {{ $icons[$permission] . strtoupper($permission) }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row ">
                                <label for="radio"
                                    class="col-sm-12 col-form-label h2 text-dark"
                                    style="padding-left: 10px">Image Type </label>
                                <div class="col-md-12 mb-3">
                                    <div class="form-check-inline h5 text-dark">
                                        <input class="form-check-input" type="radio" name="file_type"
                                            id="image_1" value='1' checked
                                            style="font-size:1.00rem;align-items:center;">
                                        <label class="form-check-label" for="image_1" style="font-size: 1.00rem;">
                                            Image Type
                                        </label>
                                    </div>
                                    <div class="form-check-inline h5 text-dark">
                                        <input class="form-check-input" type="radio" name="file_type"
                                            id="image_2" value='2'
                                            style="font-size:1.00rem;align-items:center;">
                                        <label class="form-check-label" for="image_2" style="font-size: 1.00rem;">
                                            URL Type
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div id ='Normal_image_type' class="form-group row mb-3">
                                <label for="file"
                                    class="col-sm-12 col-form-label h2 text-dark"
                                    style="padding-left: 10px">User Image <span
                                        style="color:red;">&nbsp;*</span></label>
                                <div class="col-md-12 mb-3">
                                    <input type="File" class="form-control  border-3" id="file"
                                        name="file" placeholder="Choose File">
                                </div>
                            </div>
                            <div id="url_image_type" class="form-group row mb-3">
                                <label for="file_1"
                                    class="col-sm-12 col-form-label h2 text-dark"
                                    style="padding-left: 10px">User URL Image <span
                                        style="color:red;">&nbsp;*</span></label>
                                <div class="col-md-12 ">
                                    <input type="text" class="form-control bg-outline-dark border-3"
                                        id="file_1" name="url_image" placeholder="Copy and past a URL">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-end mt-5">
                                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                        <a href="{{ url('admin/superadmin') }}" class="btn btn-dark"
                                            type="button">cancel</a>
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
        <!-- <div class="credits"> -->
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
        <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div> -->
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://unpkg.com/slim-select@latest/dist/slimselect.min.js"></script>

    <script>
        document.getElementById('select_all').addEventListener('change', function() {
            const allCheckboxes = document.querySelectorAll('.permission-container input[type="checkbox"]');
            allCheckboxes.forEach(cb => cb.checked = this.checked);
        });
    
        // Add click event to module titles
        document.querySelectorAll('.module-title').forEach(title => {
            title.addEventListener('click', function() {
                const moduleName = this.getAttribute('data-module');
                const checkboxes = document.querySelectorAll(`.permission-checkbox[data-module="${moduleName}"]`);
                
                // Check if all are currently checked
                const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
                
                // Toggle all checkboxes for this module
                checkboxes.forEach(checkbox => {
                    checkbox.checked = !allChecked;
                });
                
                // Update the select all checkbox state
                updateSelectAllState();
            });
        });
    
        // Add change events to permission checkboxes
        document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateSelectAllState();
            });
        });
    
        function updateSelectAllState() {
            const allCheckboxes = document.querySelectorAll('.permission-checkbox');
            const allChecked = Array.from(allCheckboxes).every(checkbox => checkbox.checked);
            document.getElementById('select_all').checked = allChecked;
        }
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
    <script>
        if ($('#image_1').is(':checked')) {
            $("#Normal_image_type").show()
            $('#url_image_type').hide();
        }

        $('#image_1').bind('change', function() {
            if ($(this).is(':checked'))
                $("#Normal_image_type").show().removeAttr('checked', true)
            $('#url_image_type').hide();
        });

        $("#image_2").bind('change', function() {
            if ($(this).is(':checked'))
                $("#Normal_image_type").hide();
            $('#url_image_type').show().attr('checked', true);
        });
    </script>
    <script type="text/javascript">
        function submitQuestionForm() {
            var image = $('input[name="file_type"]:checked').val();
            var image_type = '';
            if (qytoe == 1) {
                quesdesc = $('#Normal_image_type').val();
            }
            if (qytoe == 2) {
                quesdesc = $('#url_image_type').val();
            }
        }
    </script>
    <script>
        $('#parent').select2();
        $('.select2').on('select2:open', function(e) {
            $('input.select2-search__field').prop('placeholder', 'Search here...');
            document.querySelector('.select2-search__field').focus();
        });
    </script>
</body>

</html>
