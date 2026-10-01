<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Vidukathaigal - Vidukathaigal Info</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

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

    {{-- <!-- Templat{{ asset('e Main CSS File --> --}}
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/preloader.css') }}" rel="stylesheet">
    <style>
        .search-highlight {
            background-color: #ffff00 !important;
            padding: 2px !important;
            border-radius: 3px !important;
            font-weight: bold !important;
            color: #000 !important;
        }

        .highlight-row {
            background-color: #ffffd0 !important;
            transition: background-color 1s !important;
        }

        .search-highlight:hover {
            background-color: #ffa500 !important;
            transition: background-color 0.3s !important;
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
            <h1><i class="fa fa-puzzle-piece"></i> Vidukathaigal Info</h1>
            <nav>
                <ol class="breadcrumb">&nbsp;&nbsp;&nbsp;&nbsp;&#11162;&nbsp;&nbsp;
                    <li class="breadcrumb-item"><a href="{{ url('admin/vidukathigal_list') }}">Vidukathaigal Info</a></li>
                    <li class="breadcrumb-item active">List of Vidukathaigal Info Table</li>
                </ol>
            </nav>
        </div>
        <section class="section dashboard">
            <div class="row">

                @if (Session::has('error'))
                    <div class="alert-container">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <div>{{ Session::get('error') }}</div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
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
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    </div>
                @endif
                <!-- Recent Sales -->
                <div class="col-12">

                    @include('admin.accounts.permission', [
                        'menu' => 'vidukathaigal_menu',
                        'name' => 'Vidukathaigal',
                    ])


                    <div class="card recent-sales overflow-auto">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="card-title">Vidukathaigal Info List <span>| Today</span></h5>
                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-3">
                                    <div class="action-btn" align="right" style="padding-top:20px;padding-right:20px;">
                                        <a href="{{ url('admin/add_vidukathaigal') }}"
                                            class="btn btn-sm btn-primary btn-add">
                                            <i class="ri-add-line"></i> Add New Vidukathaigal Info </a>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-bordered table-hover yajra-datatable text-center">
                                <thead>
                                    <tr class="text-center">
                                        <th class="text-center" scope="col">Id</th>
                                        <th class="text-center" scope="col">Question</th>
                                        <th class="text-center" scope="col">Answer</th>
                                        <th class="text-center" scope="col">Hints</th>
                                        <th class="text-center" scope="col">Level</th>
                                        <th class="text-center" scope="col">created_at</th>
                                        <th class="text-center" scope="col">Status</th>
                                        <th class="text-center" scope="col">Action</th>
                                        <th class="text-center" scope="col">Active</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- End Recent Sales -->
            </div>
        </section>

        </div>
        </div>
        </div>
        <!-- page-body-wrapper ends -->
        <footer id="footer" class="footer">
            <div class="copyright">
            </div>
        </footer>

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

        <!-- vidukathaigal Main JS File -->
        <script src="{{ asset('assets/js/main.js') }}"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" crossorigin="anonymous"
            referrerpolicy="no-referrer"></script>

        <link rel="stylesheet" type="text/css"
            href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.all.min.js"></script>

        <script>
            // Check if alert was dismissed
            const alertDismissed = localStorage.getItem('vidukathaigalPermissionAlertDismissed');
            const dismissTime = localStorage.getItem('vidukathaigalPermissionAlertDismissTime');
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
                            localStorage.setItem('vidukathaigalPermissionAlertDismissed', 'true');
                            localStorage.setItem('vidukathaigalPermissionAlertDismissTime', new Date().getTime());
                        }
                    }, 400);
                }
            }
        </script>

        <script>
            $(document).ready(function() {
                var table = $('.yajra-datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    stateSave: true,
                    ajax: "{{ route('vidukathaigal.list') }}",
                    columns: [{
                            data: 'id',
                            name: 'id',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'question',
                            name: 'question'
                        },
                        {
                            data: 'answer',
                            name: 'answer'
                        },
                        {
                            data: 'hints',
                            name: 'hints'
                        },
                        {
                            data: 'levels.name',
                            name: 'levels.name'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'status_update',
                            name: 'status_update',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    order: [
                        [0, 'desc']
                    ],
                    "drawCallback": function(settings) {
                        var searchTerm = table.search();

                        if (searchTerm && searchTerm.trim() !== '') {
                            $('.yajra-datatable tbody tr td:not(:has(form))').each(function() {
                                var $cell = $(this);
                                if ($cell.find('button, input').length === 0) {
                                    var cellHtml = $cell.html();
                                    var highlightedHtml = highlightSearchTerm(cellHtml, searchTerm);
                                    $cell.html(highlightedHtml);
                                }
                            });
                        }

                        if (window.location.hash) {
                            var rowId = window.location.hash.substring(1);
                            var targetRow = $('div[id="' + rowId + '"]').closest('tr');

                            if (targetRow.length) {
                                setTimeout(function() {
                                    var scrollPosition = targetRow.offset().top - 100;
                                    $('html, body').animate({
                                        scrollTop: scrollPosition
                                    }, 500);

                                    targetRow.addClass('highlight-row');
                                    setTimeout(function() {
                                        targetRow.removeClass('highlight-row');
                                    }, 3000);
                                }, 200);
                            }
                        }
                    }
                });


                function highlightSearchTerm(text, searchTerm) {
                    if (!searchTerm || searchTerm.trim() === '') {
                        return text;
                    }

                    if (typeof text === 'string' && text.indexOf('<') > -1) {
                        var matches = [];
                        var textOnly = text.replace(/<[^>]*>/g, function(match) {
                            matches.push(match);
                            return '\u0001';
                        });

                        var searchRegex = new RegExp('(' + searchTerm.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')',
                            'gi');
                        textOnly = textOnly.replace(searchRegex, '<span class="search-highlight">$1</span>');

                        return textOnly.replace(/\u0001/g, function() {
                            return matches.shift();
                        });
                    } else {
                        var searchRegex = new RegExp('(' + searchTerm.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')',
                            'gi');
                        return text.replace(searchRegex, '<span class="search-highlight">$1</span>');
                    }
                }

                $('.dataTables_filter input').on('keyup', function() {
                    table.draw();
                });

                setTimeout(function() {
                    if (window.location.hash) {
                        history.replaceState(null, null, window.location.pathname + window.location.search);
                    }
                }, 4000);
            });

            // $(document).ready(function() {
            //     toastr.options = {
            //         "closeButton": true,
            //         "progressBar": true
            //     }
            //     @if (Session::has('error'))
            //         toastr.error("{{ Session::get('error') }}");
            //     @elseif (Session::has('message'))
            //         toastr.success("{{ Session::get('message') }}");
            //     @endif
            // });

            // Preloader
            window.addEventListener('load', function() {
                const preloader = document.getElementById('pre-loader');
                preloader.style.opacity = '0';
                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 500);
            });

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
                        $('#form_submit_' + val).submit();
                    }
                });
            }
        </script>

</body>

</html>
