<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Skyraan Website Dashboard</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
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

    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">


    {{-- <!-- Templat{{ asset('e Main CSS File --> --}}
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/preloader.css') }}" rel="stylesheet">
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

        #loader {
            position: fixed;
            width: 100%;
            height: 100vh;
            background: hsl(201deg 87% 94%) url('https://mir-s3-cdn-cf.behance.net/project_modules/max_632/8a1f1813765711.56277edb36b94.gif') no-repeat center;
            z-index: 999;
        }
    </style>
    <style>
        .itemsContainer {
            background: red;
            float: left;
            position: relative
        }

        .itemsContainer:hover .play {
            display: block;
        }

        .play {
            position: absolute;
            display: none;
            top: 20%;
            width: 40px;
            margin: 0 auto;
            left: 0px;
            right: 0px;
            z-index: 100;
            font-size: 30px;
            color: #ff3333;
            cursor: pointer;

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
        {{-- @include('admin.show') --}}
        <section class="section dashboard">
            <div class="row">
                <!-- Recent Sales -->
                <div class="col-12">
                    
                    @include('admin.accounts.permission', [
                        'menu' => 'admin_menu',
                        'name' => 'Admin',
                    ])
                    
                    <div class="card recent-sales overflow-auto">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="card-title">Admin Accounts List <span>| Today</span></h5>
                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-3">
                                    <div class="action-btn" align="right" style="padding-top:20px;">
                                        <a href="{{ url('admin/admin_add_sub_admin') }}"
                                            class="btn btn-sm btn-primary btn-add">
                                            <i class="la la-plus"></i> Add New Admin</a>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-bordered table-hover datatable">
                                <thead>
                                    <tr>
                                        <th scope="col"> <strong> ID</th>
                                        <th scope="col"> <strong>Name </strong></th>
                                        <th scope="col d-flex justify-content-center"> <strong> Email </strong></th>
                                        <th scope="col d-flex justify-content-center"> <strong> Role </strong></th>
                                        <th scope="col d-flex justify-content-center"> <strong> Admin Image </strong>
                                        </th>
                                        <th scope="col"> Status</th>
                                        <th scope="col"> <strong> Actions </strong></th>
                                        <th scope="col"> <strong> Status </strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($superadmin as $superadmin)
                                        <tr>
                                            <th scope="row">{{ $superadmin->id }}</th>
                                            <td class="text-dark">{{ $superadmin->name }}</td>
                                            <td class="text-dark justify-content-center">{{ $superadmin->email }}</td>
                                            <td class="text-dark justify-content-center">{{ $superadmin->role }}</td>
                                            <td class="text-dark d-flex justify-content-center">
                                                @if ($superadmin->image == null)
                                                    <center><img
                                                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQdoCQ7-yS62tALBS9_FY5pExwg8Lvvsie6Iml51YO_JQ&s"
                                                            style="height:50px; width:auto;border-radius:70%;"></center>
                                                @elseif($superadmin->image_type == 1)
                                                    <center><img src="{{ asset($superadmin->image) }}"
                                                            style="height:50px; width:auto;border-radius:70%;"></center>
                                                @else
                                                    <center><img src="{{ $superadmin->image }}"
                                                            style="height:60px; width:70px;border-radius:50%;"></center>
                                                @endif
                                            </td>
                                            <td class="dc" style="padding-top:15px;">
                                                @if ($superadmin->is_active == '0')
                                                    <span class="badge bg-success"><i
                                                            class="bi bi-check-circle me-1"></i> Active</span>
                                                @else
                                                    <span class="badge bg-danger rounded-fill"><i
                                                            class="bi bi-exclamation-octagon me-1"></i>
                                                        Deactivate</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <form action={{ url('admin/edit_admin/' . $superadmin->id) }}
                                                        method="POST" style="padding-left:5px;">
                                                        {{ csrf_field() }}
                                                        <button type="submit"
                                                            class="btn btn-icon btn-circle btn-sm btn-outline-primary"
                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                            title="Edit App"
                                                            style="background: #7367EFcf;border-color:#7367EFcf;color:#ffffff !important;"><i
                                                                class="fa fa-edit"></i></button>
                                                    </form>
                                                    <form id="form_submit_{{ $superadmin->id }}"
                                                        action={{ url('admin/delete_admin/' . $superadmin->id) }}
                                                        method="POST" style="padding-left:5px;">
                                                        {{ csrf_field() }}
                                                        <button type="button"
                                                            class="btn btn-icon btn-circle btn-sm btn-outline-danger"
                                                            onclick="return validateform({{ $superadmin->id }})"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Delete App"
                                                            style="background: #EE4B2B;border-color:#EE4B2B;color:#ffffff !important"><i
                                                                class="fa fa-trash-can-arrow-up"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                            <style>
                                                .btn_status {
                                                    font-size: .70rem;
                                                    font-weight: 500;
                                                    letter-spacing: 1px;
                                                    padding: 5px 10px;
                                                    border-radius: 0.25rem;
                                                    text-transform: uppercase;
                                                    box-shadow: 0 0.125rem 0.25rem rgb(0 0 0 / 8%);
                                                }
                                            </style>
                                            <td>
                                                <form action="{{ url('admin/user_status_update') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="user_id"
                                                        value="{{ $superadmin->id }}">
                                                    @if ($superadmin->is_active == '0')
                                                        <input type="hidden" name="status" value="0">
                                                        <button type="submit" data-toggle="tooltip"
                                                            data-original-title="Enable" id="enable"
                                                            name="enable" title=""
                                                            class="btn_status btn btn-success btn-sm enable">
                                                            <i class="fa fa-solid fa-check"></i>
                                                        </button>
                                                    @else
                                                        <input type="hidden" name="status" value="1">
                                                        <button type="submit" data-toggle="tooltip"
                                                            data-original-title="Disable" id="disable"
                                                            title="" name="disable"
                                                            class="btn_status btn btn-success btn-sm"
                                                            style="background: #ffad46!important;border-color: #ffad46!important;color: #fff!important;">
                                                            <i class="fa fa-solid fa-ban"></i>
                                                        </button>
                                                    @endif
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- End Recent Sales -->
            </div>
        </section>



        <!-- container-scroller -->
        <!-- plugins:js -->
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


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
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
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.all.min.js"></script>
    
    <script>
        // Check if alert was dismissed
        const alertDismissed = localStorage.getItem('permissionAlertDismissed');
        const dismissTime = localStorage.getItem('permissionAlertDismissTime');
        const now = new Date().getTime();
        
        // Show alert only if not dismissed or dismissed more than 1 hour ago
        if (!alertDismissed || (dismissTime && now - dismissTime > 3600000)) {
            document.getElementById('permissionAlert').style.display = 'block';
        } else {
            document.getElementById('permissionAlert').style.display = 'none';
        }
    
        let autoHideTimeout;
    
        function pauseAutoHide() {
            clearTimeout(autoHideTimeout);
        }
    
        function dismissPermissionAlert(permanent = false) {
            const alert = document.getElementById('permissionAlert');
            if (alert) {
                alert.style.animation = 'fadeIn 0.4s ease-in-out reverse';
                setTimeout(() => {
                    alert.remove();
                    if (permanent) {
                        // Store dismissal for 1 hour
                        localStorage.setItem('permissionAlertDismissed', 'true');
                        localStorage.setItem('permissionAlertDismissTime', new Date().getTime());
                    }
                }, 400);
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            @if (Session::has('error'))
                Swal.fire({
                    title: "Failed!",
                    text: "{{ Session::get('error') }}",
                    icon: "error"
                });
            @elseif (Session::has('message'))
                Swal.fire({
                    title: "Good job!",
                    text: "{{ Session::get('message') }}",
                    icon: "success"
                });
            @endif
        });
    </script>
    <script>
        function validateform(val) {
            Swal.fire({
                title: 'Confirmation',
                text: 'Are you sure you want to delete?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form via AJAX
                    $('#form_submit_' + val).submit();
                }
            });
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
        $(document).ready(function() {
            $('#members_list').DataTable();
        });
    </script>

</body>

</html>
